<?php
/**
 * Created by PhpStorm.
 * User: rolfguescini
 * Date: 03.08.17
 * Time: 14:31
 */

namespace App\Laudatio\GitLab;

use App\Custom\GitRepoInterface;
use App\Laudatio\GitLaB\GitFunction;
use App\Custom\LaudatioUtilsInterface;
use Illuminate\Http\Request;
use GrahamCampbell\Flysystem\FlysystemManager;
use Carbon\Carbon;
use Log;
use App\Corpus;
use App\Document;
use App\Annotation;
use App\User;
use App\CorpusProject;

class GitRepoService implements GitRepoInterface
{
    protected $basePath;
    protected $scriptPath;
    protected $laudatioUtilsService;

    public function __construct(LaudatioUtilsInterface $laudatioUtilsService)
    {
        $this->basePath = config('laudatio.basePath');
        $this->scriptPath = config('laudatio.scriptPath');
        $this->laudatioUtilsService = $laudatioUtilsService;
    }

    public function createProjectFileStructure($flysystem,$projectName){
        $path = $this->normalizeString($projectName);

        if(!$flysystem->has($path)){
            $flysystem->createDir($path);
        }

        return $path;
    }


    public function createCorpusFileStructure($flysystem,$corpusProjectPath,$corpusName){
        $corpusPath = $this->normalizeString($corpusName);
        $dirPath = $corpusProjectPath.'/'.$corpusPath;

        if(!$flysystem->has($dirPath)){
            $flysystem->createDir($dirPath);
            $flysystem->createDir($dirPath."/githooks");
            $flysystem->createDir($dirPath."/TEI-HEADERS");
            $flysystem->createDir($dirPath."/TEI-HEADERS/corpus");
            $flysystem->write($dirPath."/TEI-HEADERS/corpus/README.md","#CORPUS HEADERS#\n This folder holds Corpus header meta data");
            $flysystem->createDir($dirPath."/TEI-HEADERS/document");
            $flysystem->write($dirPath."/TEI-HEADERS/document/README.md","#DOCUMENT HEADERS#\n This folder holds Document header meta data");
            $flysystem->createDir($dirPath."/TEI-HEADERS/annotation");
            $flysystem->write($dirPath."/TEI-HEADERS/annotation/README.md","#ANNOTATION HEADERS#\n This folder holds Annotation header meta data");
            $flysystem->createDir($dirPath."/CORPUS-DATA");

            $initiated = $this->initiateRepository($dirPath);
            if($initiated){
                $this->copyGitHooks($dirPath);
                $this->setCoreHooksPath($dirPath);
                $this->copyScripts($dirPath);
            }

        }

        return $corpusPath;
    }

    public function hasCorpusFileStructure($flysystem , $corpusProjectPath, $corpusPath){
        return $flysystem->has($this->basePath."/".$corpusProjectPath."/".$corpusPath);
    }


    public function checkForCorpusFiles($path) {
        $gitFunction = new GitFunction();
        $fullPath = $this->basePath.'/'.$path;
        return $gitFunction->checkForCorpusFiles($fullPath);
    }

    public function updateCorpusFileStructure($flysystem,$corpusProjectPath,$oldCorpusPath,$corpusName){
        $corpusPath = "";
        $normalizedCorpusName = $this->normalizeString($corpusName);
        $oldDirPath = $corpusProjectPath.'/'.$oldCorpusPath;

        if($flysystem->has($oldDirPath)){
            $gitFunction = new GitFunction();
            $corpusPath = $gitFunction->renameFile($corpusProjectPath,$oldCorpusPath,$normalizedCorpusName);
        }
        return $corpusPath;
    }

    public function commitStagedFiles($corpusPath) {
        $this->addFilesToRepository($corpusPath,"TEI-HEADERS");
        $stagedFiles = $gitFunction->getListOfStagedFiles($this->basePath."/".$corpusPath);
        $this->commitFilesToRepository($this->basePath.'/'.$corpusPath,"Created initial corpus file structure for $normalizedCorpusName");
        foreach ($stagedFiles as $stagedFile){
            $dirArray = explode("/",trim($stagedFile));
            dd($dirArray);
            if($dirArray[0] != "CORPUS-DATA"){
                if(count($dirArray) > 1){
                    $fileName = $dirArray[2];
                    $this->laudatioUtilsService->setVersionMapping($fileName,$dirArray[1],false);
                }
            }
        }
    }

    /**
     * Delete a corpus file structure on the disk
     * @param $flysystem
     * @param $path
     * @return bool|null
     */
    public function deleteCorpusFileStructure($flysystem, $path){
        $deleted = false;
        $trackedResult = $this->deleteFile($flysystem,$path);

        if(!$trackedResult){
            $deleted = $this->deleteUntrackedFile($flysystem,$path,false,true);
        }
        else{
            $deleted = $trackedResult;
        }
        return $deleted;
    }


    public function deleteProjectFileStructure($flysystem, $path){
        $deleted = false;
        $trackedResult = $this->deleteFile($flysystem,$path);

        if(!$trackedResult){
            $deleted = $this->deleteUntrackedFile($flysystem,$path,true,false);
        }
        else{
            $deleted = $trackedResult;
        }
        return $deleted;
    }

    public function getCorpusFiles($flysystem,$corpusid,$path = ""){

        $corpus = Corpus::find($corpusid);

        $corpusProjects = $corpus->corpusprojects()->get();
        $corpusProject_directory_path = '';

        $pathArray = explode("/",$path);
        end($pathArray);
        $last_id=key($pathArray);

        if(count($corpusProjects) == 1) {
            $corpusProject_directory_path = $corpusProjects->first()->directory_path;
        }
        else{
            // what to do when we can assign corpora to many projects?
        }

        $corpusPath = "";
        $corpus_directory_path = $corpus->directory_path;
        if($path == ""){
            $corpusPath = $corpusProject_directory_path."/".$corpus_directory_path;
        }
        else{
            $corpusPath = $path;
        }

        $corpusBasePath = "";//substr($corpusPath,0,strrpos($corpusPath,"/"));


        $fileData = array(
            "corpusData" => array(
                'path' => $corpusPath.'/CORPUS-DATA',
                'hasdir' => false
            ),
            "corpusDataFolder" => "",
            "headerData" => array(
                'path' => $corpusPath.'/TEI-HEADERS',
                'hasdir' => false
            ),
            "headerDataFolder" => "",
            "folderType" => ""
        );

        $folder = "";
        $folderType = "";
        $user_roles = array();
        if(strpos($corpusPath,"Untitled") === false){
            $corpusBasePath = $pathArray[0]."/".$pathArray[1];
            if(strpos($corpusPath,"CORPUS-DATA") !== false && strpos($corpusPath,"TEI-HEADERS") === false){
                $corpusData = $this->getCorpusDataFiles($flysystem,$corpusPath);
                $headerData = $this->getCorpusFileInfo($flysystem,$corpusBasePath.'/TEI-HEADERS');
                $folderType = "CORPUS-DATA";

            }
            else if(strpos($corpusPath,"TEI-HEADERS") !== false && strpos($corpusPath,"CORPUS-DATA") === false){
                $corpusData = $this->getCorpusDataFiles($flysystem,$corpusBasePath.'/CORPUS-DATA');
                $headerData = $this->getCorpusFileInfo($flysystem, $corpusPath);
                $folderType = "TEI-HEADERS";
            }
            else{
                $corpusData = $this->getCorpusDataFiles($flysystem,$corpusPath.'/CORPUS-DATA');
                $headerData = $this->getCorpusFileInfo($flysystem,$corpusPath.'/TEI-HEADERS');
            }


            $corpusDataFolder = substr($corpusData['path'],strrpos($corpusData['path'],"/")+1);
            $headerDataFolder = substr($headerData['path'],strrpos($headerData['path'],"/")+1);
            $fileData = array(
                "corpusData" => $corpusData,
                "corpusDataFolder" => $corpusDataFolder,
                "headerData" => $headerData,
                "headerDataFolder" => $headerDataFolder,
                "folderType" => $folderType
            );

/*
            $corpusUsers = $corpus->users()->get();

            foreach ($corpusUsers as $corpusUser){
                if(!isset($user_roles[$corpusUser->id])){
                    $user_roles[$corpusUser->id] = array();
                }

                $role = Role::find($corpusUser->pivot->role_id);
                if($role){
                    array_push($user_roles[$corpusUser->id],$role->name);
                }

            }
*/
        }
        return $fileData;
    }
    public function getUploader($headerData,$headertype){

        //dd($headerData);
        for($i = 0; $i < count($headerData); $i++){
            $extension = $headerData[$i]['extension'];
            $basename = $headerData[$i]['basename'];
            if($extension == "xml") {
                $obrect = null;
                switch ($headertype){
                    case 'corpus':
                        $object = Corpus::where(['file_name' => $basename])->get();
                        break;
                    case 'document':
                        $object = Document::where(['file_name' => $basename])->get();
                        break;
                    case 'annotation':
                        $object = Annotation::where(['file_name' => $basename])->get();
                        break;
                }

                if(isset($object[0]) && $object[0]->uid != ""){
                    $uploader = User::find($object[0]->uid);
                    $headerData[$i]['uploader_affiliation'] = $uploader->affiliation;
                    $headerData[$i]['uploader_name'] = $uploader->name;
                    $headerData[$i]['uploader_uid'] = $uploader->id;
                }
                else{
                    $headerData[$i]['uploader_affiliation'] = "NA";
                    $headerData[$i]['uploader_name'] = "NA";
                    $headerData[$i]['uploader_uid'] = "NA";
                }
            }
        }

        return $headerData;

    }
    public function getCorpusFileInfo($flysystem, $path = ""){
        $gitFunction = new GitFunction();
        $hasDir = false;
        $projects = array();


        if($path == ""){
            $projects = $flysystem->listContents();
        }
        else{
            $projects = $flysystem->listContents($path);
        }


        $pathArray = explode("/",$path);
        end($pathArray);
        $last_id = key($pathArray);


        for ($i = 0; $i < count($projects);$i++){
            $foldercount = count($flysystem->listContents($projects[$i]['path']));
            $projects[$i]['foldercount'] = $foldercount;
            if($gitFunction->isTracked($this->basePath."/".$projects[$i]['path'])){
                $projects[$i]['tracked'] = "true";
            }
            else{
                $projects[$i]['tracked'] = "false";
            }

            $headerObject = $this->laudatioUtilsService->getModelByFileName($projects[$i]['basename'],$pathArray[$last_id],false);
            if(count($headerObject) > 0){
                $projects[$i]['headerObject'] = $headerObject[0];
            }


            $projects[$i]['lastupdated'] = Carbon::createFromTimestamp($projects[$i]['timestamp'])->toDateTimeString();

            if($projects[$i]["type"] == "dir"){
                $hasDir = true;
            }


            $projects[$i]['filesize'] = $this->calculateFileSize(filesize($this->basePath."/".$projects[$i]['path']));
            $hasDiff = $gitFunction->hasDiff($this->basePath."/".$projects[$i]['path']);


            if($hasDiff){
                $projects[$i]['hasDiff'] = "true";
            }
            else{
                $projects[$i]['hasDiff'] = "false";
            }

            if($projects[$i]['hasDiff'] == "true"){
                $projects[$i]['diffFiles'] = array();
                array_push($projects[$i]['diffFiles'],$hasDiff);
            }

        }

        $patharray = explode("/",$path);
        $count = count($patharray);
        $projects = $this->filterDottedFiles($projects);

        $previouspath = "";

        /*
        if(strpos($path,"show") !== false){
            $previouspath = substr($path,0,strrpos($path,"/"));
        }
        else{
            $previouspath = $path;
        }
        */
        $previouspath = substr($path,0,strrpos($path,"/"));


        return array(
            "elements" => $projects,
            "headertype" => $pathArray[$last_id],
            "hasdir" => $hasDir,
            "pathcount" => $count,
            "path" => $path,
            "previouspath" => $previouspath,
        );
    }

    public function getCorpusDataFiles($flysystem,$path = ""){
        $gitFunction = new GitFunction();
        $hasDir = false;
        $projects = array();


        if($path == ""){
            $projects = $flysystem->listContents();
        }
        else{
            $projects = $flysystem->listContents($path);
        }


        $pathArray = explode("/",$path);
        end($pathArray);
        $last_id = key($pathArray);


        //dd($projects);
        for ($i = 0; $i < count($projects);$i++){
            $foldercount = count($flysystem->listContents($projects[$i]['path']));
            $projects[$i]['foldercount'] = $foldercount;

            if($gitFunction->isTracked($this->basePath."/".$projects[$i]['path'])){
                $projects[$i]['tracked'] = "true";
            }
            else{
                $projects[$i]['tracked'] = "false";
            }


            $projects[$i]['lastupdated'] = Carbon::createFromTimestamp($projects[$i]['timestamp'])->toDateTimeString();
            //Carbon::parse($projects[$i]['timestamp'])->toDateTimeString()->format('H:i, M d');
            if($projects[$i]["type"] == "dir"){
                $hasDir = true;
            }

            $projects[$i]['filesize'] = $this->calculateFileSize(filesize($this->basePath."/".$projects[$i]['path']));
            $hasDiff = $gitFunction->hasDiff($this->basePath."/".$projects[$i]['path']);


            if($hasDiff){
                $projects[$i]['hasDiff'] = "true";
            }
            else{
                $projects[$i]['hasDiff'] = "false";
            }

            if($projects[$i]['hasDiff'] == "true"){
                $projects[$i]['diffFiles'] = array();
                array_push($projects[$i]['diffFiles'],$hasDiff);
            }
/*
            $user = User::where('file_name',$projects[$i]['path']);
            Log::info("JUSER: ".print_r($user, 1));
            $projects[$i]['user'] = $user->name;
*/
        }

        $patharray = explode("/",$path);
        $count = count($patharray);
        $projects = $this->filterDottedFiles($projects);
        $previouspath = substr($path,0,strrpos($path,"/"));


        return array(
            "projects" => $projects,
            "hasdir" => $hasDir,
            "pathcount" => $count,
            "path" => $path,
            "previouspath" => $previouspath,
        );
    }

    function calculateFileSize($size,$accuracy=2) {
        $output = 0;
        $units = array(' Bytes',' KB',' Mb',' Gb');
        foreach($units as $n=>$u) {
            $div = pow(1024,$n);
            if($size > $div) $output = number_format($size/$div,$accuracy).$u;
        }
        return $output;
    }


    public function deleteFile($flysystem, $path){
        $result = null;
        if($flysystem->has($path)){
            $gitFunction = new  GitFunction();
            $isTracked = $gitFunction->isTracked($this->basePath."/".$path);
            if($isTracked){
                $result = $gitFunction->deleteFiles($path);
            }
        }
        return $result;
    }

    public function deleteUntrackedFile($flysystem,$path,$isProject = false,$isCorpus = false){

        $result = null;
        if($flysystem->has($path)){
            $gitFunction = new  GitFunction();
            $result = $gitFunction->deleteUntrackedFiles($path,$isProject,$isCorpus);
        }
        return $result;
    }

    public function deleteUntrackedDataFile($flysystem,$path){

        $result = null;
        if($flysystem->has($path)){
            $gitFunction = new  GitFunction();
            $result = $gitFunction->deleteUntrackedDataFiles($path);
        }
        return $result;
    }


    public function addFilesToRepository($path,$file){
        $gitFunction = new  GitFunction();
        $isAdded = $gitFunction->addUntracked($path,$file);
        return $isAdded;
    }

    public function addFiles($path,$corpus){
        $pathWithOutAddedFolder = substr($path,0,strrpos($path,"/"));
        $file = substr($path,strrpos($path,"/")+1);
        $isAdded = $this->addFilesToRepository($pathWithOutAddedFolder,$file);
        return $isAdded;
    }

    public function addHooks($path){
        $gitFunction = new  GitFunction();
        return $gitFunction->addGitHooks($path);
    }


    public function pushFiles($dirname,$corpusid,$user){
        $gitFunction = new  GitFunction();
        return $gitFunction->pushFiles($dirname,$corpusid);
    }

    public function initialPush($path,$user) {
        $gitFunction = new  GitFunction();
        return $gitFunction->initialPush($path,$user);
    }

    public function commitFiles($dirname = "", $commitmessage, $corpusid, $user){
        $isHeader = false;
        if(strpos($dirname,'TEI-HEADER') !== false){
            $isHeader = true;
        }
        $gitFunction = new  GitFunction();
        $patharray = explode("/",$dirname);
        end($patharray);
        $last_id = key($patharray);

        $object = null;
        $returnPath = "";
        $fileName = substr($dirname, strrpos($dirname,"/")+1);
        $pathWithOutAddedFolder = substr($dirname,0,strrpos($dirname,"/"));

        if(is_dir($this->basePath.'/'.$dirname)){
            $stagedFiles = $gitFunction->getListOfStagedFiles($this->basePath."/".$dirname);
            $isCommited = $gitFunction->commitFiles($this->basePath."/".$dirname,$commitmessage,$corpusid);

            if($isCommited){
                if($isHeader){
                    foreach ($stagedFiles as $stagedFile){
                        $dirArray = explode("/",trim($stagedFile));
                        if(count($dirArray) >= 3){
                            $fileName = $dirArray[2];

                            if(is_dir($this->basePath.'/'.$dirname.'/'.$fileName)){
                                $object = $this->laudatioUtilsService->getModelByFileName($fileName,$patharray[$last_id], true);
                                if(count($object) > 0){
                                    $this->laudatioUtilsService->setVersionMapping($fileName,$patharray[$last_id],true);
                                    $fileName = $object[0]->directory_path;
                                }
                            }
                            else{
                                $object = $this->laudatioUtilsService->getModelByFileName($fileName,$patharray[$last_id], false);
                                if(count($object) > 0){
                                    $this->laudatioUtilsService->setVersionMapping($fileName,$patharray[$last_id],false);
                                    $fileName = $object[0]->directory_path;
                                }

                            }
                        }
                    }

                }

                $returnPath = $dirname;
            }
        }
        else{
            $isCommited = $gitFunction->commitFiles($this->basePath."/".$pathWithOutAddedFolder,$commitmessage,$corpusid);
            if($isCommited){
                if($isHeader){
                    $this->laudatioUtilsService->setVersionMapping($fileName,$patharray[($last_id-1)],false);
                    $object = $this->laudatioUtilsService->getModelByFileName($fileName,$patharray[($last_id-1)], false);
                }

                $returnPath = $pathWithOutAddedFolder;
            }
        }

        $commitdata = $this->getCommitData($pathWithOutAddedFolder);

        if($isHeader){
            if(is_dir($this->basePath.'/'.$dirname)){
                if(count($object) > 0){
                    if($object[0]->directory_path == $fileName){
                        $object[0]->gitlab_commit_sha = $commitdata['sha_string'];
                        $object[0]->gitlab_commit_date = $commitdata['date'];
                        $object[0]->gitlab_commit_description = $commitdata['message'];
                        $object[0]->save();
                    }
                }
            }
            else{
                if(count($object) > 0){
                    if($object[0]->file_name == $fileName){
                        $object[0]->gitlab_commit_sha = $commitdata['sha_string'];
                        $object[0]->gitlab_commit_date = $commitdata['date'];
                        $object[0]->gitlab_commit_description = $commitdata['message'];
                        $object[0]->save();
                    }
                }
            }

        }
        return $returnPath;
    }

    public function initiateRepository($path){
        $gitFunction = new GitFunction();
        $isInitiated = $gitFunction->initiateRepository($path);
        return $isInitiated;
    }

    public function addRemote($origin,$path){
        $gitFunction = new GitFunction();
        //git@gitlab.com:Username/Project.git

        $isRemoteAdded = $gitFunction->addRemote($origin,$path);
        return $isRemoteAdded;
    }

    public function copyGitHooks($path){
        $gitFunction = new  GitFunction();
        return $gitFunction->copyGitHooks($path);
    }

    public function setCoreHooksPath($path){
        $gitFunction = new  GitFunction();
        return $gitFunction->setCoreHooksPath($path);
    }

    public function copyScripts($path){
        $gitFunction = new  GitFunction();
        return $gitFunction->copyScripts($path);
    }


    public function commitFilesToRepository($path,$commitMessage){
        $isCommitted = false;
        $gitFunction = new  GitFunction();
        $commit = $gitFunction->commitFiles($path,$commitMessage);
        $commitStatus = $gitFunction->getStatus($path);

        if($gitFunction->isCleanWorkingTree($commitStatus)){
            $isCommitted = true;
        }
        return $isCommitted;
    }

    public function getCommitData($path){
        $gitFunction = new GitFunction();
        return $gitFunction->getCommitData($path);
    }


    /**
     * HELPERS
     */

    public function filterDottedFiles($array){
        $projects = array();
        foreach ($array as $item){
            $pos = strpos($item['basename'],".");
            if($pos === false || ($pos > 0)){
                array_push($projects,$item);
            }
        }

        return $projects;
    }

    public function normalizeString ($str = '')
    {
        $str = strip_tags($str);
        $str = preg_replace('/[\r\n\t ]+/', ' ', $str);
        $str = preg_replace('/[\"\*\/\:\<\>\?\'\|]+/', ' ', $str);
        $str = strtolower($str);
        $str = html_entity_decode( $str, ENT_QUOTES, "utf-8" );
        $str = htmlentities($str, ENT_QUOTES, "utf-8");
        $str = preg_replace("/(&)([a-z])([a-z]+;)/i", '$2', $str);
        $str = str_replace(' ', '-', $str);
        $str = rawurlencode($str);
        $str = str_replace('%', '-', $str);
        $str = str_replace('.', '-', $str);
        return $str;
    }

    public function normalizeTitle ($str = '')
    {
        $str = strip_tags($str);
        $str = preg_replace('/[\r\n\t ]+/', ' ', $str);
        $str = preg_replace('/[\"\*\/\:\<\>\?\'\|]+/', ' ', $str);
        $str = html_entity_decode( $str, ENT_QUOTES, "utf-8" );
        $str = htmlentities($str, ENT_QUOTES, "utf-8");
        $str = preg_replace("/(&)([a-z])([a-z]+;)/i", '$2', $str);
        return $str;
    }


}
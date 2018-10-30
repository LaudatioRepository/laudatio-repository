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
use App\CorpusFile;
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


    public function createCorpusFileStructure($flysystem,$corpusProjectPath,$corpusName,$user){
        $corpusPath = $this->normalizeString($corpusName);
        $dirPath = $corpusProjectPath.'/'.$corpusPath;

        if(!$flysystem->has($dirPath)){
            $flysystem->createDir($dirPath);
            $flysystem->createDir($dirPath."/githooks");
            $flysystem->createDir($dirPath."/TEI-HEADERS");
            $flysystem->createDir($dirPath."/TEI-HEADERS/corpus");
            $flysystem->write($dirPath."/TEI-HEADERS/corpus/README.md","# CORPUS HEADERS #\n This folder contains Corpus header meta data");
            $flysystem->createDir($dirPath."/TEI-HEADERS/document");
            $flysystem->write($dirPath."/TEI-HEADERS/document/README.md","# DOCUMENT HEADERS #\n This folder contains Document header meta data");
            $flysystem->createDir($dirPath."/TEI-HEADERS/annotation");
            $flysystem->write($dirPath."/TEI-HEADERS/annotation/README.md","# ANNOTATION HEADERS #\n This folder contains Annotation header meta data");
            $flysystem->createDir($dirPath."/CORPUS-DATA");
            $flysystem->write($dirPath."/CORPUS-DATA/README.md","# CORPUS DATA #\n This folder contains the Corpus Data itself");
            $flysystem->createDir($dirPath."/CORPUS-IMAGES");
            $flysystem->write($dirPath."/CORPUS-IMAGES/README.md","# CORPUS IMAGES #\n This folder contains any images associated with the corpus");

            $initiated = $this->initiateRepository($dirPath);
            if($initiated){
                $this->setGitConfig($dirPath,
                    array(
                        "core.precomposeUnicode false",
                        "core.quotepath false"
                    ));
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

    public function commitStagedFiles($corpusPath,$corpusId) {
        $this->addFilesToRepository($corpusPath,"TEI-HEADERS");
        $stagedFiles = $gitFunction->getListOfStagedFiles($this->basePath."/".$corpusPath);
        $this->commitFilesToRepository($this->basePath.'/'.$corpusPath,"Created initial corpus file structure for $normalizedCorpusName");
        foreach ($stagedFiles as $stagedFile){
            $dirArray = explode("/",trim($stagedFile));
            dd($dirArray);
            if($dirArray[0] != "CORPUS-DATA"){
                if(count($dirArray) > 1){
                    $fileName = $dirArray[2];
                    $this->laudatioUtilsService->setVersionMapping($fileName,$dirArray[1],false,$corpusId);
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

        $corpusBasePath = $pathArray[0]."/".$pathArray[1];
        if(strpos($corpusPath,"CORPUS-DATA") !== false && strpos($corpusPath,"TEI-HEADERS") === false){
            $corpusData = $this->getCorpusDataFiles($flysystem,$corpusPath,$corpusid);
            $headerData = $this->getCorpusFileInfo($flysystem,$corpusBasePath.'/TEI-HEADERS',$corpusid);
            $folderType = "CORPUS-DATA";

        }
        else if(strpos($corpusPath,"TEI-HEADERS") !== false && strpos($corpusPath,"CORPUS-DATA") === false){
            $corpusData = $this->getCorpusDataFiles($flysystem,$corpusBasePath.'/CORPUS-DATA',$corpusid);
            $headerData = $this->getCorpusFileInfo($flysystem, $corpusPath,$corpusid);
            $folderType = "TEI-HEADERS";
        }
        else{
            $corpusData = $this->getCorpusDataFiles($flysystem,$corpusPath.'/CORPUS-DATA',$corpusid);
            $headerData = $this->getCorpusFileInfo($flysystem,$corpusPath.'/TEI-HEADERS',$corpusid);
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

        return $fileData;
    }
    public function getUploader($headerData,$headertype){
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
                    case 'formatfiles':
                        $object = CorpusFile::where(['file_name' => $basename])->get();
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
        public function getCorpusFileInfo($flysystem, $path = "",$corpusId){
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

            if(isset($projects[$i]['extension'])) {
                if($projects[$i]['extension'] == "md") {
                    unset($projects[$i]);
                    continue;
                }
            }

            $foldercount = count($flysystem->listContents($projects[$i]['path']));
            $projects[$i]['foldercount'] = $foldercount;
            if($gitFunction->isTracked($this->basePath."/".$projects[$i]['path'])){
                $projects[$i]['tracked'] = "true";
            }
            else{
                $projects[$i]['tracked'] = "false";
            }


            $headerObject = $this->laudatioUtilsService->getModelByFileName($projects[$i]['basename'],$pathArray[$last_id],false,$corpusId);
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

    public function getCorpusDataFiles($flysystem,$path = "",$corpusId){
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

        }

        $patharray = explode("/",$path);
        $count = count($patharray);
        $projects = $this->filterDottedFiles($projects);
        $projects = $this->filterMDFiles($projects);
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


    public function deleteFile($flysystem, $path, $user,$email){
        $result = null;
        if($flysystem->has($path)){
            log::info("WE HAVE PAF: ".print_r($path,1));
            $gitFunction = new  GitFunction();
            $isTracked = $gitFunction->isTracked($this->basePath."/".$path);

            if($isTracked){
                log::info("IZTRACKED: ".print_r($this->basePath."/".$path,1));
                $result = $gitFunction->deleteFiles($path,$user,$email);
            }
            else {
                log::info("IZNOTTRACKED: ".print_r($this->basePath."/".$path,1));
                $result = $gitFunction->deleteUntrackedFiles($path,false,false);
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
        if(!$isAdded) {
            $isAdded = $gitFunction->addModified($path, $file);
        }
        return $isAdded;
    }



    public function addFiles($flysystem, $path) {
        $isAdded = false;
        try{
            if(is_dir($this->basePath."/".$path)) {
                $contents = $flysystem->listContents($path, true);
                foreach ($contents as $pathElm) {
                    if($pathElm['type'] == "file" && strpos($pathElm['path'], '.git') === false && strpos($pathElm['path'], 'githooks') === false) {
                        $isAdded = $this->addFilesToRepository($pathElm['dirname'],$pathElm['basename']);
                    }
                }
            }
            else {
                $pathWithOutAddedFolder = substr($path,0,strrpos($path,"/"));
                $file = substr($path,strrpos($path,"/")+1);
                $isAdded = $this->addFilesToRepository($pathWithOutAddedFolder,$file);
            }
        }
        catch(Exception $e) {
            $isAdded = false;
            Log::info("addFiles: error: ".$e->getMessage());
        }

        return $isAdded;
    }

    public function addHooks($path, $user, $email){
        $gitFunction = new  GitFunction();
        return $gitFunction->addGitHooks($path, $user, $email);
    }


    public function pushFiles($dirname,$corpusid,$user){
        $gitFunction = new  GitFunction();
        return $gitFunction->pushFiles($dirname,$corpusid);
    }

    public function initialPush($path,$user) {
        $gitFunction = new  GitFunction();
        return $gitFunction->initialPush($path,$user);
    }

    public function resetAdd($path,$files){
        $gitFunction = new  GitFunction();
        return $gitFunction->resetAdd($path, $files);
    }

    /**
     * commitFiles by file path
     * @param string $dirname
     * @param $commitmessage
     * @param $corpusid
     * @param $user
     * @param $email
     * @return array|null
     */
    public function commitFiles($dirname = "", $commitmessage, $corpusid, $user, $email){
        $commitDataArray = array();
        $gitFunction = new  GitFunction();
        $pathWithOutAddedFolder = substr($dirname,0,strrpos($dirname,"/"));

        $stagedFiles = $gitFunction->getListOfStagedFiles($this->basePath."/".$dirname);

        foreach ($stagedFiles as $stagedFile){
            $stagedfileArray = explode("/",$stagedFile);

            if(isset($stagedfileArray[2])){
                $isCommited = $gitFunction->commitFile($this->basePath."/".$dirname."/".$stagedfileArray[1],$stagedfileArray[2],$commitmessage,$user,$email);
            }
            else {
                $dirPathArray = explode("/", $dirname);
                $newpath = $dirPathArray[0]."/".$dirPathArray[1];
                if(is_array($stagedfileArray[0] && empty($stagedfileArray[1]))) {
                    $isCommited = $gitFunction->commitFiles($this->basePath."/".$newpath,$commitmessage,$user,$email);
                }
                else {
                    $isCommited = $gitFunction->commitFile($this->basePath."/".$newpath."/".$stagedfileArray[0],$stagedfileArray[1],$commitmessage,$user,$email);
                }


            }
            if($isCommited){
                $commitData = $this->getCommitData($pathWithOutAddedFolder);
                $commitDataArray[$stagedFile] = $commitData;
            }
        }

        return $commitDataArray;
    }


    public function commitFile($dirname = "", $commitmessage, $corpusid, $user, $email){
        $commitdata = null;

        $gitFunction = new  GitFunction();

        $pathWithOutAddedFolder = substr($dirname,0,strrpos($dirname,"/"));

        $isCommited = $gitFunction->commitFiles($this->basePath."/".$pathWithOutAddedFolder,$commitmessage,$user,$email);

        if($isCommited){
            $commitdata = $this->getCommitData($pathWithOutAddedFolder);
        }

        return $commitdata;
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

    public function setGitConfig($path,$configs) {
        $gitFunction = new  GitFunction();
        return $gitFunction->setGitConfig($path,$configs);
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

    public function setCorpusVersionTag($corpusPath, $tagmessage, $version, $user,$email,$blame = true){
        $isTagged = false;
        $gitFunction = new  GitFunction();
        $tag = $gitFunction->setCorpusVersionTag($corpusPath,$tagmessage,$version,$user,$email, $blame);
        if($tag){
            $isTagged = true;
        }
        return $isTagged;
    }

    public function setInitialCorpusVersionTag($corpusPath, $tagmessage, $version, $user,$email){
        $isTagged = false;
        $gitFunction = new  GitFunction();
        $tag = $gitFunction->setInitialCorpusVersionTag($corpusPath,$tagmessage,$version,$user,$email);
        if($tag){
            $isTagged = true;
        }
        return $isTagged;
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

    public function filterMDFiles($array){
        $projects = array();
        foreach ($array as $item){
            $pos = strpos($item['basename'],".md");
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
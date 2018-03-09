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
use App\CorpusProject;

class GitRepoService implements GitRepoInterface
{
    protected $basePath;
    protected $laudatioUtilsService;

    public function __construct(LaudatioUtilsInterface $laudatioUtilsService)
    {
        $this->basePath = config('laudatio.basePath');
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
            $flysystem->createDir($dirPath."/TEI-HEADERS");
            $flysystem->createDir($dirPath."/TEI-HEADERS/corpus");
            $flysystem->write($dirPath."/TEI-HEADERS/corpus/.info","Corpus header files for ".$corpusName);
            $flysystem->createDir($dirPath."/TEI-HEADERS/document");
            $flysystem->write($dirPath."/TEI-HEADERS/document/.info","Document header file structure for ".$corpusName);
            $flysystem->createDir($dirPath."/TEI-HEADERS/annotation");
            $flysystem->write($dirPath."/TEI-HEADERS/annotation/.info","Annotation header file structure for ".$corpusName);
            $flysystem->createDir($dirPath."/CORPUS-DATA");

            //$this->initiateRepository($dirPath);
            //$this->addFilesToRepository($dirPath,"TEI-HEADERS");
            //$this->commitFilesToRepository($this->basePath.'/'.$dirPath,"Created initial corpus file structure for $corpusName");
            //$this->copyGitHooks($dirPath);
            //$this->copyScripts($dirPath);

        }

        return $corpusPath;
    }

    public function hasCorpusFileStructure($flysystem , $corpusProjectPath, $corpusPath){
        return $flysystem->has($this->basePath."/".$corpusProjectPath."/".$corpusPath);
    }

    public function updateCorpusFileStructure($flysystem,$corpusProjectPath,$oldCorpusPath,$corpusName){
        $corpusPath = "";
        $normalizedCorpusName = $this->normalizeString($corpusName);
        $oldDirPath = $corpusProjectPath.'/'.$oldCorpusPath;

        if($flysystem->has($oldDirPath)){
            $gitFunction = new GitFunction();
            $corpusPath = $gitFunction->renameFile($corpusProjectPath,$oldCorpusPath,$normalizedCorpusName);
            $this->initiateRepository($corpusPath);
            $this->copyGitHooks($corpusPath);
            $this->copyScripts($corpusPath);
            $this->addFilesToRepository($corpusPath,"TEI-HEADERS");
            $stagedFiles = $gitFunction->getListOfStagedFiles($this->basePath."/".$corpusPath);
            $this->commitFilesToRepository($this->basePath.'/'.$corpusPath,"Created initial corpus file structure for $normalizedCorpusName");
            foreach ($stagedFiles as $stagedFile){
                $dirArray = explode("/",trim($stagedFile));
                if($dirArray[0] != "CORPUS-DATA"){
                    if(count($dirArray) > 1){
                        $fileName = $dirArray[2];
                        $this->laudatioUtilsService->setVersionMapping($fileName,$dirArray[1],false);
                    }
                }
            }
        }
        return $corpusPath;
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

    public function getCorpusFiles($flysystem,$path = ""){
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
            "projects" => $projects,
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
        Log::info("PATH: ".$path);
        $file = substr($path,strrpos($path,"/")+1);
        Log::info("pathWithOutAddedFolder: ".$pathWithOutAddedFolder." FILE: ".$file);
        $isAdded = $this->addFilesToRepository($pathWithOutAddedFolder,$file);
        return $isAdded;
    }


    public function commitFiles($dirname = "", $commitmessage, $corpusid){
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

    public function copyGitHooks($path){
        $gitFunction = new  GitFunction();
        return $gitFunction->copyGitHooks($path);
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
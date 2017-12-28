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
use App\Laudatio\Utils\LaudatioUtilService;
use Illuminate\Http\Request;
use GrahamCampbell\Flysystem\FlysystemManager;
use Carbon\Carbon;

class GitRepoService implements GitRepoInterface
{
    protected $basePath;

    public function __construct()
    {
        $this->basePath = config('laudatio.basePath');
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

            $this->initiateRepository($dirPath);
            $this->addFilesToRepository($dirPath,"TEI-HEADERS");
            $this->commitFilesToRepository($this->basePath.'/'.$dirPath,"Created initial corpus file structure for $corpusName");
            $this->copyGitHooks($dirPath);
            $this->copyScripts($dirPath);

        }

        return $corpusPath;
    }

    public function getCorpusFiles($flysystem,$path = ""){
        $gitFunction = new GitFunction();
        $hasDir = false;
        $projects = array();
        //dd($path);
        if($path == ""){
            $projects = $flysystem->listContents();
        }
        else{
            $projects = $flysystem->listContents($path);
        }


        $pathArray = explode("/",$path);
        end($pathArray);
        $last_id = key($pathArray);
        $laudatioUtilService = new LaudatioUtilService();

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

            $headerObject = $laudatioUtilService->getModelByFileName($projects[$i]['basename'],$pathArray[$last_id]);
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


    public function addFilesToRepository($path,$file){
        $gitFunction = new  GitFunction();
        $isAdded = $gitFunction->addUntracked($path,$file);
        return $isAdded;
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
        return $str;
    }


}
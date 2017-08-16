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
            $flysystem->write($dirPath."/TEI-HEADERS/document/.info","Document headers files for ".$corpusName);
            $flysystem->createDir($dirPath."/TEI-HEADERS/preparation");
            $flysystem->write($dirPath."/TEI-HEADERS/preparation/.info","Annotation preparation headers files for ".$corpusName);
            $flysystem->createDir($dirPath."/CORPUS-DATA");

            $this->addFilesToRepository($dirPath,"TEI-HEADERS");
            $this->commitFilesToRepository($this->basePath.'/'.$dirPath,"Created initial corpus file structure for $corpusName");

        }

        return $corpusPath;
    }

    public function getCorpusFiles($flysystem,$path = ""){
        $gitFunction = new GitFunction();
        $projects = array();
        if($path == ""){
            $projects = $flysystem->listContents();
        }
        else{
            $projects = $flysystem->listContents($path);
        }

        //dd($path);
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
            /*
            if($projects[$i]["type"] != "dir"){
                $projects[$i]['filesize'] = $flysystem->getSize($this->basePath."/".$projects[$i]['path']);
            }
            */

            $projects[$i]['filesize'] = 0;
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

        $pathtarray  = explode("/",$path);
        $previouspath = "";
        for($i = 0; $i < (count($pathtarray)-1); $i++){
            $previouspath .= $pathtarray[$i]."/";
        }

        return array(
            "projects" => $projects,
            "pathcount" => $count,
            "path" => $path,
            "previouspath" => $previouspath,
        );
    }


    public function addFilesToRepository($path,$file){
        $gitFunction = new  GitFunction();
        $isAdded = $gitFunction->addUntracked($path,$file);
        return $isAdded;
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
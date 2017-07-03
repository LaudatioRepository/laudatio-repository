<?php

namespace App\Http\Controllers;

use App\Laudatio\GitLaB\GitFunction;
use Illuminate\Http\Request;
use GrahamCampbell\Flysystem\Facades\Flysystem;
use GrahamCampbell\Flysystem\FlysystemManager;
use Illuminate\Support\Facades\App; // you probably have this aliased already
use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\CreateCorpusRequest;

class GitRepoController extends Controller
{
    protected $flysystem;
    protected $connection;
    protected $basePath;

    public function __construct(FlysystemManager $flysystem)
    {
        $this->flysystem = $flysystem;
        $this->connection = $this->flysystem->getDefaultConnection();
        $this->basePath = config('laudatio.basePath');
    }

    public function listProjects($path = ""){
        $gitFunction = new GitFunction();

        $isLoggedIn = \Auth::check();
        $projects = array();
        if($path == ""){
            $projects = $this->flysystem->listContents();
        }
        else{
            $projects = $this->flysystem->listContents($path);
        }


        for ($i = 0; $i < count($projects);$i++){
            $foldercount = count($this->flysystem->listContents($projects[$i]['path']));
            $projects[$i]['foldercount'] = $foldercount;
            if($gitFunction->isTracked($this->basePath."/".$projects[$i]['path'])){
                $projects[$i]['tracked'] = "true";
            }
            else{
                $projects[$i]['tracked'] = "false";
            }

            $hasDiff = $gitFunction->hasDiff($this->basePath."/".$projects[$i]['path']);
            $projects[$i]['diffFiles'] = array();
            //print print_r($hasDiff,1);
            if($hasDiff){
                $projects[$i]['hasDiff'] = "true";
            }
            else{
                $projects[$i]['hasDiff'] = "false";
            }

            array_push($projects[$i]['diffFiles'],$hasDiff);
        }


        $patharray = explode("/",$path);
        $count = count($patharray);

        $projects = $this->filterDottedFiles($projects);

        $pathtarray  = explode("/",$path);
        $previouspath = "";
        for($i = 0; $i < (count($pathtarray)-1); $i++){
            $previouspath .= $pathtarray[$i]."/";
        }

        $user = \Auth::user();

        return view("gitLab.projectlist",["projects" => $projects, "pathcount" => $count,"path" => $path,"previouspath" => $previouspath])
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }


    public function listSchema($path = ""){
        $gitFunction = new GitFunction();

        $isLoggedIn = \Auth::check();
        $schema = array();
        if($path == ""){
            $schema = $this->flysystem->connection('schemalocal')->listContents();
            $schema = $this->flysystem->connection('schemalocal')->listContents();
        }
        else{
            $schema = $this->flysystem->connection('schemalocal')->listContents($path);
        }


        for ($i = 0; $i < count($schema);$i++){
            $foldercount = count($this->flysystem->connection('schemalocal')->listContents($schema[$i]['path']));
            $schema[$i]['foldercount'] = $foldercount;
            if($gitFunction->isTracked($this->basePath."/".$schema[$i]['path'])){
                $schema[$i]['tracked'] = "true";
            }
            else{
                $schema[$i]['tracked'] = "false";
            }
        }


        $patharray = explode("/",$path);
        $count = count($patharray);

        $schema = $this->filterDottedFiles($schema);

        $pathtarray  = explode("/",$path);
        $previouspath = "";
        for($i = 0; $i < (count($pathtarray)-1); $i++){
            $previouspath .= $pathtarray[$i]."/";
        }

        return view("gitLab.schemalist",["schema" => $schema, "pathcount" => $count,"path" => $path,"previouspath" => $previouspath])
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',\Auth::user());
    }


    public function readFile($path){
        $isLoggedIn = \Auth::check();
        $contents = "";
        if($this->flysystem->has($path)){
            $contents = $this->flysystem->read($path);
        }
        return view("gitLab.viewFile",["file" => $contents])
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',\Auth::user());
    }

    public function deleteFile($path,$isdir = 1){
        $directoryPath = substr($path,0,strrpos($path,"/"));

        if($this->flysystem->has($path)){
            $gitFunction = new  GitFunction();
            $isTracked = $gitFunction->isTracked($this->basePath."/".$path);
            $result = $gitFunction->deleteFiles($path);
            //$this->commitFiles($path,"Deleting files in $path");
        }

        return redirect()->route('gitRepo.route',['path' => $directoryPath]);
    }


    public function updateFileVersion($path){
        $isLoggedIn = \Auth::check();
        $directoryPath = substr($path,0,strrpos($path,"/"));
        $file = substr($path,strrpos($path,"/")+1);
        $gitFunction = new  GitFunction();
        $isAdded = $gitFunction->addFileUpdate($directoryPath,$file);
        print "ISADDED: ".$isAdded;
        if($isAdded){
            return redirect()->action(
                'CommitController@commitForm', ['dirname' => $path]
            );

        }
    }

    public function addFiles($path){
        $gitFunction = new  GitFunction();
        $pathWithOutAddedFolder = substr($path,0,strrpos($path,"/"));
        $folder = substr($path,strrpos($path,"/")+1);
        $isAdded = $gitFunction->addUntracked($pathWithOutAddedFolder,$folder);
        if($isAdded){
            return redirect()->action(
                'CommitController@commitForm', ['dirname' => $path]
            );

        }
    }

    public function commitFiles($dirname = "", $commitmessage){
        $gitFunction = new  GitFunction();
        $pathWithOutAddedFolder = substr($dirname,0,strrpos($dirname,"/"));
        $isCommited = $gitFunction->commitFiles($this->basePath."/".$pathWithOutAddedFolder,$commitmessage);
        if($isCommited){
            return redirect()->route('gitRepo.route',['path' => $pathWithOutAddedFolder]);
        }
    }


    public function createProjectForm($dirname = ''){
        $isLoggedIn = \Auth::check();
        return view('gitLab.createProjectForm',["dirname" => $dirname])
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',\Auth::user());
    }

    public function createProjectSubmit(CreateProjectRequest $request){
        $dirPath = $request->directorypath.'/'.$request->projectname;

        if(!$this->flysystem->has($dirPath)){
            $this->flysystem->createDir($dirPath);

            return redirect()->route('gitRepo.route',['path' => $request->directorypath]);
        }
        else{
            return "Project already exists!";
        }
    }

    public function createCorpusForm($dirname = ''){
        $isLoggedIn = \Auth::check();
        return view('gitLab.createCorpusForm',["dirname" => $dirname])
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',\Auth::user());
    }

    public function createCorpusSubmit(CreateCorpusRequest $request){
        $dirPath = $request->directorypath.'/'.$request->corpusname;

        if(!$this->flysystem->has($dirPath)){
            $this->flysystem->createDir($dirPath);
            $this->flysystem->createDir($dirPath."/TEI-HEADER");
            $this->flysystem->createDir($dirPath."/TEI-HEADER/corpus");
            $this->flysystem->createDir($dirPath."/TEI-HEADER/document");
            $this->flysystem->createDir($dirPath."/TEI-HEADER/preparation");
            return redirect()->route('gitRepo.route',['path' => $request->directorypath]);
        }
        else{
            return "Corpus already exists!";
        }
    }

    /**
     * HELPERS
     */

    private function filterDottedFiles($array){
        $projects = array();
        foreach ($array as $item){
            $pos = strpos($item['basename'],".");
            if($pos === false || ($pos > 0)){
                array_push($projects,$item);
            }
        }

        return $projects;
    }
}
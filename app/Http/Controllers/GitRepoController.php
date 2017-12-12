<?php

namespace App\Http\Controllers;

use App\Laudatio\GitLaB\GitFunction;
use App\Custom\GitRepoInterface;
use Illuminate\Http\Request;
use GrahamCampbell\Flysystem\Facades\Flysystem;
use GrahamCampbell\Flysystem\FlysystemManager;
use Illuminate\Support\Facades\App; // you probably have this aliased already
use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\CreateCorpusRequest;
use App\Custom\LaudatioUtilsInterface;
use DB;
use Response;
use Log;

class GitRepoController extends Controller
{
    protected $flysystem;
    protected $connection;
    protected $basePath;
    protected $GitRepoService;
    protected $laudatioUtils;

    public function __construct(GitRepoInterface $Gitservice, FlysystemManager $flysystem, LaudatioUtilsInterface $laudatioUtils)
    {
        $this->flysystem = $flysystem;
        $this->connection = $this->flysystem->getDefaultConnection();
        $this->basePath = config('laudatio.basePath');
        $this->GitRepoService = $Gitservice;
        $this->laudatioUtils = $laudatioUtils;
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


    public function deleteFile($path){
        $directoryPath = substr($path,0,strrpos($path,"/"));
        $dirArray = explode("/",$directoryPath);
        $corpusPath = $dirArray[1];
        $corpus = DB::table('corpuses')->where('directory_path',$corpusPath)->get();
        $result = $this->GitRepoService->deleteFile($this->flysystem,$path);
        if($result) {
            session()->flash('message', $path.' was sucessfully deleted!');
        }
        return redirect()->route('admin.corpora.show',['path' => $directoryPath,'corpus' => $corpus[0]->id]);
    }

    /**
     * @param Request $request
     * API method
     */
    public function deleteMultipleFiles(Request $request)
    {
        $input =$request ->all();
        $msg = "";
        if ($request->ajax()){
            $msg .= "<p>Deleted the following files </p>";
            $filesForDeletion = $input['filesForDeletion'];
            $msg .= "<ul>";
            foreach($filesForDeletion as $fileForDeletion) {
                $result = $this->GitRepoService->deleteFile($this->flysystem,$fileForDeletion);
                if($result) {
                    $msg .= "<li>".$fileForDeletion."</li>";
                }

            }
            $msg .= "</ul>";
        }

        $response = array(
            'status' => 'success',
            'msg' => $msg,
        );


        return Response::json($response);


    }

    public function updateFileVersion($path){
        $isLoggedIn = \Auth::check();
        $directoryPath = substr($path,0,strrpos($path,"/"));
        $file = substr($path,strrpos($path,"/")+1);
        $gitFunction = new  GitFunction();
        $isAdded = $gitFunction->addFileUpdate($directoryPath,$file);
        if($isAdded){
            return redirect()->action(
                'CommitController@commitForm', ['dirname' => $path]
            );

        }
    }

    public function addFiles($path,$corpus){
        $pathWithOutAddedFolder = substr($path,0,strrpos($path,"/"));
        $file = substr($path,strrpos($path,"/")+1);

        $isAdded = $this->GitRepoService->addFilesToRepository($pathWithOutAddedFolder,$file);
        if($isAdded){
            return redirect()->action(
                'CommitController@commitForm', ['dirname' => $pathWithOutAddedFolder, 'corpus' => $corpus]
            );

        }
    }

    public function commitFiles($dirname = "", $commitmessage, $corpusid){
        $gitFunction = new  GitFunction();
        $patharray = explode("/",$dirname);
        end($patharray);
        $last_id = key($patharray);

        $object = null;
        $returnPath = "";

        if(is_dir($this->basePath.'/'.$dirname)){
            $isCommited = $gitFunction->commitFiles($this->basePath."/".$dirname,$commitmessage,$corpusid);
            if($isCommited){
                $this->laudatioUtils->setVersionMapping($corpusid,$patharray[$last_id]);
                $returnPath = $dirname;
                $object = $this->laudatioUtils->getModelByType($corpusid,$patharray[$last_id]);
            }
        }
        else{
            $pathWithOutAddedFolder = substr($dirname,0,strrpos($dirname,"/"));
            $isCommited = $gitFunction->commitFiles($this->basePath."/".$pathWithOutAddedFolder,$commitmessage,$corpusid);
            if($isCommited){
                $this->laudatioUtils->setVersionMapping($corpusid,$patharray[($last_id-1)]);
                $returnPath = $pathWithOutAddedFolder;
                $object = $this->laudatioUtils->getModelByType($corpusid,$patharray[($last_id-1)]);
            }
        }


        $fileName = substr($dirname, strrpos($dirname,"/")+1);
        $commitdata = $this->GitRepoService->getCommitData();

        if($object->file_name == $fileName){
            $object->gitlab_commit_sha = $commitdata['sha_string'];
            $object->gitlab_commit_date = $commitdata['date'];
            $object->gitlab_commit_description = $commitdata['message'];
            $object->save();
        }

        return redirect()->route('admin.corpora.show',['path' => $returnPath,'corpus' => $corpusid]);
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
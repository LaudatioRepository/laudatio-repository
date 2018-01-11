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
use App\Corpus;
use App\Document;
use App\Annotation;
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
        $dirArray = explode("/",$path);
        $corpusPath = $dirArray[1];

        $corpusId = 0;

        if($dirArray[3] == 'corpus'){
            $headerObject = DB::table('corpuses')->where('file_name',$dirArray[4])->get();

            $corpus = Corpus::find($headerObject[0]->id);
            $corpusId = $corpus->id;


            if(count($corpus->documents) > 0){


                foreach ($corpus->documents as $document){
                    $documentPath = $dirArray[0]."/".$dirArray[1]."/".$dirArray[2]."/document/".$document->file_name;
                    Log::info("documentPath: ".print_r($documentPath,1 ));
                    $documentResult = $this->GitRepoService->deleteFile($this->flysystem,$documentPath);
                    $document->annotations()->delete();
                }
                $corpus->documents()->delete();
            }
            Log::info("annotation: ".print_r($corpus->annotations,1 ));
            if(count($corpus->annotations) > 0){
                Log::info("annotation: ".print_r($annotation,1 ));
                foreach ($corpus->annotations() as $annotation){

                    Log::info("annotationPath: ".print_r($annotationPath,1 ));

                    if($annotation->file_name){
                        $annotationPath = $dirArray[0]."/".$dirArray[1]."/".$dirArray[2]."/annotation/".$annotation->file_name;

                        $annotationResult = $this->GitRepoService->deleteFile($this->flysystem,$annotationPath);
                        if(count($annotation->documents()) > 0) {
                            $annotation->documents()->detach();
                        }

                        if(count($annotation->preparations) > 0) {
                            $annotation->preparations()->delete();
                        }

                    }

                }

                $corpus->annotations()->delete();
            }

            $corpus->delete();
           // Log::info("Dingdong: ".print_r($corpus->annotations(),1 ));
        }
        else if($dirArray[3] == 'document'){
            $headerObject = DB::table('documents')->where('file_name',$dirArray[4])->get();
            $doc = Document::find($headerObject[0]->id);
            $corpusId = $doc->corpus_id;
            //dd($doc->annotations());
            if(count($doc->annotations()) > 0) {
                $doc->annotations()->detach();
            }

            $doc->delete();
        }
        else if($dirArray[3] == 'annotation'){
            $headerObject = DB::table('annotations')->where('file_name',$dirArray[4])->get();
            $anno = Annotation::find($headerObject[0]->id);
            $corpusId = $anno->corpus_id;
            if(count($anno->documents()) > 0) {
                $anno->documents()->detach();
            }
            $anno->preparations()->delete();
            $anno->delete();
        }

        $result = $this->GitRepoService->deleteFile($this->flysystem,$path);



        if($result) {
            session()->flash('message', $path.' was sucessfully deleted!');
        }
        if($dirArray[3] == 'corpus'){
            $projectObject = DB::table('corpus_projects')->where('directory_path',$dirArray[0])->get();
            return redirect()->route('admin.corpusProject.show',['corpusproject' => $projectObject[0]->id]);
        }
        else{
            return redirect()->route('admin.corpora.show',['path' => $directoryPath,'corpus' => $corpusId]);
        }

    }

    public function deleteUntrackedFile($path){
        $directoryPath = substr($path,0,strrpos($path,"/"));
        $dirArray = explode("/",$directoryPath);
        $corpusPath = $dirArray[1];
        $corpus = DB::table('corpuses')->where('directory_path',$corpusPath)->get();
        $result = $this->GitRepoService->deleteUntrackedFile($this->flysystem,$path);
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

    /**
     * @param Request $request
     * API Method
     */
    public function createFormatFolder(Request $request){
        $input =$request ->all();
        $msg = "";
        if ($request->ajax()){
            $msg .= "<p>Created the following format folder:  </p>";
            $formatName = $input['formatName'];
            $path = $input['path'];
            $gitFunction = new GitFunction();
            $created = $gitFunction->makeDirectory($path,$formatName);

            $msg .= "<ul>";
            if($created){
                $msg .= "<li>".$created."</li>";
            }
            $msg .= "</ul>";
        }

        $response = array(
            'status' => 'success',
            'msg' => $msg,
        );


        return Response::json($response);
    }

    /**
     * Perform modification to file in git
     * @param $path
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Stage headers to git
     * @param $path
     * @param $corpus
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addFiles($path,$corpus){
        $pathWithOutAddedFolder = substr($path,0,strrpos($path,"/"));
        $file = substr($path,strrpos($path,"/")+1);
        $isAdded = $this->GitRepoService->addFilesToRepository($pathWithOutAddedFolder,$file);
        if($isAdded){
            return redirect()->action(
                'CommitController@commitForm', ['dirname' => $path, 'corpus' => $corpus]
            );

        }
    }

    /**
     * Commit staged header to GIT
     * @param string $dirname
     * @param $commitmessage
     * @param $corpusid
     * @return \Illuminate\Http\RedirectResponse
     */
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
                        //dd($stagedFile);
                        $dirArray = explode("/",trim($stagedFile));
                        $fileName = $dirArray[2];

                        if(is_dir($this->basePath.'/'.$dirname.'/'.$fileName)){
                            $object = $this->laudatioUtils->getModelByFileName($fileName,$patharray[$last_id], true);
                            $this->laudatioUtils->setVersionMapping($fileName,$patharray[$last_id],true);
                            $fileName = $object[0]->directory_path;
                        }
                        else{
                            $object = $this->laudatioUtils->getModelByFileName($fileName,$patharray[$last_id], false);
                            $this->laudatioUtils->setVersionMapping($fileName,$patharray[$last_id],false);
                            $fileName = $object[0]->directory_path;
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
                    $this->laudatioUtils->setVersionMapping($fileName,$patharray[($last_id-1)],false);
                    $object = $this->laudatioUtils->getModelByFileName($fileName,$patharray[($last_id-1)], false);
                }

                $returnPath = $pathWithOutAddedFolder;
            }
        }

        $commitdata = $this->GitRepoService->getCommitData($pathWithOutAddedFolder);

        if($isHeader){
            if(is_dir($this->basePath.'/'.$dirname)){
                if($object[0]->directory_path == $fileName){
                    $object[0]->gitlab_commit_sha = $commitdata['sha_string'];
                    $object[0]->gitlab_commit_date = $commitdata['date'];
                    $object[0]->gitlab_commit_description = $commitdata['message'];
                    $object[0]->save();
                }
            }
            else{
                if($object[0]->file_name == $fileName){
                    $object[0]->gitlab_commit_sha = $commitdata['sha_string'];
                    $object[0]->gitlab_commit_date = $commitdata['date'];
                    $object[0]->gitlab_commit_description = $commitdata['message'];
                    $object[0]->save();
                }
            }

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
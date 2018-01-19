<?php

namespace App\Http\Controllers;

use App\Corpus;
use App\CorpusProject;
use App\Http\Requests\UploadRequest;
use GrahamCampbell\Flysystem\FlysystemManager;
use DB;
use Illuminate\Http\Request;
use App\Custom\LaudatioUtilsInterface;
use App\Custom\GitRepoInterface;
use App\Custom\GitLabInterface;
use App\Laudatio\GitLaB\GitFunction;
use Log;
use Flow\JSONPath\JSONPath;

class UploadController extends Controller
{

    protected $flysystem;
    protected $laudatioUtilsService;
    protected $connection;
    protected $blacklist = array('.git','README.md');
    protected $basePath;
    protected $GitLabService;
    protected $GitRepoService;


    public function __construct(FlysystemManager $flysystem, LaudatioUtilsInterface $laudatioUtilsService, GitLabInterface $GitLabService,GitRepoInterface $Gitservice)
    {
        $this->flysystem = $flysystem;
        $this->GitRepoService = $Gitservice;
        $this->basePath = config('laudatio.basePath');
        $this->laudatioUtilsService = $laudatioUtilsService;
        $this->connection = $this->flysystem->getDefaultConnection();
        $this->GitLabService = $GitLabService;
    }

    public function uploadForm($dirname = "")
    {
        $isLoggedIn = \Auth::check();

        $dirArray = explode("/",$dirname);
        $corpusProjectPath = $dirArray[0];
        $corpusPath = $dirArray[1];
        $corpusProjectDB = DB::table('corpus_projects')->where('directory_path',$corpusProjectPath)->get();
        $corpusDB = DB::table('corpuses')->where('directory_path',$corpusPath)->get();
        $corpus = Corpus::with('corpusprojects')->where('id', $corpusDB[0]->id)->get();



        $isCorpusHeader = false;
        if($corpus[0]->name == "Untitled" && null == $corpus[0]->file_name){
            $isCorpusHeader = true;
        }

        /*
        $corpusProjectPivot = DB::table('corpus_corpus_project')->where('corpus_id',$corpus[0]->id)->get();
        if(count($corpusProjectPivot) > 0) {
            $corpusProject = CorpusProject::find($corpusProjectPivot[0]->corpus_project_id);
            $corpusProjectPath = $corpusProject->directory_path;
        }
        */

        return view('gitLab.uploadform',["dirname" => $dirname,"corpusid" => $corpus[0]->id, "isCorpusHeader" => $isCorpusHeader,"corpusProjectPath" => $corpusProjectPath])
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',\Auth::user());
    }

    public function uploadDataForm($dirname = "")
    {
        $isLoggedIn = \Auth::check();

        $dirArray = explode("/",$dirname);
        $corpusPath = $dirArray[1];
        $corpus = DB::table('corpuses')->where('directory_path',$corpusPath)->get();

        return view('gitLab.uploadDataform',["dirname" => $dirname,"corpusid" => $corpus[0]->id])
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',\Auth::user());
    }

    public function uploadSubmit(UploadRequest $request)
    {
        $updated = false;
        $dirPath = $request->directorypath;;
        $dirPathArray = explode("/",$dirPath);
        end($dirPathArray);
        $last_id=key($dirPathArray);

        $corpusId = $request->corpusid;
        $isCorpusHeader = $request->isCorpusHeader;
        $corpusProjectPath = $request->corpusProjectPath;
        $corpusProject = DB::table('corpus_projects')->where('directory_path',$corpusProjectPath)->get();
        $corpusProjectId = $corpusProject[0]->gitlab_id;
        $filePath = "";

        foreach ($request->formats as $format) {

            $fileName = $format->getClientOriginalName();
            $xmlpath = $format->getRealPath();
            $corpus = Corpus::find($corpusId);
            if(!empty($xmlpath)){
                $xmlNode = simplexml_load_file($xmlpath);
                $json = $this->laudatioUtilsService->parseXMLToJson($xmlNode, array());
                $jsonPath = new JSONPath($json,JSONPath::ALLOW_MAGIC);

                $corpusTitle = $jsonPath->find('$.TEI.teiHeader.fileDesc.titleStmt.title.text')->data();

                if($isCorpusHeader){
                    if($corpusTitle[0]){


                        $corpusPath = $this->GitRepoService->createCorpusFileStructure($this->flysystem,$corpusProjectPath,$corpusTitle[0]);
                        //dd($corpusPath);
                        $gitLabResponse = $this->GitLabService->createGitLabProject(
                            $corpusTitle[0],
                            array(
                                'namespace_id' => $corpusProjectId,
                                'path' => $corpusPath,
                                'description' => request('corpus_description'),
                                'visibility' => 'public'
                            ));



                        $params = array(
                            'corpusId' => $corpusId,
                            'corpus_path' => $corpusPath,
                            'gitlab_group_id' => $corpusProjectId,
                            'gitlab_id' => $gitLabResponse['id'],
                            'gitlab_web_url' => $gitLabResponse['web_url'],
                            'gitlab_name_with_namespace' => $gitLabResponse['name_with_namespace'],
                            'fileName' => $fileName
                        );

                        $corpus = $this->laudatioUtilsService->setCorpusAttributes($json,$params);
                        $filePath = $corpusProjectPath.'/'.$corpusPath.'/TEI-HEADERS/corpus/'.$fileName;

                    }
                }
                else if($dirPathArray[$last_id] == 'document'){
                    $document = $this->laudatioUtilsService->setDocumentAttributes($json,$corpusId,$fileName,false);
                    $filePath = $corpusProjectPath.'/'.$corpus->directory_path.'/TEI-HEADERS/document/'.$fileName;
                }
                else if($dirPathArray[$last_id] == 'annotation'){
                    $annotation = $this->laudatioUtilsService->setAnnotationAttributes($json,$corpusId,$fileName,false);
                    $filePath = $corpusProjectPath.'/'.$corpus->directory_path.'/TEI-HEADERS/annotation/'.$fileName;
                    $preparationSteps = $this->laudatioUtilsService->setPreparationAttributes($json,$annotation->id,$corpusId,false);
                }
            }

            if(!$isCorpusHeader){
                $filePath = $dirPath."/".$fileName;
            }

            /*
             * Move the uploaded file to the correct path
             */
            $exists = $this->flysystem->has($filePath);
            if(!$exists){
                $stream = fopen($format->getRealPath(), 'r+');
                $this->flysystem->writeStream($filePath, $stream);
            }
            else{
                $stream = fopen($format->getRealPath(), 'r+');
                $this->flysystem->updateStream($filePath, $stream);
                $updated = true;
            }

            if (is_resource($stream)) {
                fclose($stream);
            }


            $commitPath = "";
            if(!$isCorpusHeader){
                $commitPath = $dirPath;
                $corpusPath = $dirPathArray[1];
            }
            else{
                $commitPath = $corpusProjectPath.'/'.$corpusPath.'/TEI-HEADERS/corpus';
            }
            // Git Add the file(s)
            \App::call('App\Http\Controllers\GitRepoController@addFiles',[
                'path' => $commitPath,
                'corpus' => $corpusId
            ]);

            //git commit The files
            \App::call('App\Http\Controllers\GitRepoController@commitFiles',[
                'dirname' => $commitPath,
                'commitmessage' => "Adding files for ".$fileName,
                'corpus' => $corpusId
            ]);
        }

        return redirect()->route('admin.corpora.show',['path' => $corpusProjectPath."/".$corpusPath.'/TEI-HEADERS','corpus' => $corpusId]);
    }

    public function uploadSubmitFiles(Request $request)
    {
        $updated = false;
        $dirPath = $request->directorypath;;
        $corpusId = $request->corpusid;
        $fileData = $request->filedata;
        $file = $request->file;
        $fileName = $file->getClientOriginalName();
        $paths = explode(",",$fileData);

        $directoryPath = $this->laudatioUtilsService->getDirectoryPath($paths,$fileName);

        $gitFunction = new GitFunction();
        $createdPaths = $gitFunction->writeFiles($dirPath,$paths, $this->flysystem,$file->getRealPath(),$directoryPath);
        return redirect()->route('admin.corpora.show',['path' => $dirPath,'corpus' => $corpusId]);
    }
}
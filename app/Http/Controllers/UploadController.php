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

        //dd($corpus[0]->name);

        $isCorpusHeader = false;
        if(strpos($corpus[0]->name,"Untitled") !== false && null == $corpus[0]->file_name){
            $isCorpusHeader = true;
        }

        return view('gitLab.uploadform',["dirname" => $dirname,"corpusid" => $corpus[0]->id, "isCorpusHeader" => $isCorpusHeader,"corpusProjectPath" => $dirArray[0]])
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
        $corpusProjectDB = DB::table('corpus_projects')->where('directory_path',$corpusProjectPath)->get();
        $corpusProjectId = $corpusProjectDB[0]->gitlab_id;
        $corpus = Corpus::find($corpusId);

        $filePath = "";
        $currentFilePath = $corpus->directory_path;
        $corpusPath = $dirPathArray[1];

        $gitLabCorpusPath = "";

        $isUntitled = true;

        if(strpos($dirPathArray[1],"untitled") === false){
            $isUntitled = false;
        }

        foreach ($request->formats as $format) {
            $isUpdate = false;
            $fileName = $format->getClientOriginalName();
            $pathContents = $this->flysystem->listContents($dirPath, false);
            foreach ($pathContents as $object) {
                if($object['basename'] == $fileName){
                    $isUpdate = true;
                    break;
                }
            }

            $xmlpath = $format->getRealPath();

            if(!empty($xmlpath)){
                $xmlNode = simplexml_load_file($xmlpath);
                $json = $this->laudatioUtilsService->parseXMLToJson($xmlNode, array());
                $jsonPath = new JSONPath($json,JSONPath::ALLOW_MAGIC);

                $corpusTitle = $jsonPath->find('$.TEI.teiHeader.fileDesc.titleStmt.title.text')->data();
                //dd($corpusTitle);
                if($dirPathArray[$last_id] == 'corpus'){
                    if($corpusTitle[0]){

                        if($isUntitled){
                            $corpusPath = $this->GitRepoService->updateCorpusFileStructure($this->flysystem,$corpusProjectPath,$corpus->directory_path,$corpusTitle[0]);
                            $gitLabCorpusPath = substr($corpusPath,strrpos($corpusPath,"/")+1);
                            $this->laudatioUtilsService->updateDirectoryPaths($gitLabCorpusPath,$corpusId);
                            $gitLabResponse = $this->GitLabService->createGitLabProject(
                                $corpusTitle[0],
                                array(
                                    'namespace_id' => $corpusProjectId,
                                    'path' => $gitLabCorpusPath,
                                    'description' => request('corpus_description'),
                                    'visibility' => 'public'
                                ));

                            $params = array(
                                'corpusId' => $corpusId,
                                'corpus_path' => $gitLabCorpusPath,
                                'gitlab_group_id' => $corpusProjectId,
                                'gitlab_id' => $gitLabResponse['id'],
                                'gitlab_web_url' => $gitLabResponse['web_url'],
                                'gitlab_name_with_namespace' => $gitLabResponse['name_with_namespace'],
                                'fileName' => $fileName
                            );

                            $corpus = $this->laudatioUtilsService->setCorpusAttributes($json,$params);

                        }
                        else{

                            $params = array(
                                "name" => $corpusTitle[0],
                                "file_name" => $fileName,
                            );
                            $gitLabCorpusPath = substr($corpusPath,strrpos($corpusPath,"/"));
                            $this->laudatioUtilsService->updateCorpusAttributes($params,$corpusId);
                        }


                        $isUntitled = false;
                        $filePath = $corpusProjectPath."/".$corpusPath.'/TEI-HEADERS/corpus/'.$fileName;

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

/*
            if(!$isCorpusHeader){
                $filePath = $dirPath."/".$fileName;
            }
*/
            /*
             * Move the uploaded file to the correct path
             */
            //dd($filePath);
            $gitFunction = new GitFunction();

            $exists = $gitFunction->fileExists($filePath);

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


            if(!$isUntitled){

                $commitPath = "";
                $addPath = "";
                if(!$isCorpusHeader){
                    $addPath = $corpusProjectPath.'/'.$corpus->directory_path.'/TEI-HEADERS/'.$dirPathArray[$last_id];
                    $commitPath = $corpusProjectPath.'/'.$corpus->directory_path.'/TEI-HEADERS/'.$dirPathArray[$last_id];
                    $corpusPath = $dirPathArray[1];
                }
                else{
                    $addPath = $corpusProjectPath.'/'.$corpus->directory_path.'/TEI-HEADERS/corpus/';
                    $commitPath = $corpusProjectPath.'/'.$corpus->directory_path.'/TEI-HEADERS/corpus/'.$fileName;
                }

                //Log::info("addPath: ".$addPath." EXISTS: ".$exists);
                //Log::info("commitPath: ".$commitPath." EXISTS: ".$exists);
                // Git Add the file(s)
                \App::call('App\Http\Controllers\GitRepoController@addFiles',[
                    'path' => $addPath,
                    'corpus' => $corpusId
                ]);

                if(!$isUpdate){
                    //git commit The files
                    \App::call('App\Http\Controllers\GitRepoController@commitFiles',[
                        'dirname' => $commitPath,
                        'commitmessage' => "Adding files for ".$fileName,
                        'corpus' => $corpusId
                    ]);
                }

            }


        }

        if($isCorpusHeader && !$isUntitled) {
            return redirect()->route('admin.corpora.show', ['path' => $corpusProjectPath.'/'.$gitLabCorpusPath . '/TEI-HEADERS', 'corpus' => $corpusId]);
        }
        else if ($isCorpusHeader && $isUntitled){
            return redirect()->route('admin.corpora.show', ['path' => $dirPath, 'corpus' => $corpusId]);
        }
        else{
            return redirect()->route('admin.corpora.show',['path' => $dirPath,'corpus' => $corpusId]);
        }
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
<?php

namespace App\Http\Controllers;

use App\Corpus;
use App\CorpusProject;
use App\Document;
use App\Annotation;
use App\Http\Requests\UploadRequest;
use GrahamCampbell\Flysystem\FlysystemManager;
use DB;
use Illuminate\Http\Request;
use App\Custom\LaudatioUtilsInterface;
use App\Custom\GitRepoInterface;
use App\Custom\GitLabInterface;
use App\Custom\ElasticsearchInterface;
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
    protected $elasticService;


    public function __construct(FlysystemManager $flysystem, LaudatioUtilsInterface $laudatioUtilsService, GitLabInterface $GitLabService,GitRepoInterface $Gitservice, ElasticsearchInterface $elasticService)
    {
        $this->flysystem = $flysystem;
        $this->GitRepoService = $Gitservice;
        $this->basePath = config('laudatio.basePath');
        $this->laudatioUtilsService = $laudatioUtilsService;
        $this->connection = $this->flysystem->getDefaultConnection();
        $this->GitLabService = $GitLabService;
        $this->elasticService = $elasticService;
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

        return view('gitLab.uploadform',["dirname" => $dirname,"corpusid" => $corpus[0]->id])
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
        $dirPath = $request->directorypath;;
        $dirPathArray = explode("/",$dirPath);
        end($dirPathArray);
        $last_id=key($dirPathArray);

        $corpusId = $request->corpusid;
        $corpusProjectPath = $dirPathArray[0];
        $corpusPath = $dirPathArray[1];

        $corpusProjectDB = DB::table('corpus_projects')->where('directory_path',$corpusProjectPath)->get();
        $corpusProjectId = $corpusProjectDB[0]->gitlab_id;
        $corpus = Corpus::find($corpusId);

        $filePath = "";
        $currentFilePath = $corpus->directory_path;

        $gitLabCorpusPath = "";
        $isVersioned = false;

        $document = null;
        $documents = array();
        $annotation = null;
        $annotations = array();


        foreach ($request->formats as $format) {
            $fileName = $format->getClientOriginalName();
            $pathContents = $this->flysystem->listContents($dirPath, false);
            foreach ($pathContents as $object) {
                if($object['basename'] == $fileName){
                    $isUpdate = true;
                    break;
                }
            }

            $canUpload = true;
            if( $dirPathArray[$last_id] == 'corpus'
                && $corpus->file_name != $fileName
                && strpos($corpus->name,"Untitled") === false){
                $canUpload = false;
            }

            $xmlpath = $format->getRealPath();

            if(!empty($xmlpath)){
                $xmlNode = simplexml_load_file($xmlpath);
                $json = $this->laudatioUtilsService->parseXMLToJson($xmlNode, array());
                $jsonPath = new JSONPath($json,JSONPath::ALLOW_MAGIC);

                if($dirPathArray[$last_id] == 'corpus'){
                    $isVersioned = $this->laudatioUtilsService->corpusIsVersioned($corpusId);
                    $corpusTitle = $jsonPath->find('$.TEI.teiHeader.fileDesc.titleStmt.title.text')->data();
                    if($corpusTitle[0]){
                        if(!$isVersioned){
                            $corpusPath = $this->GitRepoService->updateCorpusFileStructure($this->flysystem,$corpusProjectPath,$corpus->directory_path,$corpusTitle[0]);
                            $gitLabCorpusPath = substr($corpusPath,strrpos($corpusPath,"/")+1);
                            $this->laudatioUtilsService->updateDirectoryPaths($gitLabCorpusPath,$corpusId);
                            $gitLabResponse = $this->GitLabService->createGitLabProject(
                                $this->GitRepoService->normalizeTitle($corpusTitle[0]),
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
                            if($canUpload){
                                $params = array(
                                    "name" => $corpusTitle[0],
                                    "file_name" => $fileName,
                                );
                                $gitLabCorpusPath = substr($corpusPath,strrpos($corpusPath,"/"));
                                $this->laudatioUtilsService->updateCorpusAttributes($params,$corpusId);
                            }

                        }


                        if(!$isVersioned){
                            $filePath = $corpusPath.'/TEI-HEADERS/corpus/'.$fileName;
                        }
                        else{
                            $filePath = $corpusProjectPath."/".$corpusPath.'/TEI-HEADERS/corpus/'.$fileName;
                        }


                    }
                }
                else if($dirPathArray[$last_id] == 'document'){
                    $document = $this->laudatioUtilsService->setDocumentAttributes($json,$corpusId,$fileName,false);
                    if(!array_key_exists($document->id,$documents)){
                        $documents[$document->id] = array();
                    }
                    $idParams = array();
                    array_push($idParams,array(
                        "document_id" => $document->document_id
                    ));

                    array_push($idParams,array(
                        "in_corpora" => $corpus->corpus_id
                    ));
                    $documents[$document->id] = $idParams;

                    $isVersioned = $this->laudatioUtilsService->documentIsVersioned($document->id);
                    $filePath = $corpusProjectPath.'/'.$corpus->directory_path.'/TEI-HEADERS/document/'.$fileName;
                }
                else if($dirPathArray[$last_id] == 'annotation'){
                    $annotation = $this->laudatioUtilsService->setAnnotationAttributes($json,$corpusId,$fileName,false);
                    if(!array_key_exists($annotation->id,$documents)){
                        $annotations[$annotation->id] = array();
                    }

                    $idParams = array();
                    array_push($idParams, array(
                        "preparation_annotation_id" => $annotation->annotation_id,
                    ));

                    array_push($idParams, array(
                        "in_corpora" => $corpus->corpus_id
                    ));
                    $annotations[$annotation->id] = $idParams;

                    $isVersioned = $this->laudatioUtilsService->annotationIsVersioned($annotation->id);
                    $filePath = $corpusProjectPath.'/'.$corpus->directory_path.'/TEI-HEADERS/annotation/'.$fileName;
                    $preparationSteps = $this->laudatioUtilsService->setPreparationAttributes($json,$annotation->id,$corpusId,false);
                }
            }

            /*
             * Move the uploaded file to the correct path
             */

            $canUpload = true;
            if( $dirPathArray[$last_id] == 'corpus'
                && $corpus->file_name != $fileName
                && strpos($corpus->name,"Untitled") === false){
                $canUpload = false;
            }



            if($canUpload){
                $gitFunction = new GitFunction();
                $exists = $gitFunction->fileExists($filePath);
                $stream = null;
                if(!$exists){
                    $stream = fopen($format->getRealPath(), 'r+');
                    $this->flysystem->writeStream($filePath, $stream);
                }
                else{
                    if($isVersioned){
                        $stream = fopen($format->getRealPath(), 'r+');
                        $this->flysystem->updateStream($filePath, $stream);
                    }

                }

                if (is_resource($stream)) {
                    fclose($stream);
                }

            }
            else{
                session()->flash('message', 'The corpus header you tried to upload does not belong to this corpus');
            }

            $commitPath = "";
            $addPath = "";
            if($dirPathArray[$last_id] != 'corpus'){
                $addPath = $corpusProjectPath.'/'.$corpus->directory_path.'/TEI-HEADERS/'.$dirPathArray[$last_id];
                $commitPath = $corpusProjectPath.'/'.$corpus->directory_path.'/TEI-HEADERS/'.$dirPathArray[$last_id];
                $corpusPath = $dirPathArray[1];
            }
            else{
                $addPath = $corpusPath.'/TEI-HEADERS/corpus/';
                $commitPath = $corpusPath.'/TEI-HEADERS/corpus/'.$fileName;
            }

            //if($dirPathArray[$last_id] == 'corpus' && !$isVersioned){

                //add files
                $this->GitRepoService->addFiles($addPath,$corpusId);

                //git commit The files
                $this->GitRepoService->commitFiles($commitPath,"Adding files for ".$fileName,$corpusId);
            //}
        }


        if($dirPathArray[$last_id] == 'corpus'){

        }
        else if($dirPathArray[$last_id] == 'document'){
            if(isset($corpus->corpus_id)){
                $elasticIds = $this->elasticService->getElasticIdByObjectId('document',$documents);
                foreach ($elasticIds as $documentId => $elasticId){
                    $documentToBeUpdated = Document::findOrFail($documentId);
                    $documentToBeUpdated->elasticsearch_id = $elasticIds[$documentId];
                    $documentToBeUpdated->save();
                }
                //$this->laudatioUtilsService->updateDocumentAttributes($updateParams,$document->id);
            }
        }
        else if($dirPathArray[$last_id] == 'annotation'){
            if(isset($corpus->corpus_id)){
                $elasticIds = $this->elasticService->getElasticIdByObjectId('annotation',$annotations);
                foreach ($elasticIds as $annotationId => $elasticId){
                    $annotationToBeUpdated = Annotation::findOrFail($annotationId);
                    $annotationToBeUpdated->elasticsearch_id = $elasticIds[$annotationId];
                    $annotationToBeUpdated->save();
                }
                //$this->laudatioUtilsService->updateAnnotationAttributes($updateParams,$annotation->id);
            }
        }



        if($dirPathArray[$last_id] == 'corpus' && !$isVersioned) {
            return redirect()->route('project.corpora.show', ['path' => $corpusProjectPath.'/'.$gitLabCorpusPath . '/TEI-HEADERS', 'corpus' => $corpusId]);
        }
        else if ($dirPathArray[$last_id] == 'corpus' && $isVersioned){
            return redirect()->route('project.corpora.show', ['path' => $dirPath, 'corpus' => $corpusId]);
        }
        else{
            return redirect()->route('project.corpora.show',['path' => $dirPath,'corpus' => $corpusId]);
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
        return redirect()->route('project.corpora.show',['path' => $dirPath,'corpus' => $corpusId]);
    }
}
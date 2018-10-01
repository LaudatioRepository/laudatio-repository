<?php

namespace App\Http\Controllers;

use App\Corpus;
use App\CorpusFile;
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
use Cache;

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
    protected $indexMappingPath;


    public function __construct(FlysystemManager $flysystem, LaudatioUtilsInterface $laudatioUtilsService, GitLabInterface $GitLabService,GitRepoInterface $Gitservice, ElasticsearchInterface $elasticService)
    {
        $this->flysystem = $flysystem;
        $this->GitRepoService = $Gitservice;
        $this->basePath = config('laudatio.basePath');
        $this->indexMappingPath = config('laudatio.indexMappingPath');
        $this->laudatioUtilsService = $laudatioUtilsService;
        $this->connection = $this->flysystem->getDefaultConnection();
        $this->GitLabService = $GitLabService;
        $this->elasticService = $elasticService;
    }


    /**
     * @param UploadRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadSubmit(UploadRequest $request)
    {
        $user = \Auth::user();
        $dirPath = $request->directorypath;;
        $dirPathArray = explode("/",$dirPath);
        end($dirPathArray);
        $last_id=key($dirPathArray);
        $corpusId = $request->corpusid;

        $corpusProjectPath = $dirPathArray[0];
        $corpusPath = $dirPathArray[1];
        $headerPath = $dirPathArray[$last_id];



        if(empty($corpusProjectPath) || empty($corpusPath)) {
            return redirect()->route('corpus.edit', ['corpus' => $corpusId]);
        }

        $corpusProjectDB = DB::table('corpus_projects')->where('directory_path',$corpusProjectPath)->get();
        $corpusProjectId = $corpusProjectDB[0]->gitlab_id;
        if(isset($request->corpusid)) {
            $corpus = Corpus::find($corpusId);
        }


        $gitLabCorpusPath = "";
        $filePath = "";
        $currentFilePath = $corpus->directory_path;


        $document = null;
        $annotation = null;
        $documents = array();
        $annotations = array();

        $fileName = $request->formats->getClientOriginalName();
        $pathname = $request->formats->getPathName();

        $xmlpath =  $request->formats->getRealPath();

        $directoryPath = $this->laudatioUtilsService->getDirectoryPath(array($fileName),$fileName);

        $json = null;
        $jsonPath = null;
        $xmlNode = null;


        $addPath = "";
        $commitPath = "";
        $pushPath = "";

        $corpusIsVersioned = false;
        $canUpload = true;
        $pushCorpusStructure = false;

        $gitLabId =  "";
        $gitLabTagName = "";
        $corpusIndexName = "";
        $documentIndexName = "";
        $annotationIndexName = "";
        $guidelineIndexName = "";


        if(!empty($xmlpath)) {
            $xmlNode = simplexml_load_file($xmlpath);
            $json = $this->laudatioUtilsService->parseXMLToJson($xmlNode, array());
            $jsonPath = new JSONPath($json, JSONPath::ALLOW_MAGIC);
        }

        if($headerPath != 'corpus'){
            $addPath = $corpusProjectPath.'/'.$corpus->directory_path.'/TEI-HEADERS/'.$dirPathArray[$last_id];
            $commitPath = $corpusProjectPath.'/'.$corpus->directory_path.'/TEI-HEADERS/'.$dirPathArray[$last_id];
            $corpusIsVersioned = $this->laudatioUtilsService->corpusIsVersioned($corpusId);
            if($headerPath == 'document'){
                $document = $this->laudatioUtilsService->setDocumentAttributes($json,$corpusId,$user->id,$fileName,false);
                //$isVersioned = $this->laudatioUtilsService->documentIsVersioned($document->id);
                $filePath = $corpusProjectPath.'/'.$corpus->directory_path.'/TEI-HEADERS/document/'.$fileName;
            }
            else if($headerPath == 'annotation'){
                $annotation = $this->laudatioUtilsService->setAnnotationAttributes($json,$corpusId,$user->id,$fileName,false);
                if(!array_key_exists($annotation->id,$annotations)){
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

                //$isVersioned = $this->laudatioUtilsService->annotationIsVersioned($annotation->id);
                $filePath = $corpusProjectPath.'/'.$corpus->directory_path.'/TEI-HEADERS/annotation/'.$fileName;
                //$preparationSteps = $this->laudatioUtilsService->setPreparationAttributes($json,$annotation->id,$corpusId,false);


                if(isset($corpus->corpus_id)){
                    $elasticIds = $this->elasticService->getElasticIdByObjectId($annotationIndexName,$annotations);
                    foreach ($elasticIds as $annotationId => $elasticId){
                        $annotationToBeUpdated = Annotation::findOrFail($annotationId);
                        $annotationToBeUpdated->elasticsearch_id = $elasticIds[$annotationId]['elasticsearchid'];
                        $annotationToBeUpdated->elasticsearch_index = $elasticIds[$annotationId]['elasticsearchindex'];
                        $annotationToBeUpdated->save();
                    }
                }
            }//end if header type

        }
        else{

            $pathContents = $this->flysystem->listContents($dirPath, false);
            foreach ($pathContents as $object) {
                if($object['basename'] == $fileName){
                    $isUpdate = true;
                    break;
                }
            }

            //read data
            $corpusIsVersioned = $this->laudatioUtilsService->corpusIsVersioned($corpusId);
            $corpusTitle = $jsonPath->find('$.TEI.teiHeader.fileDesc.titleStmt.title.text')->data();
            $corpusDescription = $jsonPath->find('$.TEI.teiHeader.encodingDesc[0].projectDesc.p.text')->data();
            $corpusPublicationVersions = $jsonPath->find('$.TEI.teiHeader.revisionDesc.change.n')->data();

            if(empty($corpusPublicationVersions)) {
                $corpusPublicationVersions = $jsonPath->find('$.TEI.teiHeader.revisionDesc.change[*].n')->data();
            }


            $corpusPublicationVersion = max(array_values($corpusPublicationVersions));


            $gitLabResponse = null;
            $remoteRepoUrl = "";

            if($corpusTitle[0]){
                if(!$corpusIsVersioned){

                    $updatedCorpusPath = $this->GitRepoService->updateCorpusFileStructure($this->flysystem,$corpusProjectPath,$corpus->directory_path,$corpusTitle[0]);
                    Log::info("updatedCorpusPath:TAGGED: ".print_r($updatedCorpusPath,1));
                    if(!empty($updatedCorpusPath)){
                        $gitLabCorpusPath = substr($updatedCorpusPath,strrpos($updatedCorpusPath,"/")+1);

                        $now = time();
                        $normalizedCorpusName = $this->GitRepoService->normalizeString($corpusTitle[0]);
                        $corpusIndexName = "corpus_".$normalizedCorpusName."_".$now;
                        $documentIndexName = "document_".$normalizedCorpusName."_".$now;
                        $annotationIndexName = "annotation_".$normalizedCorpusName."_".$now;
                        $guidelineIndexName = "guideline_".$normalizedCorpusName."_".$now;

                        $corpusIndexCreateResult = $this->elasticService->createMappedIndex($this->indexMappingPath.'/corpus_mapping.json',$corpusIndexName);
                        $documentIndexCreateResult = $this->elasticService->createMappedIndex($this->indexMappingPath.'/document_mapping.json',$documentIndexName);
                        $annotationIndexCreateResult = $this->elasticService->createMappedIndex($this->indexMappingPath.'/annotation_mapping.json',$annotationIndexName);
                        $guidelineIndexCreateResult = $this->elasticService->createMappedIndex($this->indexMappingPath.'/guideline_mapping.json',$guidelineIndexName);


                        if($corpusIndexCreateResult['status'] == 'success' &&
                            $documentIndexCreateResult['status'] == 'success' &&
                            $annotationIndexCreateResult['status'] == 'success' &&
                            $guidelineIndexCreateResult['status'] == 'success') {

                            $dirPath =  $updatedCorpusPath.'/TEI-HEADERS/corpus';
                            $this->laudatioUtilsService->updateDirectoryPaths($gitLabCorpusPath,$corpusId);

                            $gitLabResponse = $this->GitLabService->createGitLabProject(
                                $this->GitRepoService->normalizeTitle($corpusTitle[0]),
                                array(
                                    'namespace_id' => $corpusProjectId,
                                    'path' => $gitLabCorpusPath,
                                    'description' => $corpusDescription[0],
                                    'visibility' => 'public'
                                ));

                            if( null != $gitLabResponse &&
                                isset($gitLabResponse['id'])
                            ){
                                $remoteRepoUrl = $gitLabResponse['ssh_url_to_repo'];
                                $params = array(
                                    'corpusId' => $corpusId,
                                    "uid" => $user->id,
                                    'corpus_path' => $gitLabCorpusPath,
                                    'publication_version' => $corpusPublicationVersion,
                                    'workflow_status' => 0,
                                    'gitlab_group_id' => $corpusProjectId,
                                    'gitlab_id' => $gitLabResponse['id'],
                                    'gitlab_web_url' => $gitLabResponse['web_url'],
                                    'gitlab_ssh_url' => $remoteRepoUrl,
                                    'gitlab_name_with_namespace' => $gitLabResponse['name_with_namespace'],
                                    'elasticsearch_index' => $corpusIndexName,
                                    'guidelines_elasticsearch_index' => $guidelineIndexName,
                                    'file_name' => $fileName
                                );

                                $corpus = $this->laudatioUtilsService->setCorpusAttributes($json,$params);
                                $pushCorpusStructure = true;
                            }
                        }

                    }
                }
                else{
                    $params = array(
                        "uid" => $user->id,
                        "name" => $corpusTitle[0],
                        'publication_version' => $corpusPublicationVersion,
                        'workflow_status' => 0,
                        "file_name" => $fileName,
                        'elasticsearch_index' => $corpusIndexName,
                        'guidelines_elasticsearch_index' => $guidelineIndexName,
                    );
                    $gitLabCorpusPath = substr($updatedCorpusPath,strrpos($updatedCorpusPath,"/"));
                    $this->laudatioUtilsService->updateCorpusAttributes($params,$corpusId);
                }


                if(!$corpusIsVersioned){
                    $filePath = $updatedCorpusPath.'/TEI-HEADERS/corpus/'.$fileName;
                    $addPath = $updatedCorpusPath.'/TEI-HEADERS/';
                    $initialCommitPath = $updatedCorpusPath.'/TEI-HEADERS/';
                    $initialPushPath = $updatedCorpusPath;
                }
                else{
                    $filePath = $corpusProjectPath."/".$corpus->directory_path.'/TEI-HEADERS/corpus/'.$fileName;
                    $addPath = $corpusProjectPath.'/'.$corpus->directory_path.'/TEI-HEADERS/corpus/';
                    $commitPath = $corpusProjectPath.'/'.$corpus->directory_path.'/TEI-HEADERS/corpus/'.$fileName;

                }
            }

        }//end if


        if(!$corpusIsVersioned){
            $gitFunction = new GitFunction();
            $directoryPath = $this->laudatioUtilsService->getDirectoryPath(array($fileName),$fileName);

            $pushPath = $corpusProjectPath.'/'.$corpus->directory_path;

            $isPushed = false;
            //we have added a corpus, and push the corpus file structure to gitlab
            if($pushCorpusStructure && !empty($initialPushPath) && $remoteRepoUrl){
                $this->GitRepoService->addRemote($remoteRepoUrl,$initialPushPath);
                $hooksAdded = $this->GitRepoService->addHooks($initialPushPath, $user->name, $user->email);
                $isReset = $this->GitRepoService->resetAdd($initialPushPath,array("TEI-HEADERS"));

                if($isReset) {
                    $hookReturnPath = $this->GitRepoService->commitFiles($initialCommitPath, "Adding githooks",$corpusId, $user->name, $user->email);

                    $isInitiallyPushed = $this->GitRepoService->initialPush($initialPushPath,$user);

                    if($isInitiallyPushed) {
                        $tag = $this->GitRepoService->setCorpusVersionTag($initialPushPath,'{\"corpusIndex\":\"'.$corpusIndexName.'\",\"documentIndex\":\"'.$documentIndexName.'\",\"annotationIndex\":\"'.$annotationIndexName.'\",\"guidelineIndex\":\"'.$guidelineIndexName.'\",\"corpusid\": \"'.$corpusId.'\", \"username\": \"'.$user->name.'\", \"useremail\": \"'.$user->email.'\" }',0.0,$user->name,$user->email, false);
                        $createdPaths = $gitFunction->writeFiles($dirPath,array($fileName), $this->flysystem,$request->formats->getRealPath(),$directoryPath);

                        //add files
                        $isAdded = $this->GitRepoService->addFiles($addPath);
                        if($isAdded) {
                            $returnPath = $this->GitRepoService->commitFiles($initialCommitPath . "/" . $fileName, "Adding files for " . $fileName, $corpusId, $user->name, $user->email);


                            if(!empty($returnPath)){

                                $isPushed = $this->GitRepoService->pushFiles($pushPath,$corpusId,$user);

                                if($isPushed) {

                                    $params = array(
                                        'elasticsearch_index' => $corpusIndexName,
                                        'guidelines_elasticsearch_index' => $guidelineIndexName,
                                        'file_name' => $fileName
                                    );

                                    $corpus = $this->laudatioUtilsService->updateCorpusAttributes($params,$corpusId);
                                    $corpusFiles = $this->laudatioUtilsService->updateCorpusFileAttributes($corpus);


                                    $idParams = array();
                                    array_push($idParams,array(
                                        "in_corpora" => $corpus->corpus_id
                                    ));

                                    $annotationParams = array();
                                    foreach($corpus->annotations as $paramannotation) {
                                        $annotationParams[$paramannotation->id] = $idParams;
                                    }



                                    $documentParams = array();
                                    foreach($corpus->documents as $paramdocument) {
                                        $documentParams[$paramdocument->id] = $idParams;
                                    }



                                    $annotationElasticIds = $this->elasticService->getElasticIdByObjectId($annotationIndexName,$annotationParams);

                                    foreach ($annotationElasticIds as $annotationId => $annotationElasticId){
                                        $annotationToBeUpdated = Annotation::findOrFail($annotationId);
                                        $annotationToBeUpdated->elasticsearch_id = $annotationElasticIds[$annotationId]['elasticsearchid'];
                                        $annotationToBeUpdated->elasticsearch_index = $annotationElasticIds[$annotationId]['elasticsearchindex'];
                                        $annotationToBeUpdated->directory_path = $updatedCorpusPath;
                                        $annotationToBeUpdated->save();
                                    }



                                    $documentElasticIds = $this->elasticService->getElasticIdByObjectId($documentIndexName,$documentParams);

                                    foreach ($documentElasticIds as $documentId => $documentElasticId){
                                        $documentToBeUpdated = Document::findOrFail($documentId);
                                        $documentToBeUpdated->elasticsearch_id = $documentElasticIds[$documentId]['elasticsearchid'];
                                        $documentToBeUpdated->elasticsearch_index = $documentElasticIds[$documentId]['elasticsearchindex'];
                                        $documentToBeUpdated->directory_path = $updatedCorpusPath;
                                        $documentToBeUpdated->save();
                                    }

                                }
                            }//end if not empty commit
                        }
                    }
                }//end if reset

            }
            else {

                //ADD, COMMIT, PUSH WHEN CORPUS HEADER IS UPLOADED AND VERSIONED
                $createdPaths = $gitFunction->writeFiles($dirPath,array($fileName), $this->flysystem,$request->formats->getRealPath(),$directoryPath);

                $isAdded = $this->GitRepoService->addFiles($addPath);
                //git commit The files
                if($isAdded) {
                    if($corpusIsVersioned){
                        $returnPath = $this->GitRepoService->commitFiles($commitPath."/".$fileName,"Adding files for ".$fileName,$corpusId,$user->name,$user->email);
                        if(!empty($returnPath)){

                            $isPushed = $this->GitRepoService->pushFiles($pushPath,$corpusId,$user);
                        }
                    }
                }
            }

            $corpusPublicationVersion = $this->laudatioUtilsService->getCorpusVersion($corpus->corpus_id);
            $corpusWorkflowStatus = $this->laudatioUtilsService->getWorkFlowStatus($corpus->corpus_id);

            if($isPushed){
                Log::info("DATA IS PUSHED, so WE try to update databese records");
            }

            // fetch the elastic id and index
            if($headerPath == 'corpus' && $isPushed) {
                $idParams = array();
                array_push($idParams,array(
                    "corpus_id" => $corpus->corpus_id
                ));

                $corpusObject[$corpus->corpus_id] = $idParams;
                //if(isset($corpus->corpus_id)){

                $elasticIds = $this->elasticService->getElasticIdByObjectId($corpusIndexName,$corpusObject);
                foreach ($elasticIds as $ecorpusId => $elasticId){
                    $corpus->elasticsearch_id = $elasticIds[$ecorpusId]['elasticsearchid'];
                    $corpus->elasticsearch_index = $elasticIds[$ecorpusId]['elasticsearchindex'];
                    $corpus->save();
                }
                //}

                $this->laudatioUtilsService->emptyCorpusCache($corpus->corpus_id);

            }
            else if($headerPath == 'document' && $isPushed){
                if(!array_key_exists($document->id,$documents)){
                    $documents[$document->id] = array();
                }

                $idParams = array();
                if(isset($corpus->corpus_id)) {


                    array_push($idParams, array(
                        "in_corpora" => $corpus->corpus_id
                    ));
                    $documents[$document->id] = $idParams;


                    $elasticIds = $this->elasticService->getElasticIdByObjectId($documentIndexName, $documents);

                    foreach ($elasticIds as $documentId => $elasticId) {
                        $documentToBeUpdated = Document::findOrFail($document->id);
                        $documentToBeUpdated->elasticsearch_id = $elasticIds[$document->id]['elasticsearchid'];
                        $documentToBeUpdated->elasticsearch_index = $elasticIds[$document->id]['elasticsearchindex'];
                        $documentToBeUpdated->save();
                    }


                    $params = array(
                        'publication_version' => $corpusPublicationVersion,
                        'elasticsearch_index' => $documentIndexName,
                        'workflow_status' => $corpusWorkflowStatus
                    );

                    $this->laudatioUtilsService->updateDocumentAttributes($params,$document->id);

                    $this->laudatioUtilsService->emptyDocumentCacheByCorpusId($corpus->corpus_id);
                    $this->laudatioUtilsService->emptyDocumentCacheByDocumentId($document->id);
                }
            }
            else if($headerPath == 'annotation' && $isPushed){
                if(!array_key_exists($annotation->id,$annotations)){
                    $annotations[$annotation->id] = array();
                }

                $idParams = array();
                if(isset($corpus->corpus_id)) {
                    array_push($idParams, array(
                        "in_corpora" => $corpus->corpus_id
                    ));
                    $annotations[$annotation->id] = $idParams;

                    $elasticIds = $this->elasticService->getElasticIdByObjectId($annotationIndexName, $annotations);
                    foreach ($elasticIds as $annotationId => $elasticId) {
                        $annotationToBeUpdated = Annotation::findOrFail($annotation->id);
                        $annotationToBeUpdated->elasticsearch_id = $elasticIds[$annotationId]['elasticsearchid'];
                        $annotationToBeUpdated->elasticsearch_index = $elasticIds[$annotationId]['elasticsearchindex'];
                        $annotationToBeUpdated->save();
                    }

                    $params = array(
                        'publication_version' => $corpusPublicationVersion,
                        'workflow_status' => $corpusWorkflowStatus
                    );

                    $this->laudatioUtilsService->updateAnnotationAttributes($params,$annotation->id);

                    $this->laudatioUtilsService->emptyAnnotationCacheByCorpusId($corpus->corpus_id);
                    $this->laudatioUtilsService->emptyAnnotationCacheByAnnotationId($annotation->id);
                }
            }
        }
        else{
            session()->flash('message', 'The corpus header you tried to upload does not belong to this corpus');
        }




        if($dirPathArray[$last_id] == 'corpus' && !$corpusIsVersioned) {
            return redirect()->route('corpus.edit', ['corpus' => $corpusId]);
        }
        else if ($dirPathArray[$last_id] == 'corpus' && $corpusIsVersioned){
            return redirect()->route('corpus.edit', ['corpus' => $corpusId]);
        }
        else{
            return redirect()->route('corpus.edit',['corpus' => $corpusId]);
        }

    }

    public function uploadSubmitFiles(Request $request)
    {
        $user = \Auth::user();
        $dirPath = $request->directorypath;;
        $dirPathArray = explode("/",$dirPath);
        $corpusId = $request->corpusid;

        $corpusIsVersioned = null;

        $corpusProjectPath = $dirPathArray[0];
        $corpusPath = $dirPathArray[1];
        $uploadFolder = $dirPathArray[2];

        $corpusProjectDB = DB::table('corpus_projects')->where('directory_path',$corpusProjectPath)->get();
        $corpusProjectId = $corpusProjectDB[0]->gitlab_id;
        $corpus = null;

        if(isset($request->corpusid)) {
            $corpus = Corpus::find($corpusId);
            $corpusIsVersioned = $this->laudatioUtilsService->corpusIsVersioned($corpusId);
        }

        if(isset($corpus->id)){
            $fileName = $request->formats->getClientOriginalName();

            $directoryPath = $this->laudatioUtilsService->getDirectoryPath(array($fileName),$fileName);

            $gitFunction = new GitFunction();
            $createdPaths = $gitFunction->writeFiles($dirPath,array($fileName), $this->flysystem,$request->formats->getRealPath(),$directoryPath);

            if(strpos($createdPaths[0],$dirPath) !== false){

                $addPath = $corpusProjectPath.'/'.$corpusPath.'/'.$uploadFolder;
                $commitPath = $corpusProjectPath.'/'.$corpusPath.'/'.$uploadFolder.'/'.$fileName;
                $pushPath = $corpusProjectPath.'/'.$corpus->directory_path.'/'.$uploadFolder;

                //add files
                $isAdded = $this->GitRepoService->addFiles($addPath);

                //git commit The files
                if($isAdded) {
                    $corpusFile = new CorpusFile();
                    $corpusFile->file_name = $fileName;
                    $corpusFile->uid = $user->id;
                    $corpusFile->directory_path = $corpusPath;
                    $corpusFile->workflow_status = 0;
                    $corpusFile->save();

                    $corpus->corpusfiles()->save($corpusFile);
                    if($corpusIsVersioned){
                        $returnPath = $this->GitRepoService->commitFiles($commitPath, "Adding files for " . $fileName, $corpusId, $user->name, $user->email);
                        if (!empty($returnPath)) {
                            $isPushed = $this->GitRepoService->pushFiles($pushPath, $corpusId, $user);
                            Log::info("ISPUSHED: " . print_r($isPushed, 1));

                        }
                    }

                }

            }
        }

        return redirect()->route('corpus.edit', ['corpus' => $corpusId]);
    }


    public function UploadCorpusImage(Request $request)
    {
        $user = \Auth::user();
        $dirPath = $request->directorypath;;
        $dirPathArray = explode("/",$dirPath);
        $corpusId = $request->corpusid;
        $corpus = Corpus::find($corpusId);


        $fileName = $request->formats->getClientOriginalName();
        $pathname = $request->formats->getPathName();
        $directoryPath = $this->laudatioUtilsService->getDirectoryPath(array($fileName),$fileName);

        $gitFunction = new GitFunction();
        $createdPaths = $gitFunction->writeFiles($dirPath,array($fileName), $this->flysystem,$request->formats->getRealPath(),public_path('images'));

        return redirect()->route('corpus.edit', ['corpus' => $corpusId]);
    }

}
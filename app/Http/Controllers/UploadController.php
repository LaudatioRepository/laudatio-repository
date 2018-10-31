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
use App\Custom\ValidatorInterface;
use App\Exceptions\XMLNotWellformedException;
use App\Exceptions\XMLNotValidException;
use Log;
use Flow\JSONPath\JSONPath;
use Cache;
use Session;
//use Illuminate\Http\Response;
use Response;

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
    protected $schemaBasePath;
    protected $validationService;


    public function __construct(FlysystemManager $flysystem, LaudatioUtilsInterface $laudatioUtilsService, GitLabInterface $GitLabService,GitRepoInterface $Gitservice, ElasticsearchInterface $elasticService, ValidatorInterface $validationService)
    {
        $this->flysystem = $flysystem;
        $this->GitRepoService = $Gitservice;
        $this->basePath = config('laudatio.basePath');
        $this->indexMappingPath = config('laudatio.indexMappingPath');
        $this->schemaBasePath = config('laudatio.schemaPath');
        $this->laudatioUtilsService = $laudatioUtilsService;
        $this->connection = $this->flysystem->getDefaultConnection();
        $this->GitLabService = $GitLabService;
        $this->elasticService = $elasticService;
        $this->validationService = $validationService;
    }


    /**
     * @param UploadRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function uploadSubmit(UploadRequest $request)
    {
        $user = \Auth::user();

        /** assign variables **/

        $dirPath = $request->directorypath;;
        $dirPathArray = explode("/", $dirPath);
        end($dirPathArray);
        $last_id = key($dirPathArray);
        $corpusId = $request->corpusid;

        $corpusProjectPath = $dirPathArray[0];
        $corpusPath = $dirPathArray[1];
        $headerPath = $dirPathArray[$last_id];

        $fileName = $request->formats->getClientOriginalName();
        $pathname = $request->formats->getPathName();
        $xmlpath = $request->formats->getRealPath();
        $directoryPath = $this->laudatioUtilsService->getDirectoryPath(array($fileName), $fileName);


        if (empty($corpusProjectPath) || empty($corpusPath)) {
            return redirect()->route('corpus.edit', ['corpus' => $corpusId]);
        }

        $corpusProjectDB = DB::table('corpus_projects')->where('directory_path', $corpusProjectPath)->get();
        $corpusProjectId = $corpusProjectDB[0]->gitlab_id;

        $currentFilePath = "";

        /** initialize variables  **/

        // DB = ELOQUENT
        $document = null;
        $annotation = null;
        $documents = array();
        $annotations = array();

        //XML => JSONPATH
        $json = null;
        $jsonPath = null;
        $xmlNode = null;

        //Fetch XML by file path and parse it into JSONPATH
        if (!empty($xmlpath)) {

            $xmlfile = preg_replace_callback('/\\\\([0-7]{1,3})/', array($this, 'convertOctalToCharacter'), $xmlpath);
            $xmlfile = str_replace('"',"",$xmlfile);

            $this->validationService->setXml($xmlfile);

            //validate xml
            $response = new Response();
            $responsearray = array();

            try {
                //wellformed?
                $isWellFormed = $this->validationService->isWellFormed(true);

                //wellformed valid
                $this->validationService->setRelaxNGSchema($this->schemaBasePath.'/'.$headerPath.'/'.$headerPath.'.rng');
                $isValid = $this->validationService->isValidByRNG(true);


                //parse xml
                $xmlNode = simplexml_load_file($xmlpath);

                if($xmlNode) {
                    $json = $this->laudatioUtilsService->parseXMLToJson($xmlNode, array());

                }
                if(isset($json)){
                    $jsonPath = new JSONPath($json, JSONPath::ALLOW_MAGIC);
                }

            } catch (XMLNotWellformedException $exception) {
                $notification = array(
                    'error' => 'XMLNotWellformedException',
                    'payload' => explode(",",$exception->getMessage()),
                    'alert_type' => 'error',
                );
                array_push($responsearray,$notification);

                return Response::json($responsearray, 400);

            }
            catch (XMLNotValidException $valid_exception) {
                $notification = array(
                    'error' => 'XMLNotValidException',
                    'payload' => explode(",",$valid_exception->getMessage()),
                    'alert_type' => 'error',
                );
                array_push($responsearray,$notification);
                return Response::json($responsearray, 400);
            }
        }


        //GIT
        $addPath = "";
        $commitPath = "";
        $pushPath = $corpusProjectPath.'/'.$corpusPath;
        $initialPushPath = "";
        $gitLabId = "";
        $gitLabTagName = "";
        $gitLabCorpusPath = "";
        $filePath = "";
        $remoteRepoUrl = "";

        //ELASTICSEARCH
        $corpusIndexName = "";
        $corpus_index_id = "";
        $documentIndexName = "";
        $annotationIndexName = "";
        $guidelineIndexName = "";


        /** booleans **/
        $corpusIsVersioned = false;
        $canUpload = true;
        $pushCorpusStructure = false;


        if (isset($request->corpusid)) {
            $corpus = Corpus::find($corpusId);
            $currentFilePath = $corpus->directory_path;
        }

        $gitFunction = new GitFunction();
        // Is the Corpus Header uploaded ? We know that if the Corpus has an Eloquent version set
        $corpusIsVersioned = $this->laudatioUtilsService->corpusIsVersioned($corpusId);

        if($corpusIsVersioned) {
            $corpusIndexName = $this->laudatioUtilsService->getElasticSearchIndexByCorpusId($corpusId);
            $documentIndexName = str_replace("corpus","document",$corpusIndexName);
            $annotationIndexName = str_replace("corpus","annotation",$corpusIndexName);
            $headerId = "";

            //set variables and paths
            if($headerPath != 'corpus'){
                $addPath = $corpusProjectPath.'/'.$corpus->directory_path.'/TEI-HEADERS/'.$dirPathArray[$last_id];
                $commitPath = $corpusProjectPath.'/'.$corpus->directory_path.'/TEI-HEADERS/'.$dirPathArray[$last_id];
                $commitDataPath = "";

                if($headerPath == 'document') {
                    //write to db
                    $document = $this->laudatioUtilsService->setDocumentAttributes($json,$corpusId,$user->id,$fileName,false);
                    $filePath = $corpusProjectPath . '/' . $corpus->directory_path . '/TEI-HEADERS/document/' . $fileName;
                    $commitDataPath = 'TEI-HEADERS/document/'.$fileName;
                }
                else if($headerPath == 'annotation'){
                    //write to db
                    $annotation = $this->laudatioUtilsService->setAnnotationAttributes($json,$corpusId,$user->id,$fileName,false);
                    $filePath = $corpusProjectPath.'/'.$corpus->directory_path.'/TEI-HEADERS/annotation/'.$fileName;
                    $commitDataPath = 'TEI-HEADERS/annotation/'.$fileName;
                }

            }
            else{
                $filePath = $corpusProjectPath."/".$corpus->directory_path.'/TEI-HEADERS/corpus/'.$fileName;
                $addPath = $corpusProjectPath.'/'.$corpus->directory_path.'/TEI-HEADERS/corpus/'.$fileName;
                $commitPath = $corpusProjectPath.'/'.$corpus->directory_path.'/TEI-HEADERS/corpus/';
                $commitDataPath = 'TEI-HEADERS/corpus/'.$fileName;
            }

            //upload
            $createdPaths = $gitFunction->writeFiles($dirPath,array($fileName), $this->flysystem,$request->formats->getRealPath(),$directoryPath);

            //add
            $isAdded = $this->GitRepoService->addFiles($this->flysystem, $filePath);
            //commit
            $isPushed = false;
            $commitData = null;

            if($isAdded) {
                $commitData = $this->GitRepoService->commitFile($commitPath."/".$fileName,"Adding ".$fileName,$corpusId,$user->name,$user->email);

                if(!empty($commitData)){
                    //push
                    $isPushed = $this->GitRepoService->pushFiles($pushPath,$corpusId,$user);
                }
            }

            if($isPushed){
                if($headerPath == 'document') {
                    if(null != $document && null != $commitData){
                        $setData = $this->laudatioUtilsService->setCommitData(array($commitDataPath => $commitData),$corpusId);
                    }

                    //get elasticids
                    $documentParams = array();

                    $idParams = array();
                    array_push($idParams, array(
                        "document_id.keyword" => $document->document_id,
                    ));

                    array_push($idParams, array(
                        "in_corpora.keyword" => $corpus->corpus_id
                    ));

                    $documentParams[$document->id] = $idParams;

                    $documentElasticIds = $this->elasticService->getElasticIdByObjectId($documentIndexName,$documentParams);
                    foreach ($documentElasticIds as $documentId => $documentElasticId){
                        $document->elasticsearch_id = $documentElasticIds[$documentId]['elasticsearchid'];
                        $document->elasticsearch_index = $documentElasticIds[$documentId]['elasticsearchindex'];
                        $document->directory_path = $corpus->directory_path;
                        $document->publication_version = $corpus->publication_version;
                        $document->workflow_status = $corpus->workflow_status;
                        $document->save();
                        $this->laudatioUtilsService->emptyDocumentCacheByDocumentElasticsearchId($document->elasticsearch_id,$documentIndexName);
                    }

                    //empty cache
                    $this->laudatioUtilsService->emptyDocumentCacheByCorpusId($corpus->corpus_id,$documentIndexName);
                    $this->laudatioUtilsService->emptyDocumentCacheByDocumentIndex($documentIndexName);
                }
                else if($headerPath == 'annotation'){

                    if(null != $annotation && null != $commitData){
                        $setData = $this->laudatioUtilsService->setCommitData(array($commitDataPath => $commitData),$corpusId);
                    }

                    //get elasticids
                    $annotationParams = array();

                    $idParams = array();
                    array_push($idParams, array(
                        "preparation_annotation_id.keyword" => $annotation->annotation_id,
                    ));

                    array_push($idParams, array(
                        "in_corpora.keyword" => $corpus->corpus_id
                    ));

                    $annotationParams[$annotation->id] = $idParams;

                    if(isset($corpus->id)){
                        $elasticIds = $this->elasticService->getElasticIdByObjectId($annotationIndexName,$annotationParams);
                        foreach ($elasticIds as $annotationId => $elasticId){
                            $annotation->elasticsearch_id = $elasticIds[$annotationId]['elasticsearchid'];
                            $annotation->elasticsearch_index = $elasticIds[$annotationId]['elasticsearchindex'];
                            $annotation->directory_path = $corpus->directory_path;
                            $annotation->publication_version = $corpus->publication_version;
                            $annotation->workflow_status = $corpus->workflow_status;
                            $annotation->save();
                            $this->laudatioUtilsService->emptyAnnotationCacheByNameAndCorpusId($annotation->annotation_id, $corpusId, $annotationIndexName);
                        }
                    }

                    //empty cache
                    $this->laudatioUtilsService->emptyAnnotationCacheByCorpusId($corpus->corpus_id,$annotationIndexName);
                    $this->laudatioUtilsService->emptyAnnotationCacheByAnnotationIndex($annotationIndexName);

                }
                else if($headerPath == 'corpus'){
                    $idParams = array();
                    array_push($idParams,array(
                        "corpus_id" => $corpus->corpus_id
                    ));

                    $corpusObject[$corpus->corpus_id] = $idParams;

                    if(!isset($corpus->id)){
                        $elasticIds = $this->elasticService->getElasticIdByObjectId($corpusIndexName,$corpusObject);
                        foreach ($elasticIds as $ecorpusId => $elasticId){
                            $corpus->elasticsearch_id = $elasticIds[$ecorpusId]['elasticsearchid'];
                            $corpus->elasticsearch_index = $elasticIds[$ecorpusId]['elasticsearchindex'];
                            $corpus->save();
                        }
                    }

                    if(isset($jsonPath)){
                        $corpusTitle = $jsonPath->find('$.TEI.teiHeader.fileDesc.titleStmt.title')->data();

                        $corpusDescription = $jsonPath->find('$.TEI.teiHeader.encodingDesc[0].projectDesc.p.text')->data();
                        $corpusPublicationVersions = $jsonPath->find('$.TEI.teiHeader.revisionDesc.change.n')->data();

                        if(empty($corpusPublicationVersions)) {
                            $corpusPublicationVersions = $jsonPath->find('$.TEI.teiHeader.revisionDesc.change[*].n')->data();
                        }
                        $corpusPublicationVersion = max(array_values($corpusPublicationVersions));

                        if(isset($corpusTitle[0])) {
                            $corpus->name = $corpusTitle[0];

                            if(isset($corpusDescription[0])) {
                                $corpus->description = $corpusDescription[0];
                            }

                            if(isset($corpusPublicationVersion)) {
                                $corpus->publication_version = $corpusPublicationVersion;
                            }

                            $corpus->save();

                        }
                    }
                    //empty cache
                    $this->laudatioUtilsService->emptyCorpusCache($corpus->elasticsearch_id,$corpusIndexName);
                }
            }

        }
        else {
            //the corpus header is not yet uploaded
            $directoryPath = $this->laudatioUtilsService->getDirectoryPath(array($fileName),$fileName);

            //upload
            $createdPaths = $gitFunction->writeFiles($dirPath,array($fileName), $this->flysystem,$request->formats->getRealPath(),$directoryPath);

            //parse
            if($headerPath == 'corpus'){
                $now = time();
                $gitLabResponse = null;

                //read data
                $corpusIsVersioned = $this->laudatioUtilsService->corpusIsVersioned($corpusId);
                if(isset($jsonPath)){
                    $corpusTitle = $jsonPath->find('$.TEI.teiHeader.fileDesc.titleStmt.title')->data();

                    $corpusDescription = $jsonPath->find('$.TEI.teiHeader.encodingDesc[0].projectDesc.p.text')->data();
                    $corpusPublicationVersions = $jsonPath->find('$.TEI.teiHeader.revisionDesc.change.n')->data();

                    if(empty($corpusPublicationVersions)) {
                        $corpusPublicationVersions = $jsonPath->find('$.TEI.teiHeader.revisionDesc.change[*].n')->data();
                    }
                    $corpusPublicationVersion = max(array_values($corpusPublicationVersions));
                }


                if(!empty($corpusTitle[0])){
                    $updatedCorpusPath = $this->GitRepoService->updateCorpusFileStructure($this->flysystem,$corpusProjectPath,$corpus->directory_path,$corpusTitle[0]);

                    if(!empty($updatedCorpusPath)){
                        $gitLabCorpusPath = substr($updatedCorpusPath,strrpos($updatedCorpusPath,"/")+1);

                        //new elasticsearch identifiers
                        $normalizedCorpusName = $this->GitRepoService->normalizeString($corpusTitle[0]);
                        $corpusIndexName = "corpus_".$normalizedCorpusName."_".$now;
                        $corpus_index_id = "corpus_".$normalizedCorpusName."_".$now;
                        $documentIndexName = "document_".$normalizedCorpusName."_".$now;
                        $annotationIndexName = "annotation_".$normalizedCorpusName."_".$now;
                        $guidelineIndexName = "guideline_".$normalizedCorpusName."_".$now;

                        //create indexes

                        $corpusIndexCreateResult = $this->elasticService->createMappedIndex($this->indexMappingPath.'/corpus_mapping.json',$corpusIndexName);
                        $documentIndexCreateResult = $this->elasticService->createMappedIndex($this->indexMappingPath.'/document_mapping.json',$documentIndexName);
                        $annotationIndexCreateResult = $this->elasticService->createMappedIndex($this->indexMappingPath.'/annotation_mapping.json',$annotationIndexName);
                        $guidelineIndexCreateResult = $this->elasticService->createMappedIndex($this->indexMappingPath.'/guideline_mapping.json',$guidelineIndexName);

                        if($corpusIndexCreateResult['status'] == 'success' &&
                            $documentIndexCreateResult['status'] == 'success' &&
                            $annotationIndexCreateResult['status'] == 'success' &&
                            $guidelineIndexCreateResult['status'] == 'success') {

                            //set new path for what ? where is it used ?
                            $dirPath =  $updatedCorpusPath.'/TEI-HEADERS/corpus';


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
                                    'corpus_id' => $corpus_index_id,
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
                                $pushPath = $corpusProjectPath.'/'.$corpus->directory_path;

                                // create git corpus project
                                $this->laudatioUtilsService->updateDirectoryPaths($gitLabCorpusPath,$corpusId);
                            }//end if gitlabResponse

                        }//end if creation of new indexes
                    }//end updatedcorpusPath
                }//end if corpustitle


            }
            else if($headerPath == 'document') {
                //write to db
                $document = $this->laudatioUtilsService->setDocumentAttributes($json,$corpusId,$user->id,$fileName,false);
                //empty cache
                $this->laudatioUtilsService->emptyDocumentCacheByCorpusId($corpus->corpus_id,$documentIndexName);
                $this->laudatioUtilsService->emptyDocumentCacheByDocumentIndex($documentIndexName);
                $this->laudatioUtilsService->emptyDocumentCacheByDocumentElasticsearchId($document->elasticsearch_id,$documentIndexName);
            }
            else if($headerPath == 'annotation') {
                //write to db
                $annotation = $this->laudatioUtilsService->setAnnotationAttributes($json,$corpusId,$user->id,$fileName,false);
                //empty cache
                $this->laudatioUtilsService->emptyAnnotationCacheByCorpusId($corpus->corpus_id,$annotationIndexName);
                $this->laudatioUtilsService->emptyAnnotationCacheByAnnotationIndex($annotationIndexName);
            }

            //set paths
            if($headerPath != 'corpus'){
                $addPath = $corpusProjectPath.'/'.$corpus->directory_path.'/TEI-HEADERS/'.$dirPathArray[$last_id];
                $commitPath = $corpusProjectPath.'/'.$corpus->directory_path.'/TEI-HEADERS/'.$dirPathArray[$last_id];

                if($headerPath == 'document') {
                    $filePath = $corpusProjectPath . '/' . $corpus->directory_path . '/TEI-HEADERS/document/' . $fileName;
                }
                else if($headerPath == 'annotation'){
                    $filePath = $corpusProjectPath.'/'.$corpus->directory_path.'/TEI-HEADERS/annotation/'.$fileName;
                }
            }
            else{
                if(isset($updatedCorpusPath)){
                    $filePath = $updatedCorpusPath.'/TEI-HEADERS/corpus/'.$fileName;
                    $addPath = $updatedCorpusPath.'/TEI-HEADERS';
                    $addStructurePath = $updatedCorpusPath;
                    $initialCommitPath = $updatedCorpusPath;
                    $corpusCommitpath = $updatedCorpusPath.'/TEI-HEADERS';
                    $initialPushPath = $updatedCorpusPath;
                }

            }

            $isPushed = false;
            $pushPath = $corpusProjectPath.'/'.$corpus->directory_path;

            if($pushCorpusStructure && !empty($initialPushPath) && $remoteRepoUrl
            && isset($initialPushPath)
            && isset($corpusCommitpath)
            && isset($initialCommitPath)
            && isset($addPath)
            && isset($filePath)
            ){
                $addRemote = $this->GitRepoService->addRemote($remoteRepoUrl,$initialPushPath);
                $hooksAdded = $this->GitRepoService->addHooks($initialPushPath, $user->name, $user->email);
                $isReset = $this->GitRepoService->resetAdd($initialPushPath,array("TEI-HEADERS", "CORPUS-DATA", "CORPUS-IMAGES"));

                if($isReset) {
                    $hookCommitdata = $this->GitRepoService->commitFile($initialCommitPath.'/githooks', "Adding githooks",$corpusId, $user->name, $user->email);
                    $isInitiallyPushed = $this->GitRepoService->initialPush($initialPushPath,$user);

                    if($isInitiallyPushed) {

                        $tagMessage = array(
                            "corpusIndex" => $corpusIndexName,
                            "documentIndex" => $documentIndexName,
                            "annotationIndex" => $annotationIndexName,
                            "guidelineIndex" => $guidelineIndexName,
                            "corpusid" => $corpusId,
                            "corpusIndexedId" => $corpus_index_id,
                            "username" => $user->name,
                            "useremail" =>  $user->email
                        );

                        $hexedJson = str_replace('"','\"',json_encode( $tagMessage));
                        $tag = $this->GitRepoService->setCorpusVersionTag($initialPushPath,$hexedJson,0.0,$user->name,$user->email, false);
                        $createdPaths = $gitFunction->writeFiles($dirPath,array($fileName), $this->flysystem,$request->formats->getRealPath(),$directoryPath);

                        //add files
                        //Log::info("INITAL DONE; ADDING FILES: ".print_r($addStructurePath,1));
                        $isAdded = $this->GitRepoService->addFiles($this->flysystem, $addStructurePath);
                        if($isAdded) {
                            //Log::info("INITAL DONE; IS ADDED: COMMITTING ".$corpusCommitpath);
                            $corpusCommitdata = $this->GitRepoService->commitFiles($corpusCommitpath, "Adding files for ", $corpusId, $user->name, $user->email);

                            if(!empty($corpusCommitdata)){
                                //Log::info("INITAL DONE; IS COMMITED ".print_r($corpusCommitdata,1));
                                $setData = $this->laudatioUtilsService->setCommitData($corpusCommitdata,$corpusId);
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
                                        "corpus_id" => $corpus->corpus_id
                                    ));

                                    $corpusObject[$corpus->corpus_id] = $idParams;

                                    $elasticIds = $this->elasticService->getElasticIdByObjectId($corpusIndexName,$corpusObject);
                                    foreach ($elasticIds as $ecorpusId => $elasticId){
                                        $corpus->elasticsearch_id = $elasticIds[$ecorpusId]['elasticsearchid'];
                                        $corpus->elasticsearch_index = $elasticIds[$ecorpusId]['elasticsearchindex'];
                                        $corpus->save();
                                    }

                                    $this->laudatioUtilsService->emptyCorpusCache($corpus->elasticsearch_id,$corpusIndexName);


                                    $annotationParams = array();
                                    foreach($corpus->annotations as $paramannotation) {
                                        $annotationIdParams = array();
                                        array_push($annotationIdParams, array(
                                            "preparation_annotation_id.keyword" => $paramannotation->annotation_id,
                                        ));

                                        array_push($annotationIdParams, array(
                                            "in_corpora" => $corpus->corpus_id
                                        ));
                                        $annotationParams[$paramannotation->id] = $annotationIdParams;
                                    }


                                    $documentParams = array();
                                    foreach($corpus->documents as $paramdocument) {
                                        $documentIdParams = array();
                                        array_push($documentIdParams, array(
                                            "document_id.keyword" => $paramdocument->document_id,
                                        ));

                                        array_push($documentIdParams, array(
                                            "in_corpora" => $corpus->corpus_id
                                        ));
                                        $documentParams[$paramdocument->id] = $documentIdParams;
                                    }


                                    $annotationElasticIds = $this->elasticService->getElasticIdByObjectId($annotationIndexName,$annotationParams);

                                    foreach ($annotationElasticIds as $annotationId => $annotationElasticId){
                                        $annotationToBeUpdated = Annotation::findOrFail($annotationId);
                                        $annotationToBeUpdated->elasticsearch_id = $annotationElasticIds[$annotationId]['elasticsearchid'];
                                        $annotationToBeUpdated->elasticsearch_index = $annotationElasticIds[$annotationId]['elasticsearchindex'];
                                        $annotationToBeUpdated->directory_path = $updatedCorpusPath;
                                        $annotationToBeUpdated->save();
                                        $this->laudatioUtilsService->emptyAnnotationCacheByNameAndCorpusId($annotationToBeUpdated->annotation_id,$corpusId,$annotationIndexName);
                                    }

                                    $this->laudatioUtilsService->emptyAnnotationCacheByCorpusId($corpus->corpus_id,$annotationIndexName);
                                    $this->laudatioUtilsService->emptyAnnotationCacheByAnnotationIndex($annotationIndexName);

                                    $documentElasticIds = $this->elasticService->getElasticIdByObjectId($documentIndexName,$documentParams);

                                    foreach ($documentElasticIds as $documentId => $documentElasticId){
                                        $documentToBeUpdated = Document::findOrFail($documentId);
                                        $documentToBeUpdated->elasticsearch_id = $documentElasticIds[$documentId]['elasticsearchid'];
                                        $documentToBeUpdated->elasticsearch_index = $documentElasticIds[$documentId]['elasticsearchindex'];
                                        $documentToBeUpdated->directory_path = $updatedCorpusPath;
                                        $documentToBeUpdated->save();
                                        $this->laudatioUtilsService->emptyDocumentCacheByDocumentElasticsearchId($documentToBeUpdated->elasticsearch_id,$documentIndexName);
                                    }
                                    $this->laudatioUtilsService->emptyDocumentCacheByDocumentIndex($documentIndexName);
                                    $this->laudatioUtilsService->emptyDocumentCacheByCorpusId($corpus->corpus_id,$documentIndexName);
                                }//end if pushed
                            }//end if returnpath
                        }//end if added
                    }//end if initiallypushed
                }//end if reset
            }//end if pushcorpus
        }//end if corpus is versioned

        return redirect()->route('corpus.edit', ['corpus' => $corpusId]);
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
                $isAdded = $this->GitRepoService->addFiles($this->flysystem, $addPath);

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
        $corpusIsVersioned = null;

        $corpusProjectPath = $dirPathArray[0];
        $corpusPath = $dirPathArray[1];
        $uploadFolder = $dirPathArray[2];

        $corpus = null;

        if(isset($request->corpusid)) {
            $corpus = Corpus::find($corpusId);
            $corpusIsVersioned = $this->laudatioUtilsService->corpusIsVersioned($corpusId);


            $fileName = $request->formats->getClientOriginalName();
            $directoryPath = $this->laudatioUtilsService->getDirectoryPath(array($fileName),$fileName);

            $pathname = $request->formats->getPathName();
            $directoryPath = $this->laudatioUtilsService->getDirectoryPath(array($fileName),$fileName);

            $gitFunction = new GitFunction();

            $extension = substr($fileName,strrpos($fileName,"."));
            $newFileName = "corpusLogo".$extension;
            $createdPaths = $gitFunction->writeFiles($dirPath,array($newFileName), $this->flysystem,$request->formats->getRealPath(),$newFileName);

            $addPath = $corpusProjectPath.'/'.$corpusPath.'/'.$uploadFolder.'/'.$newFileName;
            $commitPath = $corpusProjectPath.'/'.$corpusPath.'/'.$uploadFolder;
            $pushPath = $corpusProjectPath.'/'.$corpus->directory_path.'/'.$uploadFolder;


            if(strpos($createdPaths[0],$dirPath) !== false){

                //add files
                $isAdded = $this->GitRepoService->addFiles($this->flysystem, $addPath);

                //git commit The files
                if($isAdded) {
                    $corpus->corpus_logo = $newFileName;
                    $corpus->save();

                    $this->laudatioUtilsService->setCorpusLogoSymLink($this->flysystem,$addPath);

                    if($corpusIsVersioned){
                        $returnPath = $this->GitRepoService->commitFiles($commitPath, "Adding files for " . $newFileName, $corpusId, $user->name, $user->email);
                        if (!empty($returnPath)) {
                            $isPushed = $this->GitRepoService->pushFiles($pushPath, $corpusId, $user);
                        }
                    }
                }

            }
        }

        return redirect()->route('corpus.edit', ['corpus' => $corpusId]);
    }

    public function convertOctalToCharacter($octal) {
        return chr(octdec($octal[1]));
    }

}
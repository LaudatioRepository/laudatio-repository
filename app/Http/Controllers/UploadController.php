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
            $xmlNode = simplexml_load_file($xmlpath);
            $json = $this->laudatioUtilsService->parseXMLToJson($xmlNode, array());
            //Log::info("json: ".print_r(json_encode($json),1));
            $jsonPath = new JSONPath($json, JSONPath::ALLOW_MAGIC);
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
                $addPath = $corpusProjectPath.'/'.$corpus->directory_path.'/TEI-HEADERS/corpus/';
                $commitPath = $corpusProjectPath.'/'.$corpus->directory_path.'/TEI-HEADERS/corpus/'.$fileName;
                $commitDataPath = 'TEI-HEADERS/corpus/'.$fileName;
            }

            //upload
            $createdPaths = $gitFunction->writeFiles($dirPath,array($fileName), $this->flysystem,$request->formats->getRealPath(),$directoryPath);

            //add
            $isAdded = $this->GitRepoService->addFiles($addPath);
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
                    }


                    //empty cache
                    $this->laudatioUtilsService->emptyDocumentCacheByCorpusId($corpus->corpus_id);
                    $this->laudatioUtilsService->emptyDocumentCacheByDocumentId($document->id);
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
                        }
                    }

                    //empty cache
                    $this->laudatioUtilsService->emptyAnnotationCacheByCorpusId($corpus->corpus_id);
                    $this->laudatioUtilsService->emptyAnnotationCacheByAnnotationId($annotation->id);

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

                    //empty cache
                    $this->laudatioUtilsService->emptyCorpusCache($corpus->corpus_id);
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
                $corpusTitle = $jsonPath->find('$.TEI.teiHeader.fileDesc.titleStmt.title')->data();

                $corpusDescription = $jsonPath->find('$.TEI.teiHeader.encodingDesc[0].projectDesc.p.text')->data();
                $corpusPublicationVersions = $jsonPath->find('$.TEI.teiHeader.revisionDesc.change.n')->data();

                if(empty($corpusPublicationVersions)) {
                    $corpusPublicationVersions = $jsonPath->find('$.TEI.teiHeader.revisionDesc.change[*].n')->data();
                }
                $corpusPublicationVersion = max(array_values($corpusPublicationVersions));

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
            }
            else if($headerPath == 'annotation') {
                //write to db
                $annotation = $this->laudatioUtilsService->setAnnotationAttributes($json,$corpusId,$user->id,$fileName,false);
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
                $filePath = $updatedCorpusPath.'/TEI-HEADERS/corpus/'.$fileName;
                $addPath = $updatedCorpusPath.'/TEI-HEADERS/';
                $initialCommitPath = $updatedCorpusPath;
                $corpusCommitpath = $updatedCorpusPath.'/TEI-HEADERS/';
                $initialPushPath = $updatedCorpusPath;
            }

            $isPushed = false;
            $pushPath = $corpusProjectPath.'/'.$corpus->directory_path;

            if($pushCorpusStructure && !empty($initialPushPath) && $remoteRepoUrl){
                $addRemote = $this->GitRepoService->addRemote($remoteRepoUrl,$initialPushPath);
                $hooksAdded = $this->GitRepoService->addHooks($initialPushPath, $user->name, $user->email);
                $isReset = $this->GitRepoService->resetAdd($initialPushPath,array("TEI-HEADERS"));

                if($isReset) {
                    $hookCommitdata = $this->GitRepoService->commitFile($initialCommitPath.'/githooks', "Adding githooks",$corpusId, $user->name, $user->email);
                    $isInitiallyPushed = $this->GitRepoService->initialPush($initialPushPath,$user);

                    if($isInitiallyPushed) {
                        //Log::info("INITIALLYPUSHED: ".print_r($isInitiallyPushed,1));
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
                        $isAdded = $this->GitRepoService->addFiles($addPath);
                        if($isAdded) {
                            $corpusCommitdata = $this->GitRepoService->commitFiles($corpusCommitpath, "Adding files for ", $corpusId, $user->name, $user->email);
                            Log::info("CORCORPUSCOMMITDATA: ".print_r($corpusCommitdata,1));
                            if(!empty($corpusCommitdata)){
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

                                    $this->laudatioUtilsService->emptyCorpusCache($corpus->corpus_id);


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
                                        $this->laudatioUtilsService->emptyAnnotationCacheByAnnotationId($annotationToBeUpdated->id);
                                    }



                                    $documentElasticIds = $this->elasticService->getElasticIdByObjectId($documentIndexName,$documentParams);

                                    foreach ($documentElasticIds as $documentId => $documentElasticId){
                                        $documentToBeUpdated = Document::findOrFail($documentId);
                                        $documentToBeUpdated->elasticsearch_id = $documentElasticIds[$documentId]['elasticsearchid'];
                                        $documentToBeUpdated->elasticsearch_index = $documentElasticIds[$documentId]['elasticsearchindex'];
                                        $documentToBeUpdated->directory_path = $updatedCorpusPath;
                                        $documentToBeUpdated->save();
                                        $this->laudatioUtilsService->emptyDocumentCacheByDocumentId($documentToBeUpdated->id);
                                    }

                                    $this->laudatioUtilsService->emptyDocumentCacheByCorpusId($corpus->corpus_id);
                                    $this->laudatioUtilsService->emptyAnnotationCacheByCorpusId($corpus->corpus_id);


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
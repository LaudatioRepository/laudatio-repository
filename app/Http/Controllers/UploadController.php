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

        $corpusProjectDB = DB::table('corpus_projects')->where('directory_path',$corpusProjectPath)->get();
        $corpusProjectId = $corpusProjectDB[0]->gitlab_id;
        if(isset($request->corpusid))
        $corpus = Corpus::find($corpusId);

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

        $isVersioned = false;
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

            if($headerPath == 'document'){
                $document = $this->laudatioUtilsService->setDocumentAttributes($json,$corpusId,$user->id,$fileName,false);
                $isVersioned = $this->laudatioUtilsService->documentIsVersioned($document->id);
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

                $isVersioned = $this->laudatioUtilsService->annotationIsVersioned($annotation->id);
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

            if( $headerPath == 'corpus'
                && $corpus->file_name != $fileName
                && strpos($corpus->name,"Untitled") === false){
                $canUpload = false;
            }

            //read data
            $isVersioned = $this->laudatioUtilsService->corpusIsVersioned($corpusId);
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
                if(!$isVersioned){

                    $updatedCorpusPath = $this->GitRepoService->updateCorpusFileStructure($this->flysystem,$corpusProjectPath,$corpus->directory_path,$corpusTitle[0]);

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


                            if($gitLabResponse['id']){
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
                    if($canUpload){
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

                }


                if(!$isVersioned){
                    $filePath = $updatedCorpusPath.'/TEI-HEADERS/corpus/'.$fileName;
                    $addPath = $updatedCorpusPath.'/TEI-HEADERS/corpus/';
                    $commitPath = $updatedCorpusPath.'/TEI-HEADERS/corpus/'.$fileName;
                    $initialPushPath = $updatedCorpusPath;
                }
                else{
                    $filePath = $corpusProjectPath."/".$updatedCorpusPath.'/TEI-HEADERS/corpus/'.$fileName;
                    $addPath = $corpusProjectPath.'/'.$corpus->directory_path.'/TEI-HEADERS/corpus/';
                    $commitPath = $corpusProjectPath.'/'.$corpus->directory_path.'/TEI-HEADERS/corpus/'.$fileName;

                }
            }

        }//end if


        if($canUpload){
            $gitFunction = new GitFunction();
            $directoryPath = $this->laudatioUtilsService->getDirectoryPath(array($fileName),$fileName);

            $pushPath = $corpusProjectPath.'/'.$corpus->directory_path;


            //we have added a corpus, and push the corpus file structure to gitlab
            if($pushCorpusStructure && !empty($initialPushPath) && $remoteRepoUrl){
                $this->GitRepoService->addRemote($remoteRepoUrl,$initialPushPath);
                $hooksAdded = $this->GitRepoService->addHooks($initialPushPath, $user->name, $user->email);
                $this->GitRepoService->initialPush($initialPushPath,$user);
                $tag = $this->GitRepoService->setCorpusVersionTag($initialPushPath,'{\"corpusIndex\":\"'.$corpusIndexName.'\",\"documentIndex\":\"'.$documentIndexName.'\",\"annotationIndex\":\"'.$annotationIndexName.'\",\"guidelineIndex\":\"'.$guidelineIndexName.'\",\"corpusid\": \"'.$corpusId.'\", \"username\": \"'.$user->name.'\", \"useremail\": \"'.$user->email.'\" }',0.0,$user->name,$user->email, false);
                Log::info("canUpload:TAGGED: ".print_r($tag,1));


                $createdPaths = $gitFunction->writeFiles($dirPath,array($fileName), $this->flysystem,$request->formats->getRealPath(),$directoryPath);

                //add files
                $isAdded = $this->GitRepoService->addFiles($addPath,$corpusId);

                //git commit The files
                if($isAdded) {
                    $returnPath = $this->GitRepoService->commitFiles($commitPath,"Adding files for ".$fileName,$corpusId,$user->name,$user->email);

                    if(!empty($returnPath)){
                        $isPushed = $this->GitRepoService->pushFiles($pushPath,$corpusId,$user);

                        if($isPushed) {
                            $params = array(
                                'elasticsearch_index' => $corpusIndexName,
                                'guidelines_elasticsearch_index' => $guidelineIndexName,
                                'file_name' => $fileName
                            );

                            $corpus = $this->laudatioUtilsService->updateCorpusAttributes($params,$corpusId);
                        }
                    }

                }

            }
            else {
                $createdPaths = $gitFunction->writeFiles($dirPath,array($fileName), $this->flysystem,$request->formats->getRealPath(),$directoryPath);

                $isAdded = $this->GitRepoService->addFiles($addPath,$corpusId);
                //git commit The files
                if($isAdded) {
                    $returnPath = $this->GitRepoService->commitFiles($commitPath,"Adding files for ".$fileName,$corpusId,$user->name,$user->email);
                    if(!empty($returnPath)){
                        $isPushed = $this->GitRepoService->pushFiles($pushPath,$corpusId,$user);
                    }

                }
            }

            $corpusPublicationVersion = $this->laudatioUtilsService->getCorpusVersion($corpus->corpus_id);
            $corpusWorkflowStatus = $this->laudatioUtilsService->getWorkFlowStatus($corpus->corpus_id);

            // fetch the elastic id and index
            if($headerPath == 'corpus') {
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
            else if($headerPath == 'document'){
                if(!array_key_exists($document->id,$documents)){
                    $documents[$document->id] = array();
                }

                $idParams = array();
                if(isset($corpus->corpus_id)) {
                    array_push($idParams, array(
                        "document_id" => $document->document_id
                    ));

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
            else if($headerPath == 'annotation'){
                if(!array_key_exists($annotation->id,$annotations)){
                    $annotations[$annotation->id] = array();
                }

                $idParams = array();
                if(isset($corpus->corpus_id)) {
                    array_push($idParams, array(
                        "preparation_annotation_id" => $annotation->annotation_id,
                    ));

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




        if($dirPathArray[$last_id] == 'corpus' && !$isVersioned) {
            return redirect()->route('corpus.edit', ['corpus' => $corpusId]);
        }
        else if ($dirPathArray[$last_id] == 'corpus' && $isVersioned){
            return redirect()->route('corpus.edit', ['corpus' => $corpusId]);
        }
        else{
            return redirect()->route('corpus.edit',['corpus' => $corpusId]);
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
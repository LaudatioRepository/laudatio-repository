<?php

namespace App\Http\Controllers;

use App\Publication;
use Illuminate\Http\Request;
use App\Custom\GitRepoInterface;
use App\Custom\GitLabInterface;
use App\Custom\LaudatioUtilsInterface;
use App\Custom\ElasticsearchInterface;
use App\Corpus;
use App\Document;
use App\Annotation;
use App\User;
use App\Role;
use Response;
use JavaScript;
use Log;


class PublicationController extends Controller
{


    protected $GitRepoService;
    protected $LaudatioUtilService;
    protected $GitLabService;
    protected $elasticService;
    protected $indexMappingPath;
    public function __construct(GitRepoInterface $Gitservice,  LaudatioUtilsInterface $laudatioUtilService,GitLabInterface $GitLabService, ElasticsearchInterface $elasticService)
    {
        $this->GitRepoService = $Gitservice;
        $this->LaudatioUtilService = $laudatioUtilService;
        $this->GitLabService = $GitLabService;
        $this->elasticService = $elasticService;
        $this->indexMappingPath = config('laudatio.indexMappingPath');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function publishCorpus(Request $request)
    {

        $result = null;
        $status = "";
        $result = array();
        $update_response = null;
        $user = \Auth::user();

        //try{
            $corpusid = $request->input('corpusid');
            $corpus = Corpus::findOrFail($corpusid);
            $corpuspath = $request->input('corpus_path');
            $auth_user_name = $request->input('auth_user_name');
            $auth_user_email = $request->input('auth_user_email');
            $corpusData = json_decode($this->GitRepoService->checkForCorpusFiles($corpuspath."/TEI-HEADERS"), true);


            //if we can publish, find out what the current publication version is for the corpus

            $publicationArray = array();
            $documentArray = array();
            $annotationArray = array();
            $guidelineArray = array();

            $oldCorpusIndex = $corpus->elasticsearch_index;
            $oldDocumentIndex = "";
            $oldAnnotationIndex = "";
            $oldGuidelineIndex = $corpus->guidelines_elasticsearch_index;

            $documents_in_corpus = $corpusData['found_documents'];
            foreach ($documents_in_corpus as $document) {
                $id = $document['id'];
                $dbDocument = Document::where("document_id",$id)->get();
                $oldDocumentIndex = $dbDocument[0]->elasticsearch_index;
                array_push($documentArray,$dbDocument[0]->elasticsearch_id);
            }


            $guidelines = $this->elasticService->getGuidelinesByCorpus($corpus->corpus_id);

            foreach ($guidelines['result']['hits']['hits'] as $guideline) {
                array_push($guidelineArray,$guideline['_id']);
            }

            $annotations_in_corpus = $corpusData['found_annotations_in_corpus'];
            foreach ($annotations_in_corpus as $annotation) {
                $annotation_id = $annotation;
                $dbAnnotation = Annotation::where("annotation_id",$annotation_id)->get();
                $oldAnnotationIndex = $dbAnnotation[0]->elasticsearch_index;
                array_push($annotationArray,$dbAnnotation[0]->elasticsearch_id);
            }
            //Log::info("annotationArray: ".print_r($annotationArray,1));

            $publicationArray[$corpus->id] = $corpus->elasticsearch_id;
            $publicationArray['documents'] = $documentArray;
            $publicationArray['annotations'] = $annotationArray;
            $publicationArray['guidelines'] = $guidelineArray;

            $result['publicationdata'] = $publicationArray;




            $params = array(
                "index" => "publication",
                "type" => "doc",
                "body" => [
                    "corpus" => $corpus->corpus_id,
                    "publication_version" => $corpus->publication_version,
                    "documents" => $documentArray,
                    "annotations" => $annotationArray,
                    "guidelines" => $guidelineArray,
                    "git_tag" => "v".$corpus->publication_version,
                    "name" => $corpus->name." Version ".$corpus->publication_version,
                    "publication_version" => $corpus->publication_version,
                    "corpus_index" => $oldCorpusIndex,
                    "document_index" => $oldDocumentIndex,
                    "annotation_index" => $oldAnnotationIndex

                ]

            );

            // Log::info("POSTING PUBLICATION: ".print_r($params,1));
            $response = $this->elasticService->postToIndex($params);


            if($response['_shards'] > 0){
                $shards = $response['_shards'];
                if($shards['successful'] > 0
                    && $shards['failed'] == 0
                    && $response['result'] == "created") {

                    //update the publication status in the index
                    $update_params = [
                        'index' => $oldCorpusIndex,
                        'type' => 'doc',
                        'id' => $corpus->elasticsearch_id,
                        'body' => [
                            'doc' => [
                                'publication_status' => '1'
                            ]
                        ]
                    ];

                    $update_response = $this->elasticService->setCorpusToPublished($update_params);
                    Log::info("UPDATE RESPONSE  ".print_r($update_response,1));
                    if(!empty($update_response['_shards'])) {

                        $update_responsestatus = $update_response['_shards'];

                        if ($update_responsestatus['successful'] > 0
                            && $update_responsestatus['failed'] == 0
                        ) {


                            // create a new index for the next working period
                            $now = time();
                            $new_corpus_index = "corpus_".$corpus->corpus_id."_".$now;
                            $new_corpus_elasticsearch_id = $now."_".$corpus->elasticsearch_id;
                            $new_guidelines_elasticsearch_id = $now."_".$corpus->guidelines_elasticsearch_id;

                            $new_document_index = "document_".$corpus->corpus_id."_".$now;
                            $new_annotation_index = "annotation_".$corpus->corpus_id."_".$now;
                            $new_guideline_index = "guideline_".$corpus->corpus_id."_".$now;

                            $corpus->workflow_status = 1;
                            $corpus->save();


                            //create a new corpus to represent the new working period
                            $new_corpus = new Corpus();
                            $new_corpus->name = $corpus->name;
                            $new_corpus->uid = $corpus->uid;
                            $new_corpus->description = $corpus->description;
                            $new_corpus->corpus_size_type = $corpus->corpus_size_type;
                            $new_corpus->corpus_size_value = $corpus->corpus_size_value;
                            $new_corpus->directory_path = $corpus->directory_path;
                            $new_corpus->corpus_id = $corpus->corpus_id;
                            $new_corpus->file_name = $corpus->file_name;
                            $new_corpus->elasticsearch_id = $new_corpus_elasticsearch_id;
                            $new_corpus->guidelines_elasticsearch_index = $new_guideline_index;
                            $new_corpus->elasticsearch_index = $new_corpus_index;
                            $new_corpus->publication_version = "working_period";
                            $new_corpus->gitlab_group_id = $corpus->gitlab_group_id;
                            $new_corpus->gitlab_id = $corpus->gitlab_id;
                            $new_corpus->gitlab_web_url = $corpus->gitlab_web_url;
                            $new_corpus->gitlab_namespace_path = $corpus->gitlab_namespace_path;
                            $new_corpus->workflow_status = 0;
                            $new_corpus->save();

                            //attach user roles

                            $corpusUser = User::find($new_corpus->uid);
                            $corpusAdminRole = Role::findById(3);
                            $corpusUser->roles()->sync($corpusAdminRole);
                            if($corpusUser) {
                                if(!$corpusUser->roles->contains($corpusAdminRole)){
                                    $corpusUser->roles()->attach($corpusAdminRole);
                                }

                                $new_corpus->users()->save($corpusUser,['role_id' => 3]);
                            }


                            /* for each corpusproject attached to this corpus, detach the old corpus (?),
                            and attach the new corpus to the corpus project for the next working period
                            */

                            $corpusProjects = $corpus->corpusprojects()->get();
                            foreach($corpusProjects as $corpusProject) {
                                //$corpusProject->corpora()->detach($corpus->id);
                                $new_corpus->corpusprojects()->attach($corpusProject);
                            }


                            foreach ($corpus->documents()->get() as $document) {
                                $document->workflow_status = 1;
                                $new_document_elasticsearch_id = $now."_".$document->elasticsearch_id;
                                $document->elasticsearch_id = $new_document_elasticsearch_id;
                                $document->save();
                            }

                            foreach ($corpus->annotations()->get() as $annotation) {
                                $annotation->workflow_status = 1;
                                $new_annotation_elasticsearch_id = $now."_".$annotation->elasticsearch_id;
                                $annotation->elasticsearch_id = $new_annotation_elasticsearch_id;
                                $annotation->save();
                            }

                            $tag = "poo";

                            $corpusMatchQuery = array(
                                                    "corpus_id" => $corpus->corpus_id
                                                );

                            $corpusReindexResponse = $this->elasticService->createMappedIndex($this->indexMappingPath.'/corpus_mapping.json', $new_corpus_index, $oldCorpusIndex,$corpusMatchQuery,$new_corpus_elasticsearch_id);
                            Log::info("corpusReindexResponse: ".print_r($corpusReindexResponse,1));




                            //$tag = $this->GitRepoService->setCorpusVersionTag($corpuspath,$corpus->name." version ".$corpus->publication_version,$corpus->publication_version,$corpusid,$auth_user_name,$auth_user_email);
                            if($tag) {
                                $result['publish_corpus_response']  = "The Corpus was successfully published";
                                $status = "success";
                            }
                            else{
                                $status = "error";
                                $result['publish_corpus_response']  = "There was a problem publishing the Corpus. The error was: The corpus could not be published to git due to failed GIT tagging. A message has been sent to the site administrator. Please try again later";
                            }



                        } else {
                            $status = "error";
                            $result['publish_corpus_response'] = "There was a problem publishing the Corpus. The error was: The corpus could not be published to git due to failed updating of the database. A message has been sent to the site administrator. Please try again later";
                        }
                    }
                    else{
                        $status = "error";
                        $result['publish_corpus_response']  = "There was a problem publishing the Corpus. The error was: the update response was empty A message has been sent to the site administrator. Please try again later";
                    }
                }
                else {
                    $status = "error";
                    $result['publish_corpus_response']  = "There was a problem publishing the Corpus. The error was: the shard information was empty A message has been sent to the site administrator. Please try again later";
                }
            }
            else {
                $status = "error";
                $result['publish_corpus_response']  = "There was a problem publishing the Corpus. The update shards were empty. The error was: (".print_r($update_response,1).") A message has been sent to the site administrator. Please try again later";
            }

/*
        }
        catch (\Exception $e) {
            $status = "error";
            $result['publish_corpus_response']  = "There was a problem publishing the Corpus. General try-catch error. The error was: (".print_r($update_response,1).") A message has been sent to the site administrator. Please try again later";
        }

*/
        $response = array(
            'status' => $status,
            'message' => $result,
        );

        return Response::json($response);

    }

    public function preparePublication(Request $request) {

        $result = array();
        $corpusid = $request->input('corpusid');
        $corpus = Corpus::findOrFail($corpusid);
        $corpuspath = $request->input('corpuspath');

        $result['corpus_header'] = array(
            "title" => "1 Corpus header uploaded"
        );

        $result['document_headers'] = array(
            "title" => "According number of Document headers"
        );

        $result['annotation_headers'] = array(
            "title" => "According number of Annotation headers"
        );

        $workFlowStatus = null;
        $corpusVersion = null;
        $canPublish = true;


        if(!$corpus->corpus_id){
            $result['corpus_header']['corpusHeaderText'] = "Missing corpusheader";
            $result['corpus_header']['corpusIcon'] = 'warning';
            $canPublish = false;
        }
        else{
            $workFlowStatus = $this->LaudatioUtilService->getWorkFlowStatus($corpus->corpus_id);
            $corpusVersion = $this->LaudatioUtilService->getCorpusVersion($corpus->corpus_id);
            $result['corpus_header']['corpusHeaderText'] = "";
            $result['corpus_header']['corpusIcon'] = 'check_circle';
        }



        $result['title'] = "Publish ".$corpus->name.", Version ".$corpusVersion;
        $result['subtitle'] = "The following criteria needs to be met in order to be fulfilled before you can publish a Corpus";
        $result['waiting'] = "Verification is ongoing...";


        $checkResult = json_decode($this->GitRepoService->checkForCorpusFiles($corpuspath."/TEI-HEADERS"), true);

        $missing_document_count = count($checkResult['not_found_documents_in_corpus']);
        $document_plural = "";
        if($missing_document_count > 1){
            $document_plural = "s";
        }

        if($missing_document_count >= 1) {
            $result['document_headers']['documentHeaderText'] = $missing_document_count." missing document".$document_plural;
            $result['document_headers']['documentIcon'] = 'warning';
            $canPublish = false;
        }
        else{
            $result['document_headers']['documentHeaderText'] = "";
            $result['document_headers']['documentIcon'] = 'check_circle';
        }

        $missing_annotation_count = count($checkResult['not_found_annotations_in_corpus']);
        $annotation_plural = "";
        if($missing_annotation_count > 1){
            $annotation_plural = "s";
        }

        if($missing_annotation_count > 0) {
            $result['annotation_headers']['annotationHeaderText'] = $missing_annotation_count." missing annotation".$annotation_plural;
            $result['annotation_headers']['annotationIcon'] = 'warning';
            $canPublish = false;
        }
        else{
            $result['annotation_headers']['annotationHeaderText'] = "";
            $result['annotation_headers']['annotationIcon'] = 'check_circle';
        }

        $result['canPublish'] = $canPublish;
        /**
         * @todo
         * */
        //corpusdata formats

        //license


        $response = array(
            'status' => 'success',
            'msg' => $result,
        );

        return Response::json($response);
    }

    public function checkCorpusContent(Request $request) {

        $result = array();
        $corpusid = $request->input('corpusid');
        $corpus = Corpus::findOrFail($corpusid);
        $corpuspath = $request->input('corpuspath');


        $checkResult = json_decode($this->GitRepoService->checkForCorpusFiles($corpuspath."/TEI-HEADERS"), true);
        $result['checkdata'] = $checkResult;

        $response = array(
            'status' => 'success',
            'msg' => $result,
        );

        return Response::json($response);
    }
}

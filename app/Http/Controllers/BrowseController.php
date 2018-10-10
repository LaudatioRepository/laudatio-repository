<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Custom\ElasticsearchInterface;
use App\Custom\LaudatioUtilsInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use JavaScript;
use Log;

class BrowseController extends Controller
{

    protected $ElasticService;
    protected $LaudatioUtilService;
    protected $ccBaseUri;

    public function __construct(ElasticsearchInterface $Elasticservice, LaudatioUtilsInterface $laudatioUtils)
    {
        $this->ElasticService = $Elasticservice;
        $this->LaudatioUtilService = $laudatioUtils;
        $this->ccBaseUri = config('laudatio.ccBaseuri');
    }

    public function index($perPage = null,$sortKriterium = null){
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();

        $corpusresponses = $this->ElasticService->getPublishedCorpora();
        //dd($corpusresponses);
        $corpusdata = array();
        $documentcount = 0;
        $annotationcount = 0;

        $entries = null;
        $perPageArray = array();
        $sortedCollection = array();
        $perPage = null;

        $entries = null;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        //dd($corpusresponses);
        if(count($corpusresponses['result']) > 0){
            $document_range = "";
            foreach($corpusresponses['result'][0] as $publicationresponse){
                //dd($publicationresponse);

                if(isset($publicationresponse['_source']['corpus_index'])) {
                    $current_corpus_index = $publicationresponse['_source']['corpus_index'];
                }

                if(isset($publicationresponse['_source']['documents'])) {
                    $documentcount = count($publicationresponse['_source']['documents']);
                }

                if(isset($publicationresponse['_source']['annotations'])) {
                    $annotationcount = count($publicationresponse['_source']['annotations']);
                }


                if(isset($publicationresponse['_source']['document_index'])) {
                    $current_document_index = $publicationresponse['_source']['document_index'];
                }

                if(isset($publicationresponse['_source']['annotation_index'])) {
                    $current_annotation_index = $publicationresponse['_source']['annotation_index'];
                }


                $documentResult = $this->ElasticService->getDocumentByCorpus(
                    array(array("in_corpora" => $publicationresponse['_source']['corpus'])),
                    array($publicationresponse['_source']['corpus']),
                    $current_document_index
                );


                if(!empty($current_corpus_index)){
                    $document_dates = array();

                    if (count($documentResult) > 0 && isset($documentResult[$publicationresponse['_source']['corpus']])){
                        for($d = 0; $d < count($documentResult[$publicationresponse['_source']['corpus']]); $d++) {
                            $doc = $documentResult[$publicationresponse['_source']['corpus']][$d];
                            array_push($document_dates, Carbon::createFromFormat ('Y' , $doc['_source']['document_publication_publishing_date'][0])->format ('Y'));
                        }

                        sort($document_dates);
                    }

                    if(count($document_dates) > 0){
                        if($document_dates[count($document_dates) -1] > $document_range = $document_dates[0]) {
                            $document_range = $document_dates[0]." - ".$document_dates[count($document_dates) -1];
                        }
                        else{
                            $document_range = $document_dates[0];
                        }
                    }

                    if(!array_key_exists($publicationresponse['_source']['corpus'],$corpusdata)){


                        $publishedCorpusid = $this->LaudatioUtilService->getElasticSearchIdByCorpusId($publicationresponse['_source']['corpus'],$current_corpus_index);

                        if(!empty($publishedCorpusid)){
                            $apiData = $this->ElasticService->getCorpus($publishedCorpusid,true,$current_corpus_index);
                            $corpusresponse = json_decode($apiData->getContent(), true);

                            $authors = "";
                            for($i = 0; $i < count($corpusresponse['result']['corpus_editor_forename']); $i++){
                                $authors .= $corpusresponse['result']['corpus_editor_surname'][$i].", ".$corpusresponse['result']['corpus_editor_forename'][$i].";";
                            }


                            $corpus_publication_date = "01.01.1900";
                            for($j = 0; $j < count($corpusresponse['result']['corpus_publication_publication_date']); $j++) {
                                $date =   $corpusresponse['result']['corpus_publication_publication_date'][$j];
                                if($date > $corpus_publication_date) {
                                    $corpus_publication_date = $date;
                                }
                            }

                            $corpusdata[$publicationresponse['_source']['corpus']] = array(
                                'corpus_title' => $publicationresponse['_source']['name'],
                                'corpus_version' => $publicationresponse['_source']['publication_version'],
                                'authors' => $authors,
                                'corpus_languages_language' => $corpusresponse['result']['corpus_languages_language'][0],
                                'corpus_size_value' => str_replace(array(',','.'),'',$corpusresponse['result']['corpus_size_value'][0]),
                                'corpus_publication_date' => $corpus_publication_date,
                                'corpus_publication_license' => $corpusresponse['result']['corpus_publication_license'][0],
                                'corpus_encoding_project_description' => $publicationresponse['_source']['description'],
                                'document_genre' => $this->LaudatioUtilService->getDocumentGenreByCorpusId($corpusresponse['result']['corpus_id'][0],$current_corpus_index),
                                'document_publication_range' => $document_range,
                                'download_path' => $this->LaudatioUtilService->getCorpusPathByCorpusId($publishedCorpusid,$current_corpus_index),
                                'documentcount' => $documentcount,
                                'annotationcount' => $annotationcount,
                                'elasticid' => $publishedCorpusid
                            );
                        }
                    }
                }
            }

            $collection = new Collection($corpusdata);
            //dd($collection);
            $kriterium = null;
            $sortKriteria = array(
                "1" => "corpus_title",
                "2" => "corpus_size_value",
                "3_desc" => "corpus_size_value",
                "4" => "corpus_publication_date",
                "5_desc" => "corpus_publication_date",
                "6" => "document_publication_range",
                "7_desc" => "document_publication_range"
            );

            if(!isset($sortKriterium)) {
                $kriterium = "corpus_title";
            }
            else{
                switch($sortKriterium){
                    case 3:
                    case 5:
                    case 7:
                        $sortKriterium .= "_desc";
                        break;
                }
                $kriterium = $sortKriteria[$sortKriterium];
            }

            $sortedCollection = null;
            if(strpos($sortKriterium, "desc") !== false) {
                $sortedCollection = $collection->sortByDesc($kriterium, SORT_NATURAL|SORT_FLAG_CASE);
            }
            else{
                $sortedCollection = $collection->sortBy($kriterium,SORT_NATURAL|SORT_FLAG_CASE);
            }

            if(!isset($perPage)) {
                $perPage  = 4;
            }

            $perPageArray = array(
                $perPage => "",
                "6" => "",
                "12" => "",
                "18" => "",
                "all" => ""
            );

            if($perPage == count($sortedCollection)){
                $perPageArray['all'] = "selected";
            }
            else{
                $perPageArray[$perPage] = "selected";
            }


            $currentPageSearchResults = $sortedCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $entries = new LengthAwarePaginator($currentPageSearchResults, count($sortedCollection), $perPage, $currentPage,['path' => LengthAwarePaginator::resolveCurrentPath()] );

        }

        return view('browse.index')
            ->with('isLoggedIn', $isLoggedIn)
            ->with('corpusdata',$entries)
            ->with('totalCount',count($sortedCollection))
            ->with('perPageArray',$perPageArray)
            ->with('perPage',$perPage)
            ->with('ccBaseUri',$this->ccBaseUri)
            ->with('user',$user);
    }

    /**
     * @param $header
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($header,$id){
        $data = null;
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();
        $corpusElasticId = null;
        $citeData = array();
        $corpusVersion = null;
        $workFlowStatus = null;
        $corpusName = null;
        $corpusPublicationLicense = null;
        $current_corpus_index = "";

        if($isLoggedIn) {
            //dd($user);
        }

        switch ($header){
            case "corpus":
                //get the current index for the corpus....
                $current_corpus_index = $this->LaudatioUtilService->getCurrentCorpusIndexByElasticsearchId($id);
                Log::info("CURRENTCORPUSINDEX: ".$current_corpus_index);
                $current_document_index = str_replace("corpus","document",$current_corpus_index);
                Log::info("CURRENTDOCINDEX: ".$current_document_index);
                $current_annotation_index = str_replace("corpus","annotation",$current_corpus_index);
                Log::info("current_annotation_index: ".$current_annotation_index);

                $apiData = $this->ElasticService->getCorpus($id,true,$current_corpus_index);
                $data = json_decode($apiData->getContent(), true);
                //dd($data);
                //dd($current_corpus_index);
                $citeData['authors'] = array();
                for($i=0;$i< count($data['result']['corpus_editor_forename']);$i++) {
                    array_push($citeData['authors'],$data['result']['corpus_editor_forename'][$i]." ".$data['result']['corpus_editor_surname'][$i]);
                }

                $corpusName = $data['result']['corpus_title'][0];

                $citeData['title'] = $data['result']['corpus_title'][0];
                $citeData['version'] = $data['result']['corpus_version'][count($data['result']['corpus_version']) -1];
                $citeData['publishing_year'] = $citeData['publishing_year'] = date('Y',strtotime($data['result']['corpus_publication_publication_date'][0]));//Carbon::createFromFormat ('Y-m-d' , $data['result']['corpus_publication_publication_date'][0])->format ('Y');
                $citeData['publishing_institution'] = $data['result']['corpus_publication_publisher'][0];
                $citeData['corpus_publication_license'] = $data['result']['corpus_publication_license'][0];
                $citeData['published_handle'] = "";

                $corpusId = is_array($data['result']['corpus_id']) ? $data['result']['corpus_id'][0]: $data['result']['corpus_id'];

                //@todo: get the correct docs and annotations based on the correct corpus_id => in_corpora

                $corpusVersion =  $data['result']['publication_version'][0];
                $workFlowStatus = $data['result']['publication_status'];
                $corpusPublicationLicense = $data['result']['corpus_publication_license'][0];


                $formatSearchResult = $this->ElasticService->getFormatsByCorpus($corpusId,$current_corpus_index);
                $formats = array();
                if(isset($formatSearchResult['aggregations'])){
                    foreach ($formatSearchResult['aggregations']['formats']['buckets'] as $formatSearchResult) {
                        array_push($formats,$formatSearchResult['key']);
                    }
                }

                $data['result']['formats'] = $formats;

                $documentResult = $this->ElasticService->getDocumentByCorpus(
                    array(array("in_corpora" => $corpusId)),
                    array($corpusId),
                    $current_document_index
                );

                $document_dates = array();
                $document_range = "";

                if (array_key_exists($data['result']['corpus_id'][0],$documentResult)){
                    for($d = 0; $d < count($documentResult[$data['result']['corpus_id'][0]]); $d++) {
                        $doc = $documentResult[$data['result']['corpus_id'][0]][$d];
                        array_push($document_dates, Carbon::createFromFormat ('Y' , $doc['_source']['document_publication_publishing_date'][0])->format ('Y'));
                    }

                    sort($document_dates);

                    if($document_dates[count($document_dates) -1] > $document_range = $document_dates[0]) {
                        $document_range = $document_dates[0]." - ".$document_dates[count($document_dates) -1];
                    }
                    else{
                        $document_range = $document_dates[0];
                    }
                }


                $allDocumentsResult = $this->ElasticService->getDocumentsByDocumentId($data['result']['corpus_documents'],$current_document_index);

                $corpusDocuments = array();

                $documentcount = 0;
                foreach ($documentResult as $cid => $cdata) {
                    foreach ($cdata as $citem) {
                        $documentArray = array();
                        $documentArray['document_id'] = $citem['_id'];
                        $documentArray["document_title"] = $citem['_source']["document_title"];
                        $documentArray["document_publication_publishing_date"] = $citem['_source']["document_publication_publishing_date"];
                        $documentArray["document_publication_place"] = $citem['_source']["document_publication_place"];
                        $documentArray["document_list_of_annotations_name"] = $citem['_source']["document_list_of_annotations_name"];
                        $documentArray["document_size_extent"] = $citem['_source']["document_size_extent"];
                        array_push($corpusDocuments, $documentArray);
                        $documentcount++;
                    }
                }
                $data['result']['corpusdocuments'] = $corpusDocuments;
                $data['result']['corpusdocumentcount'] = $documentcount;

                //dd($data);

                $annotationMapping = array();
                $annotationcount = 0;
                $totalannotationcount = count($data['result']['annotation_id']);
                $foundAnnotationCorpus = array();
                foreach($data['result']['annotation_id'] as $annotationId){
                    $annotators = array();

                    $annotationData = $this->ElasticService->getAnnotationByNameAndCorpusId($annotationId,$corpusId, array(
                        "preparation_encoding_annotation_group",
                        "preparation_annotation_id",
                        "_id",
                        "preparation_title",
                        "in_documents",
                        "in_corpora",
                        "preparation_author_annotator_forename",
                        "preparation_author_annotator_surname",
                        "generated_id"
                    ),$current_annotation_index);
                    //dd($corpusId);
                    if(!$annotationData['error'] && count($annotationData['result']) > 0){

                        if(array_key_exists('preparation_encoding_annotation_group', $annotationData['result'][0]['_source'])){
                            if(!array_key_exists($annotationData['result'][0]['_id'],$annotators)){
                                $annotators[$annotationData['result'][0]['_id']] = array();
                                if(array_key_exists('preparation_author_annotator_forename', $annotationData['result'][0]['_source'])){
                                    for($a=0; $a < count($annotationData['result'][0]['_source']['preparation_author_annotator_forename']); $a++){
                                        array_push($annotators[$annotationData['result'][0]['_id']], $annotationData['result'][0]['_source']['preparation_author_annotator_forename'][$a]." ".$annotationData['result'][0]['_source']['preparation_author_annotator_surname'][$a]);
                                    }
                                }

                            }



                            $groups = array_unique($annotationData['result'][0]['_source']['preparation_encoding_annotation_group']);
                            foreach ($groups as $group){
                                if(!array_key_exists($group,$annotationMapping)){
                                    $annotationMapping[$group] = array();
                                }
                                $dataArray = array();
                                if(array_key_exists('in_documents', $annotationData['result'][0]['_source'])){
                                    $dataArray['document_count'] = floatval(count($annotationData['result'][0]['_source']['in_documents']));
                                }
                                $dataArray['title'] = $annotationData['result'][0]['_source']['preparation_annotation_id'][0];
                                $dataArray['preparation_annotation_id'] = $annotationData['result'][0]['_id'];

                                $dataArray['annotators'] = $annotators;
                                array_push($annotationMapping[$group],$dataArray);
                            }
                            if(!in_array($annotationData['result'][0]['_source']['preparation_annotation_id'][0],$foundAnnotationCorpus)){
                                $annotationcount++;
                            }
                            array_push($foundAnnotationCorpus,$annotationData['result'][0]['_source']['preparation_annotation_id'][0]);
                        }
                    }

                }

                $allAnnotationGroupResult = $this->ElasticService->getAnnotationGroups(
                    array(
                        "field" => "in_corpora",
                        "value" => $corpusId
                    ),$current_annotation_index
                );

                $allAnnotationGroups = array();
                if(isset($allAnnotationGroupResult['aggregations'])){
                    foreach($allAnnotationGroupResult['aggregations']['annotations']['buckets'] as $groupdata) {
                        array_push($allAnnotationGroups,$groupdata['key']);
                    }
                }


                $data['result']['workflow_status'] = $workFlowStatus;
                $data['result']['corpus_version'] = $corpusVersion;
                $data['result']['corpusPublicationLicense'] = $corpusPublicationLicense;
                $data['result']['corpusAnnotationGroups'] = $annotationMapping;
                $data['result']['allAnnotationGroups'] = $allAnnotationGroups;
                $data['result']['corpusannotationcount'] = $annotationcount;
                $data['result']['totalcorpusannotationcount'] = $totalannotationcount;
                $data['result']['document_genre'] = $this->LaudatioUtilService->getDocumentGenreByCorpusId($corpusId,$current_corpus_index);
                $data['result']['document_range'] = $document_range;


                break;
            case "document":
                $current_corpus_index = $this->LaudatioUtilService->getCurrentCorpusIndexByDocumentElasticsearchId($id);
                $current_document_index = str_replace("corpus","document",$current_corpus_index);
                $current_annotation_index = str_replace("corpus","annotation",$current_corpus_index);

                $apiData = $this->ElasticService->getDocument($id,true,$current_document_index);
                $data = json_decode($apiData->getContent(), true);

                $corpusId = is_array($data['result']['in_corpora']) ? $data['result']['in_corpora'][0]: $data['result']['in_corpora'];

                if($corpusId){

                    $documentCorpusdata = $this->ElasticService->getCorpusByDocument(array(array('corpus_id' => $corpusId)),array($id),$current_corpus_index);

                    $data['result']['documentCorpusdata'] = $documentCorpusdata[$id][0]['_source'];

                    $citeData['authors'] = array();
                    for($i=0;$i< count($data['result']['documentCorpusdata']['corpus_editor_forename']);$i++) {
                        array_push($citeData['authors'],$data['result']['documentCorpusdata']['corpus_editor_forename'][$i]." ".$data['result']['documentCorpusdata']['corpus_editor_surname'][$i]);
                    }

                    $corpusName = $data['result']['documentCorpusdata']['corpus_title'][0];
                    $corpusVersion =  $data['result']['documentCorpusdata']['publication_version'][0];
                    $workFlowStatus = $data['result']['documentCorpusdata']['publication_status'];
                    $corpusPublicationLicense = $data['result']['documentCorpusdata']['corpus_publication_license'][0];

                    $citeData['title'] = $data['result']['documentCorpusdata']['corpus_title'][0];
                    $citeData['version'] = $data['result']['documentCorpusdata']['corpus_version'][count($data['result']['documentCorpusdata']['corpus_version']) -1];
                    $citeData['publishing_year'] = date('Y',strtotime($data['result']['documentCorpusdata']['corpus_publication_publication_date'][0]));//Carbon::createFromFormat ('Y-m-d' , $data['result']['documentCorpusdata']['corpus_publication_publication_date'][0])->format ('Y');
                    $citeData['publishing_institution'] = $data['result']['documentCorpusdata']['corpus_publication_publisher'][0];
                    $citeData['published_handle'] = "";


                    $annotationMapping = array();
                    $documentannotationcount = 0;
                    $totalannotationcount = count($data['result']['document_list_of_annotations_id']);
                    $foundAnnotationDocument = array();
                    foreach($data['result']['document_list_of_annotations_id'] as $annotationId){
                        $annotationData = $this->ElasticService->getAnnotationByNameAndCorpusId($annotationId,$corpusId, array(
                            "preparation_encoding_annotation_group",
                            "preparation_annotation_id",
                            "_id",
                            "preparation_title",
                            "in_documents",
                            "in_corpora",
                            "preparation_author_annotator_forename",
                            "preparation_author_annotator_surname",
                            "generated_id"
                        ),$current_annotation_index);

                        if(!$annotationData['error'] && count($annotationData['result']) > 0){
                            if(array_key_exists('preparation_encoding_annotation_group', $annotationData['result'][0]['_source'])){
                                $groups = array_unique($annotationData['result'][0]['_source']['preparation_encoding_annotation_group']);
                                foreach ($groups as $group){
                                    if(!array_key_exists($group,$annotationMapping)){
                                        $annotationMapping[$group] = array();
                                    }
                                    $dataArray = array();
                                    if(array_key_exists('in_documents', $annotationData['result'][0]['_source'])){
                                        $dataArray['document_count'] = floatval(count($annotationData['result'][0]['_source']['in_documents']));
                                    }

                                    $dataArray['title'] = $annotationData['result'][0]['_source']['preparation_title'][0];
                                    $dataArray['preparation_annotation_id'] = $annotationData['result'][0]['_id'];
                                    array_push($annotationMapping[$group],$dataArray);
                                }
                                if(!in_array($annotationData['result'][0]['_id'],$foundAnnotationDocument)){
                                    $documentannotationcount++;
                                }
                                array_push($foundAnnotationDocument,$annotationData['result'][0]['_id']);
                            }
                        }

                    }

                    $allAnnotationGroupResult = $this->ElasticService->getAnnotationGroups(
                        array(
                            "field" => "in_corpora",
                            "value" => $corpusId
                        ),$current_annotation_index
                    );
                    $allAnnotationGroups = array();
                    if(isset($allAnnotationGroupResult['aggregations'])){
                        foreach($allAnnotationGroupResult['aggregations']['annotations']['buckets'] as $groupdata) {
                            array_push($allAnnotationGroups,$groupdata['key']);
                        }
                    }

                    $data['result']['workflow_status'] = $workFlowStatus;
                    $data['result']['corpus_version'] = $corpusVersion;
                    $data['result']['allAnnotationGroups'] = $allAnnotationGroups;
                    $data['result']['documentannotationcount'] = $documentannotationcount;
                    $data['result']['annotationGroups'] = $annotationMapping;
                    $data['result']['totaldocumentannotationcount'] = $totalannotationcount;
                }

                break;
            case "annotation":
                $current_corpus_index = $this->LaudatioUtilService->getCurrentCorpusIndexByAnnotationElasticsearchId($id);
                $current_document_index = str_replace("corpus","document",$current_corpus_index);
                $current_annotation_index = str_replace("corpus","annotation",$current_corpus_index);
                $current_guideline_index = str_replace("corpus","guideline",$current_corpus_index);

                $apiData = $this->ElasticService->getAnnotation($id,true,$current_annotation_index);
                $data = json_decode($apiData->getContent(), true);
                $corpusId = is_array($data['result']['in_corpora']) ? $data['result']['in_corpora'][0]: $data['result']['in_corpora'];
                //$workFlowStatus = $this->LaudatioUtilService->getWorkFlowStatus($corpusId);
                //$corpusVersion = $this->LaudatioUtilService->getCorpusVersion($corpusId);

                if($corpusId){
                    $annotationCorpusdata = $this->ElasticService->getCorporaByAnnotation(array(array('corpus_id' => $corpusId)),array($id),$current_corpus_index);
                    $data['result']['annotationCorpusdata'] = $annotationCorpusdata[$id][0]['_source'];

                    $citeData['authors'] = array();
                    for($i=0;$i< count($data['result']['annotationCorpusdata']['corpus_editor_forename']);$i++) {
                        array_push($citeData['authors'],$data['result']['annotationCorpusdata']['corpus_editor_forename'][$i]." ".$data['result']['annotationCorpusdata']['corpus_editor_surname'][$i]);
                    }

                    $corpusName = $data['result']['annotationCorpusdata']['corpus_title'][0];
                    $corpusVersion =  $data['result']['annotationCorpusdata']['publication_version'][0];
                    $workFlowStatus =  $data['result']['annotationCorpusdata']['publication_status'];
                    $corpusPublicationLicense = $data['result']['annotationCorpusdata']['corpus_publication_license'][0];
                    $data['result']['workflow_status'] = $workFlowStatus;
                    $data['result']['corpus_version'] = $corpusVersion;

                    $citeData['title'] = $data['result']['annotationCorpusdata']['corpus_title'][0];
                    $citeData['version'] = $data['result']['annotationCorpusdata']['corpus_version'][count($data['result']['annotationCorpusdata']['corpus_version']) -1];
                    $citeData['publishing_year'] = date('Y',strtotime($data['result']['annotationCorpusdata']['corpus_publication_publication_date'][0]));//Carbon::createFromFormat ('Y-m-d' , $data['result']['annotationCorpusdata']['corpus_publication_publication_date'][0])->format ('Y');
                    $citeData['publishing_institution'] = $data['result']['annotationCorpusdata']['corpus_publication_publisher'][0];
                    $citeData['published_handle'] = "";



                    $guidelines = $this->ElasticService->getGuidelinesByCorpusAndAnnotationId($corpusId,$data['result']['preparation_annotation_id'][0],$current_guideline_index);
                    $formats = array();
                    $formatSearchResult = $this->ElasticService->getFormatsByCorpus($corpusId,$current_guideline_index);

                    $guidelineArray = array();
                    if(isset($formatSearchResult['aggregations'])){
                        foreach ($formatSearchResult['aggregations']['formats']['buckets'] as $formatSearchResult) {

                            if(!array_key_exists($formatSearchResult['key'],$guidelineArray)){
                                $guidelineArray[$formatSearchResult['key']] = array('annotations' => array());
                            }

                            foreach ($guidelines['result']['hits']['hits'] as $guideline){
                                foreach ($guideline['_source']['in_annotations'] as $annotationkey) {
                                    if($data['result']['preparation_annotation_id'][0] == $annotationkey &&
                                        in_array($formatSearchResult['key'],$guideline['_source']['formats'])){
                                        if(!array_key_exists($annotationkey, $guidelineArray[$formatSearchResult['key']]['annotations'])){
                                            $guidelineArray[$formatSearchResult['key']]['annotations'][$annotationkey] = array();
                                        }

                                        if(!array_key_exists($guideline['_source']['id'], $guidelineArray[$formatSearchResult['key']]['annotations'][$annotationkey])){
                                            $guidelineArray[$formatSearchResult['key']]['annotations'][$annotationkey][$guideline['_source']['id']] = $guideline['_source']['desc'];
                                        }
                                    }

                                }

                            }

                            array_push($formats,$formatSearchResult['key']);

                        }
                    }


                    if(count($data['result']['in_documents']) > 0){
                        $documentsByAnnotation = $this->ElasticService->getDocumentsByAnnotationAndCorpusId($data['result']['in_documents'],$corpusId,$current_document_index);
                        //dd($documentsByAnnotation);
                        $data['result']['documents'] = $documentsByAnnotation['results'];
                        $data['result']['annotationdocumentcount'] = count($documentsByAnnotation['results']);
                    }


                    $data['result']['allformats'] = $formats;
                    $data['result']['guidelines'] = $guidelineArray;
                    $data['result']['ccBaseUri'] = $this->ccBaseUri;
                    //dd($data);
                    //Log::info("GUIDELINES: ".print_r( $data['result']['guidelines'],1 ));
                }
                break;
        }
       //dd($data);
        JavaScript::put([
            "header" => $header,
            "header_id" => $id,
            "corpus_elasticsearch_id" => $this->LaudatioUtilService->getElasticSearchIdByCorpusId($corpusId,$current_corpus_index),
            "corpus_id" => $this->LaudatioUtilService->getDatabaseIdByCorpusId($corpusId),
            "corpus_name" => $corpusName,
            "corpus_path" => $this->LaudatioUtilService->getCorpusPathByCorpusId($corpusId,$current_corpus_index),
            "workflow_status" => $workFlowStatus,
            "corpus_version" => $corpusVersion,
            "corpusPublicationLicense" => $corpusPublicationLicense,
            "header_data" => $data,
            "citedata" => $citeData,
            "user" => $user,
            "isLoggedIn" => $isLoggedIn,
            "ccBaseUri" => $this->ccBaseUri
        ]);
        return view('browse.showHeaders')
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }

}

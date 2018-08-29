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


        $corpusdata = array();
        $documentcount = 0;
        $annotationcount = 0;

        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        //dd($corpusresponses);
        if(count($corpusresponses['result']) > 0){
            $document_range = "";
            foreach($corpusresponses['result'][0] as $corpusresponse){
                //dd($corpusresponses);
                $documentResult = $this->ElasticService->getDocumentByCorpus(
                    array(array("in_corpora" => $corpusresponse['_source']['corpus_id'][0])),
                    array($corpusresponse['_source']['corpus_id'][0])
                );

                if(isset($documentResult[$corpusresponse['_source']['corpus_id'][0]])) {
                    $documentcount = count($documentResult[$corpusresponse['_source']['corpus_id'][0]]);
                }

                $document_dates = array();

                if (count($documentResult) > 0 && isset($documentResult[$corpusresponse['_source']['corpus_id'][0]])){
                    for($d = 0; $d < count($documentResult[$corpusresponse['_source']['corpus_id'][0]]); $d++) {
                        $doc = $documentResult[$corpusresponse['_source']['corpus_id'][0]][$d];
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




                $annotationResult = $this->ElasticService->getAnnotationByCorpus(
                    array(array("in_corpora" => $corpusresponse['_source']['corpus_id'][0])),
                    array($corpusresponse['_source']['corpus_id'][0]),
                    array("preparation_title", "in_corpora", "in_documents")
                );
                //dd($annotationResult);
                if(isset($annotationResult[$corpusresponse['_source']['corpus_id'][0]])){
                    $annotationcount = count($annotationResult[$corpusresponse['_source']['corpus_id'][0]]);
                }

               // dd($annotationResult);
                if(!array_key_exists($corpusresponse['_source']['corpus_id'][0],$corpusdata)){

                    $authors = "";
                    for($i = 0; $i < count($corpusresponse['_source']['corpus_editor_forename']); $i++){
                        $authors .= $corpusresponse['_source']['corpus_editor_surname'][$i].", ".$corpusresponse['_source']['corpus_editor_forename'][$i].";";
                    }


                    $corpus_publication_date = "01.01.1900";
                    for($j = 0; $j < count($corpusresponse['_source']['corpus_publication_publication_date']); $j++) {
                        $date =   $corpusresponse['_source']['corpus_publication_publication_date'][$j];
                        if($date > $corpus_publication_date) {
                            $corpus_publication_date = $date;
                        }
                    }

                    $corpusdata[$corpusresponse['_source']['corpus_id'][0]] = array(
                        'corpus_title' => $corpusresponse['_source']['corpus_title'][0],
                        'corpus_version' => $corpusresponse['_source']['publication_version'][0],
                        'authors' => $authors,
                        'corpus_languages_language' => $corpusresponse['_source']['corpus_languages_language'][0],
                        'corpus_size_value' => str_replace(array(',','.'),'',$corpusresponse['_source']['corpus_size_value'][0]),
                        'corpus_publication_date' => $corpus_publication_date,
                        'corpus_publication_license' => $corpusresponse['_source']['corpus_publication_license'][0],
                        'corpus_encoding_project_description' => $corpusresponse['_source']['corpus_encoding_project_description'][0],
                        'document_genre' => $this->LaudatioUtilService->getDocumentGenreByCorpusId($corpusresponse['_source']['corpus_id'][0]),
                        'document_publication_range' => $document_range,
                        'download_path' => $this->LaudatioUtilService->getCorpusPathByCorpusId($corpusresponse['_source']['corpus_id'][0]),
                        'documentcount' => $documentcount,
                        'annotationcount' => $annotationcount,
                        'elasticid' => $corpusresponse['_id']
                    );
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
       // dd($sortedCollection);

        //$sortedCollection->all();
        //dd($sortedCollection);
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
//dd($entries);
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

        switch ($header){
            case "corpus":
                $apiData = $this->ElasticService->getCorpus($id);
                $data = json_decode($apiData->getContent(), true);

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

                $corpusVersion =  $data['result']['publication_version'][0];
                $workFlowStatus = $data['result']['publication_status'];
                $corpusPublicationLicense = $data['result']['corpus_publication_license'][0];

                $formatSearchResult = $this->ElasticService->getFormatsByCorpus($corpusId);
                $formats = array();
                if(isset($formatSearchResult['aggregations'])){
                    foreach ($formatSearchResult['aggregations']['formats']['buckets'] as $formatSearchResult) {
                        array_push($formats,$formatSearchResult['key']);
                    }
                }

                $data['result']['formats'] = $formats;

                $documentResult = $this->ElasticService->getDocumentByCorpus(
                    array(array("in_corpora" => $corpusId)),
                    array($corpusId)
                );

                $document_dates = array();
                $document_range = "";
                //dd($documentResult);
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


                $allDocumentsResult = $this->ElasticService->getDocumentsByDocumentId($data['result']['corpus_documents']);
               //dd($data['result']['corpus_documents']);
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



                $annotationMapping = array();
                $annotationcount = 0;
                $totalannotationcount = count($data['result']['annotation_id']);
                $foundAnnotationCorpus = array();

                foreach($data['result']['annotation_id'] as $annotationId){
                    //$annotationData = $this->ElasticService->getAnnotationByName($annotationId, array(
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
                    ));

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
                    )
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
                $data['result']['document_genre'] = $this->LaudatioUtilService->getDocumentGenreByCorpusId($corpusId);
                $data['result']['document_range'] = $document_range;


                break;
            case "document":
                $apiData = $this->ElasticService->getDocument($id);
                $data = json_decode($apiData->getContent(), true);

                $corpusId = is_array($data['result']['in_corpora']) ? $data['result']['in_corpora'][0]: $data['result']['in_corpora'];
                //$workFlowStatus = $this->LaudatioUtilService->getWorkFlowStatus($corpusId);
                //$corpusVersion = $this->LaudatioUtilService->getCorpusVersion($corpusId);


                if($corpusId){
                    $documentCorpusdata = $this->ElasticService->getCorpusByDocument(array(array('corpus_id' => $corpusId)),array($id));

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
                        ));

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
                        )
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
                $apiData = $this->ElasticService->getAnnotation($id);
                $data = json_decode($apiData->getContent(), true);
                $corpusId = is_array($data['result']['in_corpora']) ? $data['result']['in_corpora'][0]: $data['result']['in_corpora'];
                //$workFlowStatus = $this->LaudatioUtilService->getWorkFlowStatus($corpusId);
                //$corpusVersion = $this->LaudatioUtilService->getCorpusVersion($corpusId);

                if($corpusId){

                    $annotationCorpusdata = $this->ElasticService->getCorporaByAnnotation(array(array('corpus_id' => $corpusId)),array($id));
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



                    $guidelines = $this->ElasticService->getGuidelinesByCorpusAndAnnotationId($corpusId,$data['result']['preparation_annotation_id'][0]);
                    $formats = array();
                    $formatSearchResult = $this->ElasticService->getFormatsByCorpus($corpusId);

                    $guidelineArray = array();
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

                    if(count($data['result']['in_documents']) > 0){
                        $documentsByAnnotation = $this->ElasticService->getDocumentsByAnnotationAndCorpusId($data['result']['in_documents'],$corpusId);
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
            "corpus_elasticsearch_id" => $this->LaudatioUtilService->getElasticSearchIdByCorpusId($corpusId),
            "corpus_id" => $this->LaudatioUtilService->getDatabaseIdByCorpusId($corpusId),
            "corpus_name" => $corpusName,
            "corpus_path" => $this->LaudatioUtilService->getCorpusPathByCorpusId($corpusId),
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

<?php

namespace App\Http\Controllers;

use App\Laudatio\Elasticsearch\ElasticService;
use Illuminate\Http\Request;
use Elasticsearch;
use App\Laudatio\Elasticsearch\QueryBuilder;
use App\Custom\ElasticsearchInterface;
use App\Custom\LaudatioUtilsInterface;
use Cache;
use Log;

class ElasticController extends Controller
{

    protected $ElasticService;
    protected $LaudatioUtils;

    public function __construct(ElasticsearchInterface $Elasticservice,LaudatioUtilsInterface $laudatioUtils)
    {
        $this->ElasticService = $Elasticservice;
        $this->LaudatioUtils = $laudatioUtils;
    }

    /** GET search endpoint
     * @param $index
     * @param $field
     * @param $term
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function search($index,$field,$term)
    {
        $params = [
            'index' => $index,
            'type' => '',
            'body' => [
                'query' => [
                    'match' => [
                        ''.$field.'' => $term
                    ]
                ]
            ],
            '_source_exclude' => ['message']
        ];

        $results = Elasticsearch::search($params);
        $milliseconds = $results['took'];
        $maxScore     = $results['hits']['max_score'];

        return response(
            array(
                'error' => false,
                'milliseconds' => $milliseconds,
                'maxscore' => $maxScore,
                'results' => $results['hits']['hits']
            ),
            200
        );

        //return view("search.searchresult",["took" => $milliseconds, "maxScore" => $maxScore, "results" => $results['hits']['hits']]);
    }

    public function getPublishedIndexes() {
        $publishedCorpora = $this->ElasticService->getPublishedCorpora();
        $publishedIndexes = array(
            "allCorpusIndices" => array(),
            "allDocumentIndices" => array(),
            "allAnnotationIndices" => array()
        );

        if(count($publishedCorpora['result']) > 0) {
            $document_range = "";
            foreach ($publishedCorpora['result'][0] as $publicationresponse) {
                //dd($publicationresponse);

                if (isset($publicationresponse['_source']['corpus_index'])) {

                    $current_corpus_index = $publicationresponse['_source']['corpus_index'];
                    array_push($publishedIndexes['allCorpusIndices'],$current_corpus_index);

                    if(!array_key_exists($current_corpus_index,$publishedIndexes)) {
                        $publishedIndexes[$current_corpus_index] = array(
                            "document_index" => "",
                            "annotation_index" => ""
                        );
                    }

                    if (isset($publicationresponse['_source']['document_index'])) {
                        $current_document_index = $publicationresponse['_source']['document_index'];
                        array_push($publishedIndexes['allDocumentIndices'],$current_document_index);
                        $publishedIndexes[$current_corpus_index]['document_index'] = $current_document_index;
                    }

                    if (isset($publicationresponse['_source']['annotation_index'])) {
                        $current_annotation_index = $publicationresponse['_source']['annotation_index'];
                        array_push($publishedIndexes['allAnnotationIndices'],$current_annotation_index);
                        $publishedIndexes[$current_corpus_index]['annotation_index'] = $current_annotation_index;
                    }
                }//end if isset corpusIndex
            }
        }
        return response(
            $publishedIndexes,
            200
        );
    }

    /** POST search endpoint for general searches
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function searchGeneral(Request $request)
    {
        $result = $this->ElasticService->searchGeneral($request->searchData);


        for ($i = 0; $i < count($result['hits']['hits']); $i++) {
            $index = $result['hits']['hits'][$i]['_index'];
            if(strpos($index,"corpus") !== false) {
                $projectPath = $this->LaudatioUtils->getCorpusProjectPathByCorpusId($result['hits']['hits'][$i]['_id'],$index);
                $corpusPath = $this->LaudatioUtils->getCorpusPathByCorpusId($index,$index);
                $corpusLogo = $this->LaudatioUtils->getCorpusLogoByCorpusId($index,$index);
                $result['hits']['hits'][$i]['_source']['projectpath'] = $projectPath;
                $result['hits']['hits'][$i]['_source']['corpuspath'] = $corpusPath;
                $result['hits']['hits'][$i]['_source']['corpuslogo'] = $corpusLogo;
                $documentgenre = $this->LaudatioUtils->getDocumentGenreByCorpusId($index,$index);
                $result['hits']['hits'][$i]['_source']['documentgenre'] = $documentgenre;

                $current_document_index = str_replace("corpus","document",$index);

                $documentResult = $this->ElasticService->getDocumentByCorpus(
                    array(array("in_corpora" => $index)),
                    array($index),
                    array("document_publication_publishing_date"),
                    $current_document_index
                );

                $data = array("result" => $result['hits']['hits'][$i]['_source']);
                $document_range = $this->LaudatioUtils->getDocumentRange($data,$documentResult);
                $result['hits']['hits'][$i]['_source']['documentrange'] = $document_range;
            }
            else if(strpos($index,"document") !== false) {
                $corpusName = $this->LaudatioUtils->getCorpusNameByObjectElasticsearchId('document',$result['hits']['hits'][$i]['_id']);
                $result['hits']['hits'][$i]['_source']['corpus_name'] = $corpusName;
            }
            else if(strpos($index,"annotation") !== false) {
                $corpusName = $this->LaudatioUtils->getCorpusNameByObjectElasticsearchId('annotation',$result['hits']['hits'][$i]['_id']);
                $result['hits']['hits'][$i]['_source']['corpus_name'] = $corpusName;
            }

            $result['hits']['hits'][$i]['_source']['visibility'] = 1;

        }

        $resultData = array(
            'error' => false,
            'milliseconds' => $result['took'],
            'maxscore' => $result['hits']['max_score'],
            'results' => $result['hits']['hits'],
            'total' => $result['hits']['total']
        );

        return response(
            $resultData,
            200
        );
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function listAllPublished(Request $request)
    {
        $result = $this->ElasticService->listAllPublished($request->searchData);

        for ($i = 0; $i < count($result['hits']['hits']); $i++) {
            $index = $result['hits']['hits'][$i]['_index'];
            if(strpos($index,"corpus") !== false) {
                $projectPath = $this->LaudatioUtils->getCorpusProjectPathByCorpusId($result['hits']['hits'][$i]['_id'],$index);
                $corpusPath = $this->LaudatioUtils->getCorpusPathByCorpusId($index,$index);
                $corpusLogo = $this->LaudatioUtils->getCorpusLogoByCorpusId($index,$index);
                $result['hits']['hits'][$i]['_source']['projectpath'] = $projectPath;
                $result['hits']['hits'][$i]['_source']['corpuspath'] = $corpusPath;
                $result['hits']['hits'][$i]['_source']['corpuslogo'] = $corpusLogo;
                $documentgenre = $this->LaudatioUtils->getDocumentGenreByCorpusId($index,$index);
                $result['hits']['hits'][$i]['_source']['documentgenre'] = $documentgenre;

                $current_document_index = str_replace("corpus","document",$index);

                $documentResult = $this->ElasticService->getDocumentByCorpus(
                    array(array("in_corpora" => $index)),
                    array($index),
                    array("document_publication_publishing_date"),
                    $current_document_index
                );

                $data = array("result" => $result['hits']['hits'][$i]['_source']);
                $document_range = $this->LaudatioUtils->getDocumentRange($data,$documentResult);
                $result['hits']['hits'][$i]['_source']['documentrange'] = $document_range;
            }
            else if(strpos($index,"document") !== false) {
                $corpusName = $this->LaudatioUtils->getCorpusNameByObjectElasticsearchId('document',$result['hits']['hits'][$i]['_id']);
                $result['hits']['hits'][$i]['_source']['corpus_name'] = $corpusName;
            }
            else if(strpos($index,"annotation") !== false) {
                $corpusName = $this->LaudatioUtils->getCorpusNameByObjectElasticsearchId('annotation',$result['hits']['hits'][$i]['_id']);
                $result['hits']['hits'][$i]['_source']['corpus_name'] = $corpusName;
            }

            $result['hits']['hits'][$i]['_source']['visibility'] = 1;

        }

        $resultData = array(
            'error' => false,
            'milliseconds' => $result['took'],
            'maxscore' => $result['hits']['max_score'],
            'results' => $result['hits']['hits'],
            'total' => $result['hits']['total']
        );

        return response(
            $resultData,
            200
        );
    }


    public function searchCorpusIndex(Request $request)
    {

        $resultData = null;
        $cacheString = $request->cacheString;

        if (Cache::has($cacheString.'|searchCorpusIndex')) {
            $resultData = Cache::get($cacheString.'|searchCorpusIndex');
            Log::info("GOT: ".$cacheString.'|searchCorpusIndex');
        }
        else{
            $dateSearchKey = $this->ElasticService->checkForKey($request->searchData,'corpusyeartype');
            $sizeSearchKey = $this->ElasticService->checkForKey($request->searchData,'corpussizetype');
            $mixedSearch = $this->ElasticService->checkForKey($request->searchData,'mixedSearch');

            $corpus_publication_publication_date = $this->ElasticService->checkForKey($request->searchData, 'corpus_publication_publication_date');
            $corpusYearTo = $this->ElasticService->checkForKey($request->searchData,'corpusYearTo');
            $corpus_size_value = $this->ElasticService->checkForKey($request->searchData,'corpus_size_value');
            $corpusSizeTo = $this->ElasticService->checkForKey($request->searchData,'corpusSizeTo');

            $result = null;

            if($mixedSearch == "false"){
                if(isset($dateSearchKey) && $dateSearchKey != "" || isset($sizeSearchKey) && $sizeSearchKey != "") {
                    if($dateSearchKey == "range" && $sizeSearchKey == "range"){
                        if(isset($corpus_publication_publication_date) && isset($corpusYearTo) && isset($corpus_size_value) && isset($corpusSizeTo)){
                            $obj = app()->make('stdClass');
                            $obj->corpus_size_value = $corpus_size_value;
                            $obj->corpusSizeTo = $corpusSizeTo;
                            $obj->sizeSearchKey = $sizeSearchKey;
                            $obj->corpus_publication_publication_date = $corpus_publication_publication_date;
                            $obj->corpusYearTo = $corpusYearTo;
                            $obj->dateSearchKey = $dateSearchKey;
                            $result = $this->ElasticService->rangeSearch($obj);
                        }
                    }
                    else if($sizeSearchKey == "range"){
                        if(isset($corpus_size_value) && isset($corpusSizeTo)){
                            $obj = app()->make('stdClass');
                            $obj->corpus_size_value = $corpus_size_value;
                            $obj->corpusSizeTo = $corpusSizeTo;
                            $obj->sizeSearchKey = $sizeSearchKey;
                            $result = $this->ElasticService->rangeSearch($obj);
                        }
                    }
                    else if($dateSearchKey == "range"){
                        if(isset($corpus_publication_publication_date) && isset($corpusYearTo)){
                            $obj = app()->make('stdClass');
                            $obj->corpus_publication_publication_date = $corpus_publication_publication_date;
                            $obj->corpusYearTo = $corpusYearTo;
                            $obj->dateSearchKey = $dateSearchKey;
                            $result = $this->ElasticService->rangeSearch($obj);
                        }
                    }
                    else{
                        $request->searchData = $this->ElasticService->removeKey($request->searchData,'corpusyeartype');
                        $request->searchData = $this->ElasticService->removeKey($request->searchData,'corpussizetype');
                        $request->searchData = $this->ElasticService->removeKey($request->searchData,'mixedSearch');
                        $result = $this->ElasticService->searchCorpusIndex($request->searchData);
                    }
                }
                else{
                    $request->searchData = $this->ElasticService->removeKey($request->searchData,'corpusyeartype');
                    $request->searchData = $this->ElasticService->removeKey($request->searchData,'corpussizetype');
                    $request->searchData = $this->ElasticService->removeKey($request->searchData,'mixedSearch');
                    $result = $this->ElasticService->searchCorpusIndex($request->searchData);
                }
            }
            else{
                $obj = app()->make('stdClass');
                $obj->range = app()->make('stdClass');
                $obj->fields = array();

                if(isset($dateSearchKey) && $dateSearchKey != "" || isset($sizeSearchKey) && $sizeSearchKey != "") {
                    if(isset($corpus_publication_publication_date) && isset($corpusYearTo) && isset($corpus_size_value) && isset($corpusSizeTo)){
                        $obj->range->corpus_size_value = $corpus_size_value;
                        $obj->range->corpusSizeTo = $corpusSizeTo;
                        $obj->range->corpus_publication_publication_date = $corpus_publication_publication_date;
                        $obj->range->corpusYearTo = $corpusYearTo;
                    }
                }//end dateSearch
                $request->searchData = $this->ElasticService->removeKey($request->searchData,'corpusyeartype');
                $request->searchData = $this->ElasticService->removeKey($request->searchData,'corpus_publication_publication_date');
                $request->searchData = $this->ElasticService->removeKey($request->searchData,'corpusYearTo');
                $request->searchData = $this->ElasticService->removeKey($request->searchData,'corpussizetype');
                $request->searchData = $this->ElasticService->removeKey($request->searchData,'corpus_size_value');
                $request->searchData = $this->ElasticService->removeKey($request->searchData,'corpusSizeTo');
                $request->searchData = $this->ElasticService->removeKey($request->searchData,'mixedSearch');

                foreach ($request->searchData as $item) {
                    if(count($item) > 0){
                        foreach ($item as $key => $value){
                            array_push($obj->fields,array($key => $value));
                        }
                    }
                }


                $result = $this->ElasticService->searchCorpusIndex($obj);

            }



            $resultData = array(
                'error' => false,
                'milliseconds' => $result['took'],
                'maxscore' => $result['hits']['max_score'],
                'results' => $result['hits']['hits'],
                'total' => $result['hits']['total']
            );
            Cache::forever($cacheString.'|searchCorpusIndex', $resultData);
            Log::info("SET: ".$cacheString.'|searchCorpusIndex');
        }



        return response(
            $resultData,
            200
        );
    }

    public function searchDocumentIndex(Request $request)
    {

        $resultData = null;
        $cacheString = $request->cacheString;
        if (Cache::has($cacheString.'|searchDocumentIndex')) {
            $resultData = Cache::get($cacheString.'|searchDocumentIndex');
            Log::info("GOT: ".$cacheString.'|searchDocumentIndex');
        }
        else{

            $dateSearchKey = $this->ElasticService->checkForKey($request->searchData,'documentyeartype');
            $sizeSearchKey = $this->ElasticService->checkForKey($request->searchData,'documentsizetype');
            $mixedSearch = $this->ElasticService->checkForKey($request->searchData,'mixedSearch');

            $document_publication_publishing_date = $this->ElasticService->checkForKey($request->searchData,'document_publication_publishing_date');
            $document_publication_publishing_date_to  = $this->ElasticService->checkForKey($request->searchData,'document_publication_publishing_date_to');
            $document_size_extent = $this->ElasticService->checkForKey($request->searchData,'document_size_extent');
            $document_size_extent_to = $this->ElasticService->checkForKey($request->searchData,'document_size_extent_to');
            $result = null;

            if($mixedSearch == "false"){
                if(isset($dateSearchKey) && $dateSearchKey != "" || isset($sizeSearchKey) && $sizeSearchKey != "") {
                    if($dateSearchKey == "range" && $sizeSearchKey == "range") {
                        if(isset($document_publication_publishing_date) && isset($document_publication_publishing_date_to) && isset($document_size_extent) && isset($document_size_extent_to)){
                            $obj = app()->make('stdClass');
                            $obj->document_publication_publishing_date = $document_publication_publishing_date;
                            $obj->document_publication_publishing_date_to = $document_publication_publishing_date_to;
                            $obj->document_size_extent = $document_size_extent;
                            $obj->document_size_extent_to = $document_size_extent_to;
                            $obj->sizeSearchKey = $sizeSearchKey;
                            $obj->dateSearchKey = $dateSearchKey;
                            $result = $this->ElasticService->rangeSearch($obj);
                        }
                    }
                    else if($dateSearchKey == "range"){
                        if(isset($document_publication_publishing_date) && isset($document_publication_publishing_date_to)){
                            $obj = app()->make('stdClass');
                            $obj->document_publication_publishing_date = $document_publication_publishing_date;
                            $obj->document_publication_publishing_date_to = $document_publication_publishing_date_to;
                            $obj->dateSearchKey = $dateSearchKey;
                            $result = $this->ElasticService->rangeSearch($obj);
                        }

                    }
                    else if($sizeSearchKey == "range"){
                        if(isset($document_size_extent) && isset($document_size_extent_to)){
                            $obj = app()->make('stdClass');
                            $obj->document_size_extent = $document_size_extent;
                            $obj->document_size_extent_to = $document_size_extent_to;
                            $obj->sizeSearchKey = $sizeSearchKey;
                            $result = $this->ElasticService->rangeSearch($obj);
                        }
                    }
                    else {
                        $request->searchData = $this->ElasticService->removeKey($request->searchData,'documentyeartype');
                        $request->searchData = $this->ElasticService->removeKey($request->searchData,'documentsizetype');
                        $request->searchData = $this->ElasticService->removeKey($request->searchData,'mixedSearch');
                        $result = $this->ElasticService->searchDocumentIndex($request->searchData);
                    }
                }
                else {
                    $request->searchData = $this->ElasticService->removeKey($request->searchData,'documentyeartype');
                    $request->searchData = $this->ElasticService->removeKey($request->searchData,'documentsizetype');
                    $request->searchData = $this->ElasticService->removeKey($request->searchData,'mixedSearch');
                    $result = $this->ElasticService->searchDocumentIndex($request->searchData);
                }

            }
            else {

                $obj = app()->make('stdClass');
                $obj->range = app()->make('stdClass');
                $obj->fields = array();

                if(isset($dateSearchKey) && $dateSearchKey != "" || isset($sizeSearchKey) && $sizeSearchKey != "") {
                    //Log::info("DOCUMENTSEARCH: ".print_r($request->searchData,1));


                    if(isset($document_publication_publishing_date) || isset($document_publication_publishing_date_to) || isset($document_size_extent) || isset($document_size_extent_to)){
                        $obj->range->document_size_extent = $document_size_extent;
                        $obj->range->document_size_extent_to = $document_size_extent_to;
                        $obj->range->document_publication_publishing_date = $document_publication_publishing_date;
                        $obj->range->document_publication_publishing_date_to = $document_publication_publishing_date_to;
                    }
                }//end dateSearch
                $request->searchData = $this->ElasticService->removeKey($request->searchData,'documentyeartype');
                $request->searchData = $this->ElasticService->removeKey($request->searchData,'document_publication_publishing_date');
                $request->searchData = $this->ElasticService->removeKey($request->searchData,'document_publication_publishing_date_to');
                $request->searchData = $this->ElasticService->removeKey($request->searchData,'documentsizetype');
                $request->searchData = $this->ElasticService->removeKey($request->searchData,'document_size_extent');
                $request->searchData = $this->ElasticService->removeKey($request->searchData,'document_size_extent_to');
                $request->searchData = $this->ElasticService->removeKey($request->searchData,'mixedSearch');

                foreach ($request->searchData as $item) {
                    if(count($item) > 0){
                        foreach ($item as $key => $value){
                            array_push($obj->fields,array($key => $value));
                        }
                    }
                }
                $result = $this->ElasticService->searchDocumentIndex($obj);
            }



            $resultData = array(
                'error' => false,
                'milliseconds' => $result['took'],
                'maxscore' => $result['hits']['max_score'],
                'results' => $result['hits']['hits'],
                'total' => $result['hits']['total']
            );
            Cache::forever($cacheString.'|searchDocumentIndex', $resultData);
            Log::info("SET: ".$cacheString.'|searchDocumentIndex');
        }


        return response(
            $resultData,
            200
        );
    }

    public function searchDocumentIndexWithParam(Request $request)
    {

        $results = $this->ElasticService->searchDocumentIndexWithParam($request);

        $resultData = array(
            'error' => false,
            'milliseconds' => $result['took'],
            'maxscore' => $result['hits']['max_score'],
            'results' => $result['hits']['hits'],
            'total' => $result['hits']['total']
        );
        return response(
            $resultData,
            200
        );
    }


    public function getSearchTotal(Request $request)
    {
        $result = $this->ElasticService->getSearchTotal($request->searchData,$request->index);

        $resultData =  array(
            'error' => false,
            'results' => $result
        );
        return response(
            $resultData,
            200
        );
    }

    public function getCorpusTitlesByDocument(Request $request){
        $result = $this->ElasticService->getCorpusTitlesByDocument($request->corpusRefs, $request->documentRefs);
        $resultdata =  array(
            'error' => false,
            'results' => $result
        );
        return response(
            $resultdata,
            200
        );
    }

    public function getCorpusByDocument(Request $request) {
        $resultData = null;
        $cacheString = $request->cacheString;

        if (Cache::has($cacheString.'|getCorpusByDocument')) {
            $resultData = Cache::get($cacheString.'|getCorpusByDocument');
            Log::info("GOT: ".$cacheString.'|getCorpusByDocument');
        }
        else{
            $result = $this->ElasticService->getCorpusByDocument($request->corpusRefs, $request->documentRefs);
            $resultData =  array(
                'error' => false,
                'results' => $result
            );
            Cache::forever($cacheString.'|getCorpusByDocument', $resultData);
            Log::info("SET: ".$cacheString.'|getCorpusByDocument');
        }


        return response(
            $resultData,
            200
        );
    }

    public function getAnnotationsByDocument(Request $request){
        $resultData = null;
        $cacheString = $request->cacheString;
        Log::info("TIME TO GET ANNOS: ".$cacheString.'|getAnnotationsByDocument');
        //Cache::flush();

        if (Cache::has($cacheString.'|getAnnotationsByDocument')) {
            Log::info("GOT: ".$cacheString.'|getAnnotationsByDocument');
            $resultData = Cache::get($cacheString.'|getAnnotationsByDocument');

        }
        else{
            $result = $this->ElasticService->getAnnotationByDocument($request->document_ids,$request->documentRefs);
            $resultData =  array(
                'error' => false,
                'results' => $result
            );
            Cache::forever($cacheString.'|getAnnotationsByDocument', $resultData);
            Log::info("SET: ".$cacheString.'|getAnnotationsByDocument');
        }

        return response(
            $resultData,
            200
        );
    }


    public function getDocumentsByCorpus(Request $request){

        $resultData = null;
        $cacheString = $request->cacheString;
        $index = $request->index;

        $result = $this->ElasticService->getDocumentByCorpus($request->corpus_ids,$request->corpusRefs, $request->fields,$index);
        $corpusName = $this->LaudatioUtils->getCorpusNameByCorpusId($cacheString,$cacheString);

        for($i = 0; $i < count($result[$cacheString]); $i++) {
            $result[$cacheString][$i]['_source']['corpus_name'] = $corpusName;
        }

        $resultData =  array(
            'error' => false,
            'results' => $result
        );

        return response(
            $resultData,
            200
        );
    }

    public function getAnnotationByCorpus(Request $request){

        $resultData = null;
        $cacheString = $request->cacheString;
        $index = $request->index;

        //Log::info("getAnnotationByCorpus:FIELDS: ".print_r($request->fields,1));

        $corpusName = $this->LaudatioUtils->getCorpusNameByCorpusId($cacheString,$cacheString);


        $result = $this->ElasticService->getAnnotationByCorpus($request->corpus_ids,$request->corpusRefs, $request->fields, $index);
        for($i = 0; $i < count($result[$cacheString]); $i++) {
            $result[$cacheString][$i]['_source']['corpus_name'] = $corpusName;
        }

        $resultData =  array(
            'error' => false,
            'results' => $result
        );

        return response(
            $resultData,
            200
        );
    }

    public function getDocumentsByAnnotation(Request $request){

        $resultData = null;
        $cacheString = $request->cacheString;

       //Cache::flush();
        //Log::info("SEARCHING getDocumentsByAnnotation : ".$cacheString.'|getDocumentsByAnnotation');
        if (Cache::has($cacheString.'|getDocumentsByAnnotation')) {
            $resultData = Cache::get($cacheString.'|getDocumentsByAnnotation');
        }
        else{
            //Log::info("SEARCHING documentRefs : ".print_r($request->documentRefs,1  ));
            $result = $this->ElasticService->getDocumentsByAnnotation($request->documentRefs,$request->annotationRefs);
            $resultData =  array(
                'error' => false,
                'results' => $result
            );
            Cache::forever($cacheString.'|getDocumentsByAnnotation', $resultData);
        }

        return response(
            $resultData,
            200
        );
    }

    public function getCorporaByAnnotation(Request $request){
        $resultData = null;
        $cacheString = $request->cacheString;
       // Cache::flush();
        Log::info("SEARCHING getCorporaByAnnotation : ".$cacheString.'|getCorporaByAnnotation');
        if (Cache::has($cacheString.'|getCorporaByAnnotation')) {
            $resultData = Cache::get($cacheString.'|getCorporaByAnnotation');
        }
        else{
            $result = $this->ElasticService->getCorporaByAnnotation($request->corpusRefs,$request->annotationRefs);
            $resultData =  array(
                'error' => false,
                'results' => $result
            );
            Cache::forever($cacheString.'|getCorporaByAnnotation', $resultData);
        }

        return response(
            $resultData,
            200
        );
    }

/*
    public function getDocumentsByAnnotation(Request $request){
        $corpusResult = array();
        $documentResult = array();
        $documentRefs = array();
        $corpusRefs = array();

        for($i = 0; $i < count($request->annotationRefs); $i++){
            $annotationRef = $request->annotationRefs[$i];

            if(!empty($request->corpusRefs[$i])){
                $corpusRefs = $request->corpusRefs[$i];
            }
            else{
                $corpusRefs = array();
            }

            $corpusResult[$annotationRef] = array();
            if(!empty($request->documentRefs[$i])) {
                if(is_array($request->documentRefs[$i])){
                    $documentRefs = $request->documentRefs[$i];
                }
                else{
                    array_push($documentRefs,$request->documentRefs[$i]);
                }

            }
            else{
                $documentRefs = array();
            }
            $documentResult[$annotationRef] = array();

            $documentRefs = array_unique($documentRefs);

            if(count($corpusRefs) > 0) {
                foreach ($corpusRefs as $corpusRef){
                    array_push($corpusResult[$annotationRef],$this->ElasticService->getCorpusByAnnotation(array(array(
                        '_id' => $corpusRef
                    ))));
                }
            }


            if (count($documentRefs) > 0) {
                foreach ($documentRefs as $documentRef){
                    array_push($documentResult[$annotationRef],$this->ElasticService->getDocumentsByAnnotation(array(array(
                        '_id' => $documentRef
                    ))));
                }
            }

        }//end for annotations

        $resultData = array(
            "corpusResult" => $corpusResult,
            "documentResult" => $documentResult
        );

        Log::info("GOT: ".print_r($resultData,1));
        return response(
            $resultData,
            200
        );
    }
*/

    public function searchAnnotationIndex(Request $request)
    {

        $resultData = null;
        $cacheString = $request->cacheString;
        //Cache::flush();
        Log::info("SEARCHING ANNOTATONINDEX : ".$cacheString.'|searchAnnotationIndex');
        if (Cache::has($cacheString.'|searchAnnotationIndex')) {
            $resultData = Cache::get($cacheString.'|searchAnnotationIndex');
            Log::info("GOT : ".$cacheString.'|searchAnnotationIndex');
        }
        else{
            $result = $this->ElasticService->searchAnnotationIndex($request->searchData);
            Log::info("SEARCHING ANNOTATONINDEX MIILISEXZ: : ".$result['took']);
            $resultData = array(
                'error' => false,
                'milliseconds' => $result['took'],
                'maxscore' => $result['hits']['max_score'],
                'results' => $result['hits']['hits'],
                'total' => $result['hits']['total']
            );
            Cache::forever($cacheString.'|searchAnnotationIndex', $resultData);
            Log::info("SET : ".$cacheString.'|searchAnnotationIndex');
        }


        return response(
            $resultData,
            200
        );
    }

    public function createKeyFromQuery($data) {
        $createdKey = "";
        if($data){
            foreach ($data as $item){
                foreach ($item as $key => $value){
                    $createdKey .= "|".$key."|".$value;
                }
            }
        }

        return $createdKey;
    }

    public function truncateIndex(Request $request)
    {
        $result = $this->ElasticService->truncateIndex($request->index);
        $resultData = array();
        if(count($result['failures']) == 0){
            $resultData = array(
                'error' => false,
                'milliseconds' => $result['took'],
                'deleted' => $result['deleted'],
                'version_conflicts' => $result['version_conflicts'],
                'failures' => $result['failures']
            );
        }
        else{
            $resultData = array(
                'error' => true,
                'failures' => $result['failures']
            );
        }

        return response(
            $resultData,
            200
        );
    }


    /**
     * API METHODS
     */

    /**
     * @param Request $request
     * @return mixed
     */
    public function getCorpus(Request $request) {
        $id = $request->input('id');
        $apiData = $this->ElasticService->getCorpus($id);
        $data = json_decode($apiData->getContent(), true);
        return $data;
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function getDocument(Request $request) {
        $id = $request->input('id');
        $apiData = $this->ElasticService->getDocument($id);
        $data = json_decode($apiData->getContent(), true);
        return $data;
    }

    public function getAnnotation(Request $request) {
        $id = $request->input('id');
        $apiData = $this->ElasticService->getAnnotation($id);
        $data = json_decode($apiData->getContent(), true);
        return $data;
    }


}

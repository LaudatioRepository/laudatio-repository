<?php

namespace App\Http\Controllers;

use App\Laudatio\Elasticsearch\ElasticService;
use Illuminate\Http\Request;
use Cviebrock\LaravelElasticsearch\Facade;
use Elasticsearch;
use App\Laudatio\Elasticsearch\QueryBuilder;
use App\Custom\ElasticsearchInterface;

use Log;

class ElasticController extends Controller
{

    protected $ElasticService;

    public function __construct(ElasticsearchInterface $Elasticservice)
    {
        $this->ElasticService = $Elasticservice;
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

    /** POST search endpoint for general searches
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function searchGeneral(Request $request)
    {
        $result = $this->ElasticService->searchGeneral($request->searchData);
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
                Log::info("sci:request->searchData: ".print_r($request->searchData,1));
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
        return response(
            $resultData,
            200
        );
    }

    public function searchDocumentIndex(Request $request)
    {

        $dateSearchKey = $this->ElasticService->checkForKey($request->searchData,'documentyeartype');
        $sizeSearchKey = $this->ElasticService->checkForKey($request->searchData,'documentsizetype');
        $document_publication_publishing_date = $this->ElasticService->checkForKey($request->searchData,'document_publication_publishing_date');
        $document_publication_publishing_date_to  = $this->ElasticService->checkForKey($request->searchData,'document_publication_publishing_date');

        $document_size_extent = $this->ElasticService->checkForKey($request->searchData,'document_size_extent');
        $document_size_extent_to = $this->ElasticService->checkForKey($request->searchData,'document_size_extent_to');

        if($dateSearchKey == "range"){
            if(isset($document_publication_publishing_date) && isset($document_publication_publishing_date_to)){
                $obj = app()->make('stdClass');
                $obj->document_publication_publishing_date = $document_publication_publishing_date;
                $obj->document_publication_publishing_date_to = $document_publication_publishing_date_to;
                $result = $this->ElasticService->rangeSearch($obj);
            }

        }
        else if($sizeSearchKey == "range"){
            if(isset($document_size_extent) && isset($document_size_extent_to)){
                $obj = app()->make('stdClass');
                $obj->document_size_extent = $document_size_extent;
                $obj->document_size_extent_to = $document_size_extent_to;
                $result = $this->ElasticService->rangeSearch($obj);
            }
        }
        else {
            $request->searchData = $this->ElasticService->removeKey($request->searchData,'documentyeartype');
            $request->searchData = $this->ElasticService->removeKey($request->searchData,'documentsizetype');
            $result = $this->ElasticService->searchCorpusIndex($request->searchData);
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
        $result = $this->ElasticService->getCorpusByDocument($request->corpusRefs, $request->documentRefs);
        //Log::info("documentDataING: ".print_r($request->corpusRefs,1));
        $resultdata =  array(
            'error' => false,
            'results' => $result
        );
        return response(
            $resultdata,
            200
        );
    }

    public function getAnnotationsByDocument(Request $request){
        $result = $this->ElasticService->getAnnotationByDocument($request->document_ids,$request->documentRefs);
        $resultdata =  array(
            'error' => false,
            'results' => $result
        );
        return response(
            $resultdata,
            200
        );
    }


    public function getDocumentsByCorpus(Request $request){
        $result = $this->ElasticService->getDocumentByCorpus($request->corpus_ids,$request->corpusRefs);
        $resultdata =  array(
            'error' => false,
            'results' => $result
        );
        return response(
            $resultdata,
            200
        );
    }

    public function getAnnotationByCorpus(Request $request){
        $result = $this->ElasticService->getAnnotationByCorpus($request->corpus_ids,$request->corpusRefs);
        $resultdata =  array(
            'error' => false,
            'results' => $result
        );
        return response(
            $resultdata,
            200
        );
    }

    public function getDocumentsByAnnotation(Request $request){
        $result = $this->ElasticService->getDocumentsByAnnotation($request->documentRefs,$request->annotationRefs);
        $resultdata =  array(
            'error' => false,
            'results' => $result
        );
        return response(
            $resultdata,
            200
        );
    }

    public function getCorporaByAnnotation(Request $request){
        $result = $this->ElasticService->getCorporaByAnnotation($request->corpusRefs,$request->annotationRefs);
        $resultdata =  array(
            'error' => false,
            'results' => $result
        );
        return response(
            $resultdata,
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
        $result = $this->ElasticService->searchAnnotationIndex($request->searchData);

        $resultData = array(
            'error' => false,
            'milliseconds' => $result['took'],
            'maxscore' => $result['hits']['max_score'],
            'results' => $result['hits']['hits'],
            'total' => $result['hits']['total']
        );
        //Log::info("GOT: ".print_r($resultData,1));
        return response(
            $resultData,
            200
        );
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




}

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
        $result = $this->ElasticService->searchCorpusIndex($request->searchData);
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

        $result = $this->ElasticService->searchDocumentIndex($request->searchData);

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


        return response(
            $resultData,
            200
        );
    }


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

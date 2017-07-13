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

    public function getCorpusByDocument(Request $request){
        $result = $this->ElasticService->getCorpusByDocument($request->searchData);
        $resultdata =  array(
            'error' => false,
            'results' => $result
        );
        return response(
            $resultdata,
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

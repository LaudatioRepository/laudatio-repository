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

        return response(
            $result,
            200
        );
    }


    public function searchCorpusIndex(Request $request)
    {
        $result = $this->ElasticService->searchCorpusIndex($request->searchData);
        return response(
            $result,
            200
        );
    }

    public function searchDocumentIndex(Request $request)
    {

        $result = $this->ElasticService->searchDocumentIndex($request->searchData);

        return response(
            $result,
            200
        );
    }

    public function searchDocumentIndexWithParam(Request $request)
    {

        $queryBuilder = new QueryBuilder();
        $queryBody = null;
        //Log::info("SENDING: ".print_r($request->searchData,1));

        if(count($request->searchData) > 1){
            $queryBody = $queryBuilder->buildMustQuery($request->searchData);
        }
        else{
            $queryBody = $queryBuilder->buildSingleMatchQuery($request->searchData);
        }


        $filters = [];
        $params = [
            'index' => 'document',
            'type' => '',
            'body' => $queryBody,
        ];

        if(count($request->params) > 0){
            foreach ($request->params as $paramkey => $paramvalues) {
                $filtervalues = [];
                foreach ($paramvalues as $paramvalue){
                    array_push($filtervalues,$paramvalue);
                }
                $params[$paramkey] = $filtervalues;
            }
        }

        $results = Elasticsearch::search($params);

        $milliseconds = $results['took'];
        $maxScore     = $results['hits']['max_score'];
        $total = $results['hits']['total'];

        return response(
            array(
                'error' => false,
                'milliseconds' => $milliseconds,
                'maxscore' => $maxScore,
                'results' => $results['hits']['hits'],
                'total' => $total
            ),
            200
        );
    }


    public function getSearchTotal(Request $request)
    {
        $result = $this->ElasticService->getSearchTotal($request->searchData);

        return response(
            $result,
            200
        );
    }




    public function searchAnnotationIndex(Request $request)
    {
        $result = $this->ElasticService->searchAnnotationIndex($request->searchData);

        return response(
            $result,
            200
        );
    }
}

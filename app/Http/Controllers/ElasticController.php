<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cviebrock\LaravelElasticsearch\Facade;
use Elasticsearch;
use App\Laudatio\Elasticsearch\QueryBuilder;
use Log;

class ElasticController extends Controller
{


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
        $params = [
            'index' => $request->index_name,
            'type' => '',
            'body' => [
                'query' => [
                    'match' => [
                        ''.$request->field.'' => $request->queryString
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
    }


    public function searchCorpusIndex(Request $request)
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

        $params = [
            'index' => 'corpus',
            'type' => '',
            'body' => $queryBody,
            '_source_exclude' => ['message']
        ];


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

    public function searchDocumentIndex(Request $request)
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

        $params = [
            'index' => 'document',
            'type' => '',
            'body' => $queryBody,
            '_source_exclude' => ['message']
        ];


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
        $resultData = array();

        $queryBuilder = new QueryBuilder();
        $queryBody = null;

        foreach($request->searchData as $queryData){
            $queryBody = $queryBuilder->buildSingleMatchQuery(array($queryData));
            $params = [
                'index' => 'document',
                'type' => '',
                'body' => $queryBody,
                'filter_path' => ['hits.total']
            ];
            $results = Elasticsearch::search($params);

            $termData = array_values($queryData);
            $resultData[$termData[0]] = $results['hits']['total'];
        }//end foreach queries

        return response(
            array(
                'error' => false,
                'results' => $resultData
            ),
            200
        );
    }




    public function searchAnnotationIndex(Request $request)
    {
        $queryBuilder = new QueryBuilder();
        $queryBody = null;

        if(count($request->searchData) > 1){
            $queryBody = $queryBuilder->buildMustQuery($request->searchData);
        }
        else{
            $queryBody = $queryBuilder->buildSingleMatchQuery($request->searchData);
        }


        $params = [
            'index' => 'annotation',
            'type' => '',
            'body' => $queryBody,
            '_source_exclude' => ['message']
        ];

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
}

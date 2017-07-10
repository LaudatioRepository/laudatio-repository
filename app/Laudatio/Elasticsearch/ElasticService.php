<?php
/**
 * Created by PhpStorm.
 * User: rolfguescini
 * Date: 06.07.17
 * Time: 16:44
 */

namespace App\Laudatio\Elasticsearch;

use App\Custom\ElasticsearchInterface;
use Elasticsearch;
use Log;
use Illuminate\Http\Request;

class ElasticService implements ElasticsearchInterface
{

    public function __construct()
    {

    }

    public function getDocument($index,$type,$id){
        $params = [
            'index' => $index,
            'type' => $type,
            'id' => $id,
            '_source_exclude' => ['message']
        ];

        $response = Elasticsearch::get($params);
        return array(
            'error' => false,
            'found' => $response['found'],
            'result' => $response['_source']
        );
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
    public function searchGeneral($searchData)
    {
        $params = [
            'index' => $searchData->index_name,
            'type' => '',
            'body' => [
                'query' => [
                    'match' => [
                        ''.$searchData->field.'' => $searchData->queryString
                    ]
                ]
            ],
            '_source_exclude' => ['message']
        ];


        $results = Elasticsearch::search($params);
        $milliseconds = $results['took'];
        $maxScore     = $results['hits']['max_score'];

        return array(
            'error' => false,
            'milliseconds' => $milliseconds,
            'maxscore' => $maxScore,
            'results' => $results['hits']['hits']
        );
    }


    /**
     * @param $searchData
     * @return array
     */
    public function searchCorpusIndex($searchData)
    {
        $queryBuilder = new QueryBuilder();
        $queryBody = null;
        //Log::info("SENDING: ".print_r($request->searchData,1));

        if(count($searchData) > 1){
            $queryBody = $queryBuilder->buildMustQuery($searchData);
        }
        else{
            $queryBody = $queryBuilder->buildSingleMatchQuery($searchData);
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

        return array(
            'error' => false,
            'milliseconds' => $milliseconds,
            'maxscore' => $maxScore,
            'results' => $results['hits']['hits'],
            'total' => $total
        );
    }

    /**
     * @param $searchData
     * @return array
     */
    public function searchDocumentIndex($searchData)
    {

        $queryBuilder = new QueryBuilder();
        $queryBody = null;
        //Log::info("SENDING: ".print_r($request->searchData,1));
        if(count($searchData) > 1){
            $queryBody = $queryBuilder->buildMustQuery($searchData);
        }
        else{
            $queryBody = $queryBuilder->buildSingleMatchQuery($searchData);
        }
        //Log::info("QUERY: ".print_r($queryBody,1));
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

        return array(
            'error' => false,
            'milliseconds' => $milliseconds,
            'maxscore' => $maxScore,
            'results' => $results['hits']['hits'],
            'total' => $total
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
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


    /**
     * @param $searchData
     * @return array
     */
    public function getSearchTotal($searchData,$index)
    {
        $resultData = array();

        $queryBuilder = new QueryBuilder();
        $queryBody = null;

        foreach($searchData as $queryData){
            $queryBody = $queryBuilder->buildSingleMatchQuery(array($queryData));
            //Log::info("queryBody: ".print_r($queryBody,1));
            $params = [
                'index' => $index,
                'type' => '',
                'body' => $queryBody,
                'filter_path' => ['hits.total']
            ];
            $results = Elasticsearch::search($params);

            $termData = array_values($queryData);
            $resultData[$termData[0]] = $results['hits']['total'];
        }//end foreach queries

        return array(
            'error' => false,
            'results' => $resultData
        );
    }


    public function getCorpusByDocument($searchData) {
        $resultData = array();

        $queryBuilder = new QueryBuilder();
        $queryBody = null;
        foreach($searchData as $queryData){
            $queryBody = $queryBuilder->buildSingleMatchQuery(array($queryData));
            $params = [
                'index' => 'corpus',
                'type' => 'corpus',
                'body' => $queryBody,
                '_source' => ["corpus_title"],
                'filter_path' => ['hits.hits']
            ];
            $results = Elasticsearch::search($params);

            $termData = array_values($queryData);
            if(count($results['hits']['hits']) > 0){
                $resultData[$termData[0]] = $results['hits']['hits'][0]['_source'];
            }
            else{
                $resultData[$termData[0]] = array();
            }

        }//end foreach queries
        return array(
            'error' => false,
            'results' => $resultData
        );
    }

    /**
     * @param $searchData
     * @return array
     */
    public function searchAnnotationIndex($searchData)
    {
        $queryBuilder = new QueryBuilder();
        $queryBody = null;

        if(count($searchData) > 1){
            $queryBody = $queryBuilder->buildMustQuery($searchData);
        }
        else{
            $queryBody = $queryBuilder->buildSingleMatchQuery($searchData);
        }


        $params = [
            'index' => 'annotation',
            'type' => '',
            'body' => $queryBody,
            '_source_exclude' => ['message'],
            'size'=> 100
        ];

        $results = Elasticsearch::search($params);
        $milliseconds = $results['took'];
        $maxScore     = $results['hits']['max_score'];
        $total = $results['hits']['total'];

        return array(
            'error' => false,
            'milliseconds' => $milliseconds,
            'maxscore' => $maxScore,
            'results' => $results['hits']['hits'],
            'total' => $total
        );
    }
}
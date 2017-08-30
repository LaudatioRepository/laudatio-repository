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
use Elasticsearch\Endpoints\DeleteByQuery;
use Log;
use Illuminate\Http\Request;

class ElasticService implements ElasticsearchInterface
{

    public function __construct()
    {

    }

    public function createIndex($name){
        $params = [
            'index' => $name
        ];
        $response = Elasticsearch::indices()->create($params);
        return array(
            'error' => false,
            'result' => $response
        );
    }

    public function deleteIndex($indexId){

    }

    /**
     * @param $index
     * @param $type
     * @param $id
     * @return array
     */
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


    public function getDocumentByCorpus($searchData,$corpusData){
        $resultData = array();

        $queryBuilder = new QueryBuilder();
        $queryBody = null;
        $counter = 0;
        foreach($searchData as $queryData){
            $queryBody = $queryBuilder->buildSingleMatchQuery(array($queryData));
            $params = [
                'size' => 1000,
                'index' => 'document',
                'type' => 'document',
                'body' => $queryBody,
                '_source_exclude' => ['message'],
                'filter_path' => ['hits.hits']
            ];

            $results = Elasticsearch::search($params);
            $termData = array_values($corpusData);

            if(count($results['hits']['hits']) > 0){
                $resultData[$termData[$counter++]] = $results['hits']['hits'];
            }
            else{
                $resultData[$counter++] = array();
            }
        }//end foreach queries
        return $resultData;
    }

    public function getAnnotationByCorpus($searchData,$corpusData){
        $resultData = array();

        $queryBuilder = new QueryBuilder();
        $queryBody = null;
        $counter = 0;
        foreach($searchData as $queryData){
            $queryBody = $queryBuilder->buildSingleMatchQuery(array($queryData));
            $params = [
                'size' => 1000,
                'index' => 'annotation',
                'type' => 'annotation',
                'body' => $queryBody,
                '_source_exclude' => ['message']
            ];

            $results = Elasticsearch::search($params);
            $termData = array_values($corpusData);

            if(count($results['hits']['hits']) > 0){
                $resultData[$termData[$counter++]] = $results['hits']['hits'];
            }
            else{
                $resultData[$counter++] = array();
            }
        }//end foreach queries
        return $resultData;
    }


    public function getCorpusByDocument($searchData,$documentData){
        $resultData = array();

        $queryBuilder = new QueryBuilder();
        $queryBody = null;
        $counter = 0;
        foreach($searchData as $queryData){
            $queryBody = $queryBuilder->buildSingleMatchQuery(array($queryData));

            //Log::info("SENDING: ".print_r($queryBody,1));

            $params = [
                'size' => 1000,
                'index' => 'corpus',
                'type' => 'corpus',
                'body' => $queryBody,
                '_source_exclude' => ['message'],
                'filter_path' => ['hits.hits']
            ];
            $results = Elasticsearch::search($params);
            $termData = array_values($documentData);

            if(count($results['hits']['hits']) > 0){
                $resultData[$termData[$counter++]] = $results['hits']['hits'];
            }
            else{
                $resultData[$counter++] = array();
            }

        }//end foreach queries
        return $resultData;
    }


    public function getAnnotationByDocument($searchData,$documentData){
        $resultData = array();

        $queryBuilder = new QueryBuilder();
        $queryBody = null;
        $counter = 0;
        foreach($searchData as $queryData){
            $queryBody = $queryBuilder->buildSingleMatchQuery(array($queryData));
            $params = [
                'size' => 1000,
                'index' => 'annotation',
                'type' => 'annotation',
                'body' => $queryBody,
                '_source_exclude' => ['message'],
                'filter_path' => ['hits.hits']
            ];

            $results = Elasticsearch::search($params);
            $termData = array_values($documentData);

            if(count($results['hits']['hits']) > 0){
                $resultData[$termData[$counter++]]['results'] = $results['hits']['hits'];
            }
            else{
                $resultData[$counter++]['results'] = array();
            }
        }//end foreach queries
        return $resultData;
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
            'size' => 1000,
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
        $queryBuilder = new QueryBuilder();
        $queryBody = null;
        $queryBody = $queryBuilder->buildMultiMatchQuery($searchData);

        $params = [
            'size' => 1000,
            'index' => '_all',
            'type' => '',
            'body' => $queryBody,
            '_source_exclude' => ['message']
        ];


        $results = Elasticsearch::search($params);
        return $results;
    }


    /**
     * @param $searchData
     * @return array
     */
    public function searchCorpusIndex($searchData)
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
            'size' => 1000,
            'index' => 'corpus',
            'type' => '',
            'body' => $queryBody,
            '_source_exclude' => ['message']
        ];


        $results = Elasticsearch::search($params);
        return $results;
    }

    /**
     * @param $searchData
     * @return array
     */
    public function searchDocumentIndex($searchData)
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
            'size' => 1000,
            'index' => 'document',
            'type' => '',
            'body' => $queryBody,
            '_source_exclude' => ['message']
        ];


        $results = Elasticsearch::search($params);
        return $results;
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
            'size' => 1000,
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

        return $results;
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
            $params = [
                'size' => 1000,
                'index' => $index,
                'type' => '',
                'body' => $queryBody,
                'filter_path' => ['hits.total']
            ];
            $results = Elasticsearch::search($params);

            $termData = array_values($queryData);
            $resultData[$termData[0]] = $results['hits']['total'];
        }//end foreach queries

        return $resultData;
    }


    public function getCorpusTitlesByDocument($searchData,$documentData) {
        $resultData = array();

        $queryBuilder = new QueryBuilder();
        $queryBody = null;
        $counter = 0;
        foreach($searchData as $queryData){
            $queryBody = $queryBuilder->buildSingleMatchQuery(array($queryData));
            $params = [
                'size' => 1000,
                'index' => 'corpus',
                'type' => 'corpus',
                'body' => $queryBody,
                '_source' => ["corpus_title"],
                'filter_path' => ['hits.hits']
            ];
            $results = Elasticsearch::search($params);
            $termData = array_values($documentData);

            if(count($results['hits']['hits']) > 0){
                $resultData[$termData[$counter++]] = $results['hits']['hits'][0]['_source'];
            }
            else{
                $resultData[$counter++] = array();
            }

        }//end foreach queries
        return $resultData;
    }



    public function getCorpusByAnnotation($searchData) {
        $queryBuilder = new QueryBuilder();
        $queryBody = null;

        foreach($searchData as $queryData){
            $queryBody = $queryBuilder->buildSingleMatchQuery(array($queryData));
            $params = [
                'size' => 1000,
                'index' => 'corpus',
                'type' => 'corpus',
                'body' => $queryBody,
                '_source' => ["corpus_title","_id"],
                'filter_path' => ['hits.hits']
            ];

            $results = Elasticsearch::search($params);
        }//end foreach queries
        return $results['hits']['hits'][0];
    }

    public function getDocumentsByAnnotation($searchData){
        $queryBuilder = new QueryBuilder();
        $queryBody = null;
        foreach($searchData as $queryData){
            $queryBody = $queryBuilder->buildSingleMatchQuery(array($queryData));
            $params = [
                'size' => 1000,
                'index' => 'document',
                'type' => 'document',
                'body' => $queryBody,
                '_source' => ["document_title","_id"],
                'filter_path' => ['hits.hits']
            ];

            $results = Elasticsearch::search($params);

        }//end foreach queries
        return $results['hits']['hits'][0];
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
        return $results;
    }

    /**
     * @param $index
     * @return mixed json
     */
    public function truncateIndex($index){
        $queryBuilder = new QueryBuilder();
        $queryBody = null;
        $searchData = array();
        $queryBody = $queryBuilder->buildMatchAllQuery($searchData);

        $params = [
            'index' => $index,
            'type' => $index,
            'body' => $queryBody,
        ];

        $results = Elasticsearch::deleteByQuery($params);
        return $results;
    }
}
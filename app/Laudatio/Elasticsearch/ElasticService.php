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
use Cache;
use Illuminate\Http\Request;

class ElasticService implements ElasticsearchInterface
{
    private $ELASTICSEARCH_HOST;
    private $ELASTICSEARCH_PORT;
    private $ELASTICSEARCH_SCHEME;
    private $ELASTICSEARCH_USER;
    private $ELASTICSEARCH_PASS;

    public function __construct()
    {
        $this->ELASTICSEARCH_HOST = env('ELASTICSEARCH_HOST', 'localhost');
        $this->ELASTICSEARCH_PORT = env('ELASTICSEARCH_PORT', 9200);
        $this->ELASTICSEARCH_SCHEME = env('ELASTICSEARCH_SCHEME', null);
        $this->ELASTICSEARCH_USER = env('ELASTICSEARCH_USER', null);
        $this->ELASTICSEARCH_PASS = env('ELASTICSEARCH_PASS', null);
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
     * @param $id
     * @param bool $full
     * @return array
     */
    public function getCorpus($id,$full = true){
        if(!$full){
            $params = [
                'index' => 'corpus',
                'type' => 'corpus',
                'id' => $id,
                '_source' => ["document_title","document_publication_publishing_date","document_list_of_annotations_name","in_corpora"]
            ];
        }
        else{
            $params = [
                'index' => 'corpus',
                'type' => 'corpus',
                'id' => $id,
                '_source_exclude' => ['message']
            ];
        }


        $response = Elasticsearch::get($params);
        if(!$full){
            return array(
                'error' => false,
                'result' => $response['_source']
            );
        }
        else{
            return array(
                'error' => false,
                'found' => $response['found'],
                'result' => $response['_source']
            );
        }

    }

    public function deleteCorpus($id){
        $result = array();
        $queryBuilder = new QueryBuilder();
        $queryBody = $queryBuilder->buildSingleMatchQuery(array(array('_id' => $id)));
        $params = [
            'size' => 1,
            'index' => 'corpus',
            'type' => 'corpus',
            'body' => $queryBody,
        ];

        $response = Elasticsearch::deletebyquery($params);
        if($response['deleted'] > 0){
            array_push($result,$response);
        }
        return array(
            'error' => false,
            'result' => $result
        );
    }

    /**
     * @param $id
     * @param bool $full
     * @return array
     */
    public function getDocument($id,$full = true){
        if(!$full){
            $params = [
                'index' => 'document',
                'type' => 'document',
                'id' => $id,
                '_source' => ["document_title","document_publication_publishing_date","document_list_of_annotations_name","in_corpora"]
            ];
        }
        else{
            $params = [
                'index' => 'document',
                'type' => 'document',
                'id' => $id,
                '_source_exclude' => ['message']
            ];
        }


        $response = Elasticsearch::get($params);
        if(!$full){
            return array(
                'error' => false,
                'result' => $response['_source']
            );
        }
        else{
            return array(
                'error' => false,
                'found' => $response['found'],
                'result' => $response['_source']
            );
        }

    }


    public function deleteDocument($id,$corpusId){
        $result = array();
        $queryBuilder = new QueryBuilder();

        $searchData = array();
        array_push($searchData,array(
            "document_id" => $id
        ));

        array_push($searchData,array(
            "in_corpora" => $corpusId
        ));
        $queryBody = $queryBuilder->buildMustQuery($searchData);
        $params = [
            'size' => 1,
            'index' => 'document',
            'type' => 'document',
            'body' => $queryBody,
        ];

        $response = Elasticsearch::deletebyquery($params);
        if($response['deleted'] > 0){
            array_push($result,$response);
        }
        return array(
            'error' => false,
            'result' => $result
        );
    }

    /**
     * @param $id
     * @param bool $full
     * @return array
     */
    public function getAnnotation($id,$full = true){
        if(!$full){
            $params = [
                'index' => 'annotation',
                'type' => 'annotation',
                'id' => $id,
                //'_source' => ["document_title","document_publication_publishing_date","document_list_of_annotations_name","in_corpora"]
            ];
        }
        else{
            $params = [
                'index' => 'annotation',
                'type' => 'annotation',
                'id' => $id,
                '_source_exclude' => ['message']
            ];
        }


        $response = Elasticsearch::get($params);
        if(!$full){
            return array(
                'error' => false,
                'result' => $response['_source']
            );
        }
        else{
            return array(
                'error' => false,
                'found' => $response['found'],
                'result' => $response['_source']
            );
        }

    }

    public function deleteAnnotation($id,$corpusId){
        $result = array();
        $queryBuilder = new QueryBuilder();
        array_push($searchData,array(
            "preparation_annotation_id" => $id
        ));

        array_push($searchData,array(
            "in_corpora" => $corpusId
        ));
        $queryBody = $queryBuilder->buildMustQuery($searchData);

        $params = [
            'size' => 1,
            'index' => 'annotation',
            'type' => 'annotation',
            'body' => $queryBody,
        ];

        $response = Elasticsearch::deletebyquery($params);
        if($response['deleted'] > 0){
            array_push($result,$response);
        }
        return array(
            'error' => false,
            'result' => $result
        );
    }


    public function deleteIndexedObject($index,$params){
        Cache::flush();
        $result = array();
        $queryBody = null;
        $queryBuilder = new QueryBuilder();
        if(count($params) == 1){
            $queryBody = $queryBuilder->buildSingleMatchQuery($params);

        }
        else if(count($params) >  1){
            $queryBody = $queryBuilder->buildMustQuery($params);
        }


        $params = [
            'size' => 1,
            'index' => $index,
            'type' => $index,
            'body' => $queryBody,
            //'conflicts' => 'proceed'
        ];

        $response = Elasticsearch::deletebyquery($params);
        if($response['deleted'] > 0){
            array_push($result,$response);
        }
        Cache::flush();
        return array(
            'error' => false,
            'result' => $result
        );
    }

    public function getElasticIdByObjectId($index,$objectparams){
        //empty querycache
        Cache::flush();
        $elasticIds = array();
        $queryBuilder = new QueryBuilder();
        foreach ($objectparams as $objectId => $objectparam){
            if(count($objectparam) == 1){
                $queryBody = $queryBuilder->buildSingleMatchQuery($objectparam);

            }
            else if(count($objectparam) >  1){
                $queryBody = $queryBuilder->buildMustQuery($objectparam);
            }


            $params = [
                'size' => 10,
                'index' => $index,
                'type' => $index,
                'body' => $queryBody,
                '_source' => ["_id"]
            ];
            $response = Elasticsearch::search($params);

            $hits = isset($response['hits']['hits'][0]) ? $response['hits']['hits'][0] : false;
            if($hits){
                $elasticIds[$objectId] = $response['hits']['hits'][0]['_id'];
            }

        }

        return $elasticIds;
    }

    /**
     * @param $name
     * @return array
     */
    public function getAnnotationByName($name,$fields){
        $result = array();
        $queryBuilder = new QueryBuilder();
        $queryBody = $queryBuilder->buildSingleMatchQuery(array(array('preparation_title' => $name)));
        $params = [
            'size' => 1,
            'index' => 'annotation',
            'type' => 'annotation',
            'body' => $queryBody,
            '_source' => $fields,
            'filter_path' => ['hits.hits']
        ];

        $response = Elasticsearch::search($params);
        if(count($response['hits']['hits']) > 0){
            array_push($result,$response['hits']['hits'][0]['_source']);
        }
        return array(
            'error' => false,
            'result' => $result
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
                //'_source_exclude' => ['message'],
                '_source' => ["document_title","document_publication_publishing_date","document_publication_place","document_list_of_annotations_name","in_corpora","document_size_extent"],
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
                '_source' => ["preparation_title", "in_corpora", "in_documents"],
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

            $params = [
                'size' => 1000,
                'index' => 'corpus',
                'type' => 'corpus',
                'body' => $queryBody,
                //'_source_exclude' => ['message'],
                '_source' => ["corpus_title","corpus_publication_publication_date","corpus_documents","annotation_name","corpus_publication_license_description","corpus_publication_publisher","corpus_encoding_project_homepage","corpus_editor_forename","corpus_editor_surname"],
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
                //'_source_exclude' => ['message'],
                '_source' => ["preparation_title", "in_corpora", "in_documents"],
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

    }


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
        if(is_array($searchData)){
            if(count($searchData) > 1){
                $queryBody = $queryBuilder->buildMustQuery($searchData);
            }
            else{
                $queryBody = $queryBuilder->buildSingleMatchQuery($searchData);
            }
        }
        else{
            $queryBody = $queryBuilder->buildMustFilterRangeQuery($searchData->fields,$searchData->range);
        }
        $params = [
            'size' => 1000,
            'index' => 'corpus',
            'type' => '',
            'body' => $queryBody,
            '_source' => ["corpus_title","corpus_publication_publication_date","corpus_documents","annotation_name","corpus_publication_license_description","corpus_id"],
            //'_source_exclude' => ['message']
        ];


        $results = Elasticsearch::search($params);
        return $results;
    }

    public function rangeSearch($searchData,$returnQueryBody = false)
    {
        $queryBuilder = new QueryBuilder();
        $queryBody = null;
        $index = "";

        if(isset($searchData->dateSearchKey) && !isset($searchData->sizeSearchKey)){
            if(isset($searchData->corpus_publication_publication_date) && !isset($searchData->corpusYearTo)){
                $queryBody = $queryBuilder->buildRangeQuery('corpus_publication_publication_date',$searchData->corpus_publication_publication_date,null);
                $index = 'corpus';
            }
            else if(!isset($searchData->corpus_publication_publication_date) && isset($searchData->corpusYearTo)){
                $queryBody = $queryBuilder->buildRangeQuery('corpus_publication_publication_date',null,$searchData->corpusYearTo);
                $index = 'corpus';
            }
            else if(isset($searchData->corpus_publication_publication_date) && isset($searchData->corpusYearTo)){
                $queryBody = $queryBuilder->buildRangeQuery('corpus_publication_publication_date',$searchData->corpus_publication_publication_date,$searchData->corpusYearTo);
                $index = 'corpus';
            }


            if(isset($searchData->document_publication_publishing_date) && !isset($searchData->document_publication_publishing_date_to)){
                $queryBody = $queryBuilder->buildRangeQuery('corpus_publication_publication_date',$searchData->document_publication_publishing_date,null);
                $index = 'document';
            }
            else if(!isset($searchData->document_publication_publishing_date) && isset($searchData->document_publication_publishing_date_to)){
                $queryBody = $queryBuilder->buildRangeQuery('corpus_publication_publication_date',null,$searchData->document_publication_publishing_date_to);
                $index = 'document';
            }
            else if(isset($searchData->document_publication_publishing_date) && isset($searchData->document_publication_publishing_date_to)){
                $queryBody = $queryBuilder->buildRangeQuery('corpus_publication_publication_date',$searchData->document_publication_publishing_date,$searchData->document_publication_publishing_date_to);
                $index = 'document';
            }

        }
        else if(!isset($searchData->dateSearchKey) && isset($searchData->sizeSearchKey)){

            if(isset($searchData->corpus_size_value) && !isset($searchData->corpusSizeTo)){
                $queryBody = $queryBuilder->buildRangeQuery('corpus_size_value',$searchData->corpus_size_value,null);
                $index = 'corpus';
            }
            else if(!isset($searchData->corpus_size_value) && isset($searchData->corpusSizeTo)){
                $queryBody = $queryBuilder->buildRangeQuery('corpus_size_value',null,$searchData->corpusSizeTo);
                $index = 'corpus';
            }
            else if(isset($searchData->corpus_size_value) && isset($searchData->corpusSizeTo)){
                $queryBody = $queryBuilder->buildRangeQuery('corpus_size_value',$searchData->corpus_size_value,$searchData->corpusSizeTo);
                $index = 'corpus';
            }

            if(isset($searchData->document_size_extent) && !isset($searchData->document_size_extent_to)){
                $queryBody = $queryBuilder->buildRangeQuery('document_size_extent',$searchData->document_size_extent,null);
                $index = 'document';
            }
            else if(!isset($searchData->document_size_extent) && isset($searchData->document_size_extent_to)){
                $queryBody = $queryBuilder->buildRangeQuery('document_size_extent',null,$searchData->document_size_extent_to);
                $index = 'document';
            }
            else if(isset($searchData->document_size_extent) && isset($searchData->document_size_extent_to)){
                $queryBody = $queryBuilder->buildRangeQuery('document_size_extent',$searchData->document_size_extent,$searchData->document_size_extent_to);
                $index = 'document';
            }


        }
        else if((isset($searchData->dateSearchKey)) && (isset($searchData->sizeSearchKey))){
            $searchData = $this->removeKey($searchData,'sizeSearchKey');
            $searchData = $this->removeKey($searchData,'dateSearchKey');
            $data = array();

            if(isset($searchData->corpus_publication_publication_date) && $searchData->corpus_publication_publication_date != ""  && empty($searchData->corpusYearTo)){
                $obj = app()->make('stdClass');
                $obj->field = 'corpus_publication_publication_date';
                $obj->from = $searchData->corpus_publication_publication_date;
                $obj->to = "";
                array_push($data,$obj);
                $index = 'corpus';
            }
            else if(empty($searchData->corpus_publication_publication_date) && isset($searchData->corpusYearTo) && $searchData->corpusYearTo != "" ){
                $obj = app()->make('stdClass');
                $obj->field = 'corpus_publication_publication_date';
                $obj->from = "";
                $obj->to = $searchData->corpusYearTo;
                array_push($data,$obj);
                $index = 'corpus';
            }
            else if(isset($searchData->corpus_publication_publication_date) && $searchData->corpus_publication_publication_date != ""  && isset($searchData->corpusYearTo) && $searchData->corpusYearTo != "" ){
                $obj = app()->make('stdClass');
                $obj->field = 'corpus_publication_publication_date';
                $obj->from = $searchData->corpus_publication_publication_date;
                $obj->to = $searchData->corpusYearTo;
                array_push($data,$obj);
                $index = 'corpus';
            }

            if(isset($searchData->document_publication_publishing_date) && $searchData->document_publication_publishing_date != ""  && empty($searchData->document_publication_publishing_date_to)){
                $obj = app()->make('stdClass');
                $obj->field = 'document_publication_publishing_date';
                $obj->from = $searchData->document_publication_publishing_date;
                $obj->to = "";
                array_push($data,$obj);
                $index = 'document';
            }
            else if(empty($searchData->document_publication_publishing_date) && isset($searchData->document_publication_publishing_date_to) && $searchData->document_publication_publishing_date_to != "" ){
                $obj = app()->make('stdClass');
                $obj->field = 'document_publication_publishing_date';
                $obj->from = "";
                $obj->to = $searchData->document_publication_publishing_date_to;
                array_push($data,$obj);
                $index = 'document';
            }
            else if(isset($searchData->document_publication_publishing_date) && $searchData->document_publication_publishing_date != ""  && isset($searchData->document_publication_publishing_date_to) && $searchData->document_publication_publishing_date_to != "" ){
                $obj = app()->make('stdClass');
                $obj->field = 'document_publication_publishing_date';
                $obj->from = $searchData->document_publication_publishing_date;
                $obj->to = $searchData->document_publication_publishing_date_to;
                array_push($data,$obj);
                $index = 'document';
            }


            if(isset($searchData->corpus_size_value) && $searchData->corpus_size_value != ""  && empty($searchData->corpusSizeTo)){
                $obj = app()->make('stdClass');
                $obj->field = 'corpus_size_value';
                $obj->from = $searchData->corpus_size_value;
                $obj->to = "";
                array_push($data,$obj);
                $index = 'corpus';
            }
            else if(empty($searchData->corpus_size_value) && isset($searchData->corpusSizeTo) && $searchData->corpusSizeTo != "" ){
                $obj = app()->make('stdClass');
                $obj->field = 'corpus_size_value';
                $obj->from = "";
                $obj->to = $searchData->corpusSizeTo;
                array_push($data,$obj);
                $index = 'corpus';
            }
            else if(isset($searchData->corpus_size_value) && $searchData->corpus_size_value != ""  && isset($searchData->corpusSizeTo)  && $searchData->corpusSizeTo != ""  ){
                $obj = app()->make('stdClass');
                $obj->field = 'corpus_size_value';
                $obj->from = $searchData->corpus_size_value;
                $obj->to = $searchData->corpusSizeTo;
                array_push($data,$obj);
                $index = 'corpus';
            }



            if(isset($searchData->document_size_extent) && $searchData->document_size_extent != ""  && empty($searchData->document_size_extent_to)){
                $obj = app()->make('stdClass');
                $obj->field = 'document_size_extent';
                $obj->from = $searchData->document_size_extent;
                $obj->to = "";
                array_push($data,$obj);
                $index = 'document';
            }
            else if(empty($searchData->document_size_extent) && isset($searchData->document_size_extent_to) && $searchData->document_size_extent_to != "" ){
                $obj = app()->make('stdClass');
                $obj->field = 'document_size_extent';
                $obj->from = "";
                $obj->to = $searchData->document_size_extent_to;
                array_push($data,$obj);
                $index = 'document';
            }
            else if(isset($searchData->document_size_extent) && $searchData->document_size_extent != ""  && isset($searchData->document_size_extent_to) && $searchData->document_size_extent_to != "" ){
                $obj = app()->make('stdClass');
                $obj->field = 'document_size_extent';
                $obj->from = $searchData->document_size_extent;
                $obj->to = $searchData->document_size_extent_to;
                array_push($data,$obj);
                $index = 'document';
            }

            $queryBody = $queryBuilder->buildMustRangeQuery($data);
        }

        if(!$returnQueryBody){
            $params = [
                'size' => 1000,
                'index' => $index,
                'type' => '',
                'body' => $queryBody,
                '_source_exclude' => ['message']
            ];

            $results = Elasticsearch::search($params);
            return $results;
        }
        else{
            return $queryBody;
        }

    }

    /**
     * @param $searchData
     * @return array
     */
    public function searchDocumentIndex($searchData)
    {

        $queryBuilder = new QueryBuilder();
        $queryBody = null;

        if(is_array($searchData)){
            if(count($searchData) > 1){
                $queryBody = $queryBuilder->buildMustQuery($searchData);
            }
            else{
                $queryBody = $queryBuilder->buildSingleMatchQuery($searchData);
            }
        }
        else {
            $queryBody = $queryBuilder->buildMustFilterRangeQuery($searchData->fields,$searchData->range);
        }





        $params = [
            'size' => 1000,
            'index' => 'document',
            'type' => '',
            'body' => $queryBody,
            '_source' => ["document_title","document_publication_publishing_date","document_list_of_annotations_name","in_corpora"],
            //'_source_exclude' => ['message']
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
            '_source' => ["document_title","document_publication_publishing_date","document_list_of_annotations_name","in_corpora"],
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
                '_source' => ["corpus_title","corpus_publication_publication_date","corpus_documents","annotation_name","corpus_publication_license_description","corpus_publication_publisher","corpus_encoding_project_homepage","corpus_editor_forename","corpus_editor_surname"],
                'filter_path' => ['hits.hits']
            ];

            $results = Elasticsearch::search($params);
        }//end foreach queries
        return $results['hits']['hits'][0];
    }

    public function getDocumentsByAnnotationAndCorpusId($documentList,$corpusId){
        $resultData = array();

        foreach($documentList as $documentId) {
            $queryBuilder = new QueryBuilder();
            $queryBody = $queryBuilder->buildMustQuery(array(
                array(
                    "in_corpora" => $corpusId
                ),
                array(
                    "_id" => $documentId
                ),
            ));

            $params = [
                'index' => 'document',
                'type' => 'document',
                'body' => $queryBody,
                'size'=> 100,
                '_source' => ["document_title","document_size_extent","document_publication_publishing_date","document_id","document_history_original_place","document_list_of_annotations_id","_id"]
            ];
            $result = Elasticsearch::search($params);

            if(count($result['hits']['hits']) > 0){
                array_push($resultData,$result['hits']['hits'][0]['_source']);
            }
        }



        return array(
            'error' => false,
            'results' => $resultData
        );
    }

    public function getDocumentsByAnnotation($searchData,$annotationData){
        $resultData = array();
        $queryBuilder = new QueryBuilder();
        $queryBody = null;

        foreach ($searchData as $id => $annotationDatum) {
            $results = null;
            if(!isset($resultData[$id])){
                $resultData[$id] = array();
            }
            $qs = "\r";

            foreach($annotationDatum as $queryData){
                $queryBody = $queryBuilder->buildSingleMatchQuery(array($queryData));
                foreach ($queryData as $key => $value){
                    if($value != ""){
                        $qs .= '{"profile": true,"query": {"match": {"'.$key.'": "'.$value.'"}}, "size": 1000, "_source": ["document_title","document_publication_publishing_date","document_list_of_annotations_name","in_corpora"]}'."\n";

                    }
                }
            }

            $resultset = $this->curlRequest($qs,'document/_msearch');
            $results = $resultset['resultdata'];

            $results = json_decode($results,true);
            if(isset($results['responses'])){
                foreach ($results['responses'] as $result){
                    if(count($result['hits']['hits']) > 0){
                        array_push($resultData[$id],$result['hits']['hits'][0]);
                    }
                    else{
                        $resultData[$id] = array();
                    }
                }
            }
        }


        return $resultData;
    }


    public function getDocumentsByAnnotation_metrics($searchData,$annotationData){
        $resultData = array();
        $queryBuilder = new QueryBuilder();
        $queryBody = null;
        $totaltime = 0;
        $metrics = array();
        $file = fopen("/Users/rolfguescini/source/phpelasticsearchlaudatio/storage/metrics.csv","w");
        //$file = fopen("/var/www/html/laravelaudatio/shared/storage/metrics.csv","w");
        fputcsv($file,array(
            'id',
            'EStime',
            'curlinfo_url',
            'curlinfo_http_code',
            'curlinfo_size_download',
            'curlinfo_size_upload',
            'curlinfo_starttransfer_time',
            'curlinfo_namelookup_time',
            'curlinfo_connect_time',
            'curlinfo_request',
            'total_time',
            'curlinfo_speed_upload',
            'curlinfo_speed_download',
            'query'


        ));
        foreach ($searchData as $id => $annotationDatum) {
            $results = null;
            if(!isset($resultData[$id])){
                $resultData[$id] = array();
            }
            $qs = "\r";
            $queries = array();
            foreach($annotationDatum as $queryData){
                $queryBody = $queryBuilder->buildSingleMatchQuery(array($queryData));
                array_push($queries,$queryBody);
                foreach ($queryData as $key => $value){
                    if($value != ""){
                        $qs .= '{"profile": true,"query": {"match": {"'.$key.'": "'.$value.'"}}, "size": 1000, "_source": ["document_title","document_publication_publishing_date","document_list_of_annotations_name","in_corpora"]}'."\n";

                    }
                }
            }

            $resultset = $this->curlRequest($qs,'document/_msearch');
            $results = $resultset['resultdata'];



            $results = json_decode($results,true);
            if(isset($results['responses'])){
                foreach ($results['responses'] as $result){
                    if(count($result['hits']['hits']) > 0){
                        array_push($resultData[$id],$result['hits']['hits'][0]);
                    }
                    else{
                        $resultData[$id] = array();
                    }

                    if(count($result['profile']['shards']) > 0){
                        foreach($result['profile']['shards'] as $shard) {
                            foreach($shard['searches'] as $shardsearch) {
                                foreach($shardsearch['query'] as $shardquery) {
                                    if(!array_key_exists($id,$metrics)){
                                        $metrics[$id] = array();
                                    }

                                    $metrics[$id]['id'] = $id;
                                    $totaltime += $shardquery['time'];
                                    $metrics[$id]['time'] = $shardquery['time'];
                                }

                            }
                        }
                    }
                }


                $metrics[$id]['curlinfo_url'] = $resultset['curlinfo']['url'];
                $metrics[$id]['curlinfo_http_code'] = $resultset['curlinfo']['http_code'];
                $metrics[$id]['curlinfo_size_download'] = $resultset['curlinfo']['size_download'];
                $metrics[$id]['curlinfo_size_upload'] = $resultset['curlinfo']['size_upload'];
                $metrics[$id]['curlinfo_starttransfer_time'] = $resultset['curlinfo']['starttransfer_time'];
                $metrics[$id]['curlinfo_namelookup_time'] = $resultset['curlinfo']['namelookup_time'];
                $metrics[$id]['curlinfo_connect_time'] = $resultset['curlinfo']['connect_time'];
                $metrics[$id]['curlinfo_request'] = $resultset['curlinfo']['pretransfer_time'];
                $metrics[$id]['total_time'] = $resultset['curlinfo']['total_time'];
                $metrics[$id]['curlinfo_speed_upload'] = $resultset['curlinfo']['speed_upload'];
                $metrics[$id]['curlinfo_speed_download'] = $resultset['curlinfo']['speed_download'];
            }
        }

        $allhits = array();
        foreach($metrics as $id => $data){
            array_push($data,'{"profile": true,"query": {"match": {"'.$key.'": "'.$value.'"}}, "size": 1000, "_source": ["document_title","document_publication_publishing_date","document_list_of_annotations_name","in_corpora"]}');
            fputcsv($file,$data);
        }
        fclose($file);

        $resultData['metrics'] = $metrics;
        $totaltime = floor($totaltime/60000).':'.floor(($totaltime%60000)/1000).':'.str_pad(floor($totaltime%1000),3,'0', STR_PAD_LEFT);
        $resultData['totaltime'] = $totaltime;


        return $resultData;
    }

    public function getDocumentsByAnnotation_too_memory_consuming($searchData,$annotationData){
        $resultData = array();
        $queryBuilder = new QueryBuilder();
        $queryBody = null;
        $counter = 0;
        $queries = array();

        foreach ($searchData as $id => $annotationDatum) {
            $results = null;
            if(!isset($resultData[$id])){
                $resultData[$id] = array();
            }
            $qs = "";

            foreach($annotationDatum as $queryData){

                if(strlen($queryData['_id']) > 1){
                    $queryBody = $queryBuilder->buildSingleMatchQuery(array($queryData));
                    array_push($queries,$queryBody);
                }
            }

            $params = [
                //'size' => 1000,
                'index' => 'document',
                'type' => 'document',
                'body' => $queries,
                //'_source_exclude' => ['message'],
                //'_source' => ["document_title","document_publication_publishing_date","document_list_of_annotations_name","in_corpora"],
                //'filter_path' => ['hits.hits']
            ];

            $results = Elasticsearch::msearch($params);

            foreach ($results['responses'] as $result){
                if(count($result['hits']['hits']) > 0){
                    array_push($resultData[$id],$result['hits']['hits'][0]);
                }
                else{
                    $resultData[$id] = array();
                }
            }
        }


        return $resultData;
    }


    public function getCorporaByAnnotation_old($searchData,$annotationData){
        $resultData = array();

        $queryBuilder = new QueryBuilder();
        $queryBody = null;
        $counter = 0;
        foreach ($searchData as $id => $annotationDatum) {
            foreach($annotationDatum as $queryData){
                $queryBody = $queryBuilder->buildSingleMatchQuery(array($queryData));
                $params = [
                    'size' => 1000,
                    'index' => 'corpus',
                    'type' => 'corpus',
                    'body' => $queryBody,
                    '_source' => ["corpus_title","corpus_publication_publication_date","corpus_documents","annotation_name","corpus_publication_license_description","corpus_publication_publisher","corpus_encoding_project_homepage","corpus_editor_forename","corpus_editor_surname"],
                    'filter_path' => ['hits.hits']
                ];

                $results = Elasticsearch::search($params);

                if(count($results['hits']['hits']) > 0){
                    $resultData[$id] = $results['hits']['hits'];
                }
                else{
                    $resultData[$id] = array();
                }
            }//end foreach queries
        }

        return $resultData;
    }



    public function getCorporaByAnnotation($searchData,$annotationData){
        $resultData = array();
        $queryBuilder = new QueryBuilder();
        $queryBody = null;
        $counter = 0;
        $queryBody = $queryBuilder->buildSingleMatchQuery($searchData);

        $params = [
            'size' => 1000,
            'index' => 'corpus',
            'type' => 'corpus',
            'body' => $queryBody,
            //'_source_exclude' => ['message'],
            '_source' => ["corpus_title","corpus_publication_publication_date","corpus_documents","annotation_name","corpus_publication_license_description","corpus_publication_publisher","corpus_encoding_project_homepage","corpus_editor_forename","corpus_editor_surname"],
            'filter_path' => ['hits.hits']
        ];
        $results = Elasticsearch::search($params);
        $termData = array_values($annotationData);

        if(count($results['hits']['hits']) > 0){
            $resultData[$termData[$counter++]] = $results['hits']['hits'];
        }
        else{
            $resultData[$counter++] = array();
        }


        return $resultData;
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
            //'_source_exclude' => ['message'],
            //'_source' => ["preparation_title", "in_corpora", "in_documents"],
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

    public function getAnnotationGroups(){
        $queryBuilder = new QueryBuilder();

        $queryBody = $queryBuilder->buildTermsAggregationQuery(array(
            "name" => "annotations",
            "field" => "preparation_encoding_annotation_group.keyword"
        ));

        $params = [
            'index' => 'annotation',
            'type' => 'annotation',
            'body' => $queryBody,
            'size'=> 100,
            'filter_path' => ['aggregations.annotations.buckets.key']
        ];

        $results = Elasticsearch::search($params);

        return $results;
    }

    public function getGuidelinesByCorpus($corpusId){
        $queryBuilder = new QueryBuilder();
        $queryBody = $queryBuilder->buildSingleMatchQuery(array(
            array(
                "in_corpus" => $corpusId
            )
        ));

        $params = [
            'index' => 'guideline',
            'type' => 'guideline',
            'body' => $queryBody,
            'size'=> 100,
            '_source' => ["formats","in_annotations","id","desc"]
        ];

        $results = Elasticsearch::search($params);
        return array(
            'error' => false,
            'result' => $results
        );
    }

    public function getGuidelinesByCorpusAndAnnotationId($corpusId,$annotationName){
        $queryBuilder = new QueryBuilder();
        $queryBody = $queryBuilder->buildMustQuery(array(
            array(
                "in_corpus" => $corpusId
            ),
            array(
                "in_annotations" => $annotationName
            ),
        ));

        $params = [
            'index' => 'guideline',
            'type' => 'guideline',
            'body' => $queryBody,
            'size'=> 100,
            '_source' => ["formats","in_annotations","id","desc"]
        ];

        $results = Elasticsearch::search($params);
        return array(
            'error' => false,
            'result' => $results
        );
    }

    /**
     * getFormatsByCorpus
     * Fetches all format terms for a given Corpus
     * @param $corpusId
     * @return mixed
     */
    public function getFormatsByCorpus($corpusId){
        $queryBuilder = new QueryBuilder();

        $queryBody = $queryBuilder->buildTermsAggregationQueryByMatchQuery(
            array(
                "field" => "in_corpus",
                "value" => $corpusId
            ),
            array(
                "name" => "formats",
                "field" => "formats.keyword"
            )
        );

        $params = [
            'index' => 'guideline',
            'type' => 'guideline',
            'body' => $queryBody,
            'size'=> 100,
            'filter_path' => ['aggregations.formats.buckets.key']
        ];

        $results = Elasticsearch::search($params);
        return $results;
    }

    /**
     * Helpers
     */

    public function checkForKey($array, $key){
        $value = "";
        foreach($array as $item) {
            if(array_key_exists($key,$item)) {
                $value = $item[$key];
                break;
            }
        }
        return $value;
    }

    public function removeKey($array, $key){
        if(is_array($array)){
            for($i=0; $i < count($array); $i++){
                foreach($array[$i] as $itemkey => $param){
                    if($itemkey == $key){
                        unset($array[$i][$key]);
                        break;
                    }
                }
            }
        }
        else{
            foreach($array as $itemkey => $item){
                if($itemkey == $key){
                    unset($array->{$key});
                    break;
                }
            }
        }

        return $array;
    }

    public function curlRequest($queries,$path){
        $header = array(
            "content-type: application/x-ndjson; charset=UTF-8"
        );

        $url = $this->ELASTICSEARCH_SCHEME.'://'.$this->ELASTICSEARCH_HOST.':'.$this->ELASTICSEARCH_PORT.'/'.$path;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl,CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $queries);
        $results = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);
        $resultset = array(
            "curlinfo" => $info,
            "resultdata" => $results
        );
        return $resultset;
    }

}
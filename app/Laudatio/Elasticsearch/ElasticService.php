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
use Response;
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

    public function createIndex($params){
        return Elasticsearch::indices()->create($params);
    }

    public function reIndex($params) {
        return Elasticsearch::reindex($params);
    }

    public function deleteIndex($indexId){

    }


    public function createMappedIndex($indexMappingPath, $index_id) {
        $status = "";
        $result = array();

        //set mapping
        $mapping = json_decode(file_get_contents($indexMappingPath),true);

        $createIndexParams = array(
            'index' => $index_id,
            'body' => array(
                'mappings' => array(
                    'doc'=> array(
                        '_source' => array(
                            'enabled' => true
                        ),
                        'properties' => $mapping['mappings']['doc']['properties']
                    )
                )
            )
        );



        $indexResult = $this->createIndex($createIndexParams);


        /*
         * The Reindex API makes no effort to handle ID collisions. For such issues, the target index will remain valid,
         *  but it’s not easy to predict which document will survive because the iteration order isn’t well defined.
         *
         * setting new id to timestamp:now()_old_elasticsearch_id
         *
         */


        if($indexResult['acknowledged'] == 1
            && $indexResult['index'] == $index_id) {


            $status = "success";
            $result['create_mappedindex_response'] = "Success";

        }
        else{
            $status = "error";
            $result['publish_corpus_response'] = "There was a problem creating the Index. A message has been sent to the site administrator. Please try again later";
        }

        $response = array(
            'status' => $status,
            'message' => $result,
        );

        return $response;
    }

    public function createMappedIndexAndReindex($indexMappingPath, $new_index_id, $old_index_id,$matchQuery,$new_elasticsearch_id,$new_id) {
        $status = "";
        $result = array();

        //set mapping
        $mapping = json_decode(file_get_contents($indexMappingPath),true);

        $createIndexParams = array(
            'index' => $new_index_id,
            'body' => array(
                'mappings' => array(
                    'doc'=> array(
                        '_source' => array(
                            'enabled' => true
                        ),
                        'properties' => $mapping['mappings']['doc']['properties']
                    )
                )
            )
        );



        $indexResult = $this->createIndex($createIndexParams);


        /*
         * The Reindex API makes no effort to handle ID collisions. For such issues, the target index will remain valid,
         *  but it’s not easy to predict which document will survive because the iteration order isn’t well defined.
         *
         * setting new id to timestamp:now()_old_elasticsearch_id
         *
         */

        $prefixarray = explode("§",$new_id);
        $prefix = $prefixarray[0];

        if($indexResult['acknowledged'] == 1
            && $indexResult['index'] == $new_index_id) {
            if(strpos($new_index_id,"corpus") !== false){
                $indexParams = array(
                    "body" => array(
                        "source" => array(
                            "index" => $old_index_id,
                            "query" => array(
                                "match" => $matchQuery
                            )
                        ),
                        "dest" => array(
                            "index" => $new_index_id
                        ),
                        "script" => array(
                            "source" => "ctx._id = '".$prefix."' + '§' + ctx._id;ctx._source.publication_status = '0';ctx._source.corpus_id = '".$new_id."'",
                            "lang" => "painless"
                        )
                    )
                );
            }
            else{
                $indexParams = array(
                    "body" => array(
                        "source" => array(
                            "index" => $old_index_id,
                            "query" => array(
                                "match" => $matchQuery
                            )
                        ),
                        "dest" => array(
                            "index" => $new_index_id
                        ),
                        "script" => array(
                            "source" => "ctx._id = '".$prefix."' + '§' + ctx._id;ctx._source.publication_status = '0';ctx._source.in_corpora = '".$new_id."'",
                            "lang" => "painless"
                        )
                    )
                );
            }

            $reIndexResult = $this->reIndex($indexParams);


            $status = "success";
            $result['publish_corpus_response'] = "Success";

        }
        else{
            $status = "error";
            $result['publish_corpus_response'] = "There was a problem publishing the Corpus. The error was: The corpus could not be published to git due to failed creation of index. A message has been sent to the site administrator. Please try again later";
        }

        $response = array(
            'status' => $status,
            'message' => $result,
        );

        return $response;
    }


    public function updateDocumentFieldsInAnnotation($new_annotation_index,$annotation_ids){
        //update the document ids in annotation documents
        $success = true;
        foreach($annotation_ids as $annotation_id => $document_ids) {
            $annotation_update_params = array(
                'index' => $new_annotation_index,
                'type' => 'doc',
                'id' => $annotation_id,
                'body' => [
                    'doc' => [
                        'in_documents' => $document_ids
                    ]
                ]
            );
            $response = Elasticsearch::update($annotation_update_params);
            if(empty($response['_shards'])) {
                $success = false;
                break;
            }
        }
        return $success;
    }


    public function postToIndex($params) {
        $response = array();
        try {
            $response = Elasticsearch::index($params);
        }
        catch (\Exception $e) {
            $response = array($e);
        }

        return $response;
    }

    public function setMapping($params){
        $response = array();
        try {
            $response = Elasticsearch::putMapping($params);
        }
        catch (\Exception $e) {
            $response = array($e);
        }

        return $response;
    }

    public function setCorpusToPublished($params){
        $response = array();
        try {
            $response = Elasticsearch::update($params);
        }
        catch (\Exception $e) {
            $response = array($e);
        }

        return $response;
    }

    public function getPublishedCorpora(){
        $queryBuilder = new QueryBuilder();
        $queryBody = null;

        $queryBody = $queryBuilder->buildMatchAllQuery(array());
        //$queryBody = $queryBuilder->buildMatchAllQuery($searchData);


        $resultData = array();
        $params = [
            'size' => 1000,
            'index' => 'publication',
            'type' => 'doc',
            'body' => $queryBody,
        ];
        $response = Elasticsearch::search($params);

        if(count($response['hits']['hits']) > 0){
            array_push($resultData,$response['hits']['hits']);
        }

        return array(
            'error' => false,
            'result' => $resultData
        );
    }



    /**
     * @param $id
     * @param bool $full
     * @param $index
     * @return mixed
     */
    public function getCorpus($id,$full = true, $index){
        $returned_response = null;

        if (Cache::tags(['corpus_'.$id.'_'.$index])->has("getCorpus_".$id."_".$index)) {
            $returned_response = Cache::tags(['corpus_'.$id.'_'.$index])->get("getCorpus_".$id."_".$index);
        }
        else {
            if(!$full){
                $params = [
                    'index' => $index,
                    'type' => 'doc',
                    'id' => $id,
                    '_source' => ["document_title","document_publication_publishing_date","document_list_of_annotations_name","in_corpora","publication_version","publication_status"]
                ];
            }
            else{
                $params = [
                    'index' => $index,
                    'type' => 'doc',
                    'id' => $id,
                    '_source_exclude' => ['message']
                ];
            }

            $response = Elasticsearch::get($params);
            $returned_response = array();
            if(!$full){
                $returned_response = array(
                    'status' => 'success',
                    'result' => $response['_source']
                );
            }
            else{
                $returned_response = array(
                    'status' => 'success',
                    'found' => $response['found'],
                    'result' => $response['_source']
                );
            }

            Cache::tags(['corpus_'.$id.'_'.$index])->forever("getCorpus_".$id."_".$index, $returned_response);
        }//end if not in cache



        return Response::json($returned_response);
    }

    public function deleteCorpus($id){
        $result = array();
        $queryBuilder = new QueryBuilder();
        $queryBody = $queryBuilder->buildSingleMatchQuery(array(array('_id' => $id)));
        $params = [
            'size' => 1,
            'index' => 'corpus',
            'type' => 'doc',
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
     * @param $index
     * @return mixed
     */
    public function getDocument($id,$full = true,$index){
        $returned_response = array();

        if (Cache::tags(['document_'.$id.'_'.$index])->has("getDocument_".$id.'_'.$index)) {
            $returned_response = Cache::tags(['document_'.$id.'_'.$index])->get("getDocument_".$id.'_'.$index);
        }
        else {
            if(!$full){
                $params = [
                    'index' => $index,
                    'type' => 'doc',
                    'id' => $id,
                    '_source' => ["document_title","document_publication_publishing_date","document_list_of_annotations_name","in_corpora"]
                ];
            }
            else{
                $params = [
                    'index' => $index,
                    'type' => 'doc',
                    'id' => $id,
                    '_source_exclude' => ['message']
                ];
            }


            $response = Elasticsearch::get($params);



            if(!$full){
                $returned_response = array(
                    'status' => 'success',
                    'result' => $response['_source']
                );
            }
            else{
                $returned_response = array(
                    'status' => 'success',
                    'found' => $response['found'],
                    'result' => $response['_source']
                );
            }
            if(count($returned_response) > 0){
                Cache::tags(['document_'.$id.'_'.$index])->forever("getDocument_".$id.'_'.$index, $returned_response);
            }
        }//end if cache


        return Response::json($returned_response);
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
            'type' => 'doc',
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
    public function getAnnotation($id,$full = true, $index){
        $returned_response = array();
        
        if (Cache::tags(['annotation_'.$index])->has("getAnnotation_".$id."_".$index)) {
            $returned_response = Cache::tags(['annotation_'.$index])->get("getAnnotation_".$id."_".$index);
        }
        else {
            if(!$full){
                $params = [
                    'index' => $index,
                    'type' => 'doc',
                    'id' => $id,
                    //'_source' => ["document_title","document_publication_publishing_date","document_list_of_annotations_name","in_corpora"]
                ];
            }
            else{
                $params = [
                    'index' => $index,
                    'type' => 'doc',
                    'id' => $id,
                    '_source_exclude' => ['message']
                ];
            }


            $response = Elasticsearch::get($params);

            if(!$full){
                $returned_response = array(
                    'status' => 'success',
                    'result' => $response['_source']
                );
            }
            else{
                $returned_response = array(
                    'status' => 'success',
                    'found' => $response['found'],
                    'result' => $response['_source']
                );
            }

            if(count($returned_response) > 0) {
                Cache::tags(['annotation_'.$index])->forever("getAnnotation_".$id."_".$index, $returned_response);
            }

        }//end if cache


        return Response::json($returned_response);

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
            'type' => 'doc',
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
            'type' => 'doc',
            'body' => $queryBody,
            //'conflicts' => 'proceed'
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

    public function getElasticIdByObjectId($index,$objectparams){
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
                'type' => 'doc',
                'body' => $queryBody,
                '_source' => ["_id"]
            ];

            $response = Elasticsearch::search($params);

            $hits = isset($response['hits']['hits'][0]) ? $response['hits']['hits'][0] : false;
            if($hits){
                $elasticIds[$objectId] = array(
                    "elasticsearchid" => $response['hits']['hits'][0]['_id'],
                    "elasticsearchindex" => $response['hits']['hits'][0]['_index'],
                );
            }

        }

        return $elasticIds;
    }

    public function setWorkflowStatusByCorpusId($corpus_id){

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
            'type' => 'doc',
            'body' => $queryBody,
            '_source' => $fields,
            'filter_path' => ['hits.hits']
        ];

        $response = Elasticsearch::search($params);
        if(count($response['hits']['hits']) > 0){
            array_push($result,$response['hits']['hits'][0]);
        }
        return array(
            'error' => false,
            'result' => $result
        );
    }

    public function getAnnotationByNameAndCorpusId($name, $corpusId, $fields,$index){
        $result = array();

        if (Cache::tags(['annotation_'.$name.'_'.$corpusId.'_'.$index])->has("getAnnotationByNameAndCorpusId_".$name."_".$corpusId."_".$index)) {
            $result = Cache::tags(['annotation_'.$name.'_'.$corpusId.'_'.$index])->get("getAnnotationByNameAndCorpusId_".$name."_".$corpusId."_".$index);
        }
        else {
            $queryBuilder = new QueryBuilder();
            $queryBody = $queryBuilder->buildMustQuery(array(
                array(
                    'preparation_annotation_id' => $name,
                    'in_corpora' => $corpusId
                )
            ));
            $params = [
                'size' => 1,
                'index' => $index,
                'type' => 'doc',
                'body' => $queryBody,
                '_source' => $fields,
                'filter_path' => ['hits.hits']
            ];

            $response = Elasticsearch::search($params);

            if(count($response['hits']['hits']) > 0){
                array_push($result,$response['hits']['hits'][0]);
                Cache::tags(['annotation_'.$name.'_'.$corpusId.'_'.$index])->forever("getAnnotationByNameAndCorpusId_".$name."_".$corpusId."_".$index, $result);
            }

        }//end if cache


        return array(
            'error' => false,
            'result' => $result
        );
    }

    public function getAnnotationByCorpus($searchData,$corpusData,$fields,$index){
        $resultData = array();
        if (Cache::tags(['annotation_'.$corpusData[0].'_'.$index])->has("getAnnotationByCorpus".$corpusData[0]."_".$index)) {
            $resultData = Cache::tags(['annotation_'.$corpusData[0].'_'.$index])->get("getAnnotationByCorpus".$corpusData[0]."_".$index);
        }
        else {
            $queryBuilder = new QueryBuilder();
            $queryBody = null;
            $counter = 0;
            foreach($searchData as $queryData){
                $queryBody = $queryBuilder->buildSingleMatchQuery(array($queryData));
                $params = [
                    'size' => 1000,
                    'index' => $index,
                    'type' => 'doc',
                    'body' => $queryBody,
                    '_source' => $fields,
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
            Cache::tags(['annotation_'.$corpusData[0].'_'.$index])->forever("getAnnotationByCorpus".$corpusData[0]."_".$index, $resultData);
        }

        return $resultData;
    }

    public function getDocumentByCorpus($searchData,$corpusData,$index){
        $resultData = array();

        if (Cache::tags(['document_'.$corpusData[0].'_'.$index])->has("getDocumentByCorpus".$corpusData[0]."_".$index)) {
            $resultData = Cache::tags(['document_'.$corpusData[0].'_'.$index])->get("getDocumentByCorpus".$corpusData[0]."_".$index);
        }
        else {
            $queryBuilder = new QueryBuilder();
            $queryBody = null;
            $counter = 0;
            foreach($searchData as $queryData){
                $queryBody = $queryBuilder->buildSingleMatchQuery(array($queryData));
                $params = [
                    'size' => 1000,
                    'index' => $index,
                    'type' => 'doc',
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
                Cache::tags(['document_'.$corpusData[0].'_'.$index])->forever("getDocumentByCorpus".$corpusData[0]."_".$index, $resultData);
            }//end foreach queries
        }


        return $resultData;
    }




    public function getCorpusByDocument($searchData,$documentData,$index){
        $resultData = array();

        /*
        if (Cache::tags(['corpus_'.$searchData[0]['corpus_id'].'_'.$index])->has("getCorpusByDocument_".$searchData[0]['corpus_id'].'_'.$index)) {
            $resultData = Cache::tags(['corpus_'.$searchData[0]['corpus_id'].'_'.$index])->get("getCorpusByDocument_".$searchData[0]['corpus_id'].'_'.$index);
        }
        else {


        }
        */
        $queryBuilder = new QueryBuilder();
        $queryBody = null;
        $counter = 0;
        foreach($searchData as $queryData){
            $queryBody = $queryBuilder->buildSingleMatchQuery(array($queryData));

            $params = [
                'size' => 1000,
                'index' => $index,
                'type' => 'doc',
                'body' => $queryBody,
                //'_source_exclude' => ['message'],
                '_source' => ["corpus_title","corpus_publication_publication_date","corpus_documents","annotation_name","corpus_publication_license_description","corpus_publication_publisher","corpus_encoding_project_homepage","corpus_editor_forename","corpus_editor_surname","corpus_version","publication_version","publication_status","corpus_publication_license"],
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

            if(count($resultData) > 0) {
                Cache::tags(['corpus_'.$searchData[0]['corpus_id'].'_'.$index])->forever("getCorpusByDocument_".$searchData[0]['corpus_id'].'_'.$index,$resultData);
            }
        }
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
                'type' => 'doc',
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
            'type' => 'doc',
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
            'type' => 'doc',
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
            'type' => 'doc',
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
                'type' => 'doc',
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
            'type' => 'doc',
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
            'type' => 'doc',
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
                'type' => 'doc',
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
                'type' => 'doc',
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
                'type' => 'doc',
                'body' => $queryBody,
                '_source' => ["corpus_title","corpus_publication_publication_date","corpus_documents","annotation_name","corpus_publication_license_description","corpus_publication_publisher","corpus_encoding_project_homepage","corpus_editor_forename","corpus_editor_surname"],
                'filter_path' => ['hits.hits']
            ];

            $results = Elasticsearch::search($params);
        }//end foreach queries
        return $results['hits']['hits'][0];
    }

    public function getDocumentsByAnnotationAndCorpusId($documentList,$corpusId,$index){
        $resultData = array();

        if (Cache::tags(['document_'.$corpusId.'_'.$index])->has("getDocumentsByAnnotationAndCorpusId_".$corpusId."_".$index)) {
            $resultData = Cache::tags(['document_'.$corpusId.'_'.$index])->get("getDocumentsByAnnotationAndCorpusId_".$corpusId."_".$index);
        }
        else {
            $documentList = is_array($documentList)? $documentList: array($documentList);
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
                    'index' => $index,
                    'type' => 'doc',
                    'body' => $queryBody,
                    'size'=> 100,
                    '_source' => ["document_title","document_size_extent","document_publication_publishing_date","document_id","document_history_original_place","document_list_of_annotations_id","_id"]
                ];

                $result = Elasticsearch::search($params);

                if(count($result['hits']['hits']) > 0){
                    $document_indexid =  $result['hits']['hits'][0]['_id'];
                    $result['hits']['hits'][0]['_source']['document_indexid'] = $document_indexid;
                    array_push($resultData,$result['hits']['hits'][0]['_source']);
                    Cache::tags(['document_'.$corpusId.'_'.$index])->forever("getDocumentsByAnnotationAndCorpusId_".$corpusId."_".$index, $resultData);
                }
            }
        }



        return array(
            'error' => false,
            'results' => $resultData
        );
    }

    public function getDocumentsByDocumentId($documentids,$index) {
        $resultData = array();

        if (Cache::tags(['document_'.$index])->has("getDocumentsByDocumentId_".$index)) {
            $resultData = Cache::tags(['document_'.$index])->get("getDocumentsByDocumentId_".$index);
        }
        else {
            $queryBuilder = new QueryBuilder();
            $queryBody = null;
            $documentIdParameters = array();
            $qs = "\r";
            $results = null;


            foreach($documentids as $queryData){
                if($queryData != ""){
                    $qs .= '{"query": {"match": {"document_id": "'.$queryData.'"}}, "size": 1000, "_source": ["document_title","document_size_extent","document_publication_publishing_date","document_id","document_history_original_place","document_list_of_annotations_id","_id"]}'."\n";

                }

            }

            $resultset = $this->curlRequest($qs,$index.'/_msearch');
            $results = $resultset['resultdata'];
            // dd($resultset);
            $results = json_decode($results,true);
            if(isset($results['responses'])){
                foreach ($results['responses'] as $result){
                    if(count($result['hits']['hits']) > 0){
                        array_push($resultData,$result['hits']['hits'][0]);
                    }
                }
            }
            Cache::tags(['document_'.$index])->forever("getDocumentsByDocumentId_".$index, $resultData);
        }


        return $resultData;
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
                'type' => 'doc',
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
                    'type' => 'doc',
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



    public function getCorporaByAnnotation($searchData,$annotationData,$index){
        $resultData = array();

        if (Cache::tags(['corpus_'.$searchData[0]['corpus_id'].'_'.$index])->has('getCorporaByAnnotation_'.$searchData[0]['corpus_id'].'_'.$annotationData[0].'_'.$index)) {
            $resultData =  Cache::tags(['corpus_'.$searchData[0]['corpus_id'].'_'.$index])->get('getCorporaByAnnotation_'.$searchData[0]['corpus_id'].'_'.$annotationData[0].'_'.$index);
        }
        else {
            $queryBuilder = new QueryBuilder();
            $queryBody = null;
            $counter = 0;
            $queryBody = $queryBuilder->buildSingleMatchQuery($searchData);
            $params = [
                'size' => 1000,
                'index' => $index,
                'type' => 'doc',
                'body' => $queryBody,
                //'_source_exclude' => ['message'],
                '_source' => ["corpus_title","corpus_publication_publication_date","corpus_documents","annotation_name","corpus_publication_license_description","corpus_publication_publisher","corpus_encoding_project_homepage","corpus_editor_forename","corpus_editor_surname","corpus_version","publication_version","publication_status","corpus_publication_license"],
                'filter_path' => ['hits.hits']
            ];



            $results = Elasticsearch::search($params);
            $termData = array_values($annotationData);
            //dd($termData);
            if(count($results['hits']['hits']) > 0){
                $resultData[$termData[$counter++]] = $results['hits']['hits'];
            }
            else{
                $resultData[$counter++] = array();
            }

            if(count($resultData) > 0) {
                Cache::tags('corpus_'.$searchData[0]['corpus_id'].'_'.$index)->forever('getCorporaByAnnotation_'.$searchData[0]['corpus_id'].'_'.$annotationData[0].'_'.$index, $resultData);
            }
        }//end if cached


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
            'type' => 'doc',
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
            'type' => 'doc',
            'body' => $queryBody,
        ];

        $results = Elasticsearch::deleteByQuery($params);
        return $results;
    }

    /**
     * @return mixed
     * @todo: fix the function so it only aggregates within a given corpus
     */
    public function getAnnotationGroups($matchdata,$index){
        $results = null;

        if (Cache::tags(['annotationgroup_'.$matchdata['value'].'_'.$index])->has("getAnnotationGroups".$matchdata['value']."_".$index)) {
            $results = Cache::tags(['annotationgroup_'.$matchdata['value'].'_'.$index])->get("getAnnotationGroups".$matchdata['value']."_".$index);
        }
        else {
            $queryBuilder = new QueryBuilder();
            $queryBody = $queryBuilder->buildTermsAggregationQueryByMatchQuery(
                $matchdata,
                array(
                    "name" => "annotations",
                    "field" => "preparation_encoding_annotation_group.keyword"
                ));
            $params = [
                'index' => $index,
                'type' => 'doc',
                'body' => $queryBody,
                'size'=> 100,
                'filter_path' => ['aggregations.annotations.buckets.key']
            ];

            $results = Elasticsearch::search($params);
            Cache::tags(['annotationgroup_'.$matchdata['value'].'_'.$index])->forever("getAnnotationGroups".$matchdata['value']."_".$index, $results);
        }


        return $results;
    }

    public function getGuidelinesByCorpus($corpusId,$index){
        $results = array();
        if (Cache::tags(['guidelines_'.$corpusId])->has("getGuidelinesByCorpus_".$corpusId)) {
            $results = Cache::tags(['guidelines_'.$corpusId])->get("getGuidelinesByCorpus_".$corpusId);
        }
        else {
            $queryBuilder = new QueryBuilder();
            $queryBody = $queryBuilder->buildSingleMatchQuery(array(
                array(
                    "in_corpora" => $corpusId
                )
            ));

            $params = [
                'index' => $index,
                'type' => 'doc',
                'body' => $queryBody,
                'size'=> 1000,
                '_source' => ["formats","in_annotations","id","desc"]
            ];

            $results = Elasticsearch::search($params);

            if(array_key_exists('result', $results) && count($results['result']['hits']['hits']) > 0) {
                Cache::tags(['guidelines_'.$corpusId])->forever("getGuidelinesByCorpus_".$corpusId, $results);
            }
        }

        return array(
            'error' => false,
            'result' => $results
        );
    }

    public function getGuidelinesByCorpusAndAnnotationId($corpusId,$annotationName,$index){
        $results = array();
        if (Cache::tags(['guidelines_'.$corpusId.'_'.$index])->has("getGuidelinesByCorpusAndAnnotationId_".$annotationName."_".$corpusId."_".$index)) {
            $results = Cache::tags(['guidelines_'.$corpusId.'_'.$index])->get("getGuidelinesByCorpusAndAnnotationId_".$annotationName."_".$corpusId."_".$index);
        }
        else {
            $queryBuilder = new QueryBuilder();
            $queryBody = $queryBuilder->buildMustQuery(array(
                array(
                    "in_corpora" => $corpusId
                ),
                array(
                    "in_annotations" => $annotationName
                ),
            ));

            $params = [
                'index' => $index,
                'type' => 'doc',
                'body' => $queryBody,
                'size'=> 100,
                '_source' => ["formats","in_annotations","id","desc"]
            ];

            $results = Elasticsearch::search($params);

            if(array_key_exists('result', $results) && count($results['result']['hits']['hits']) > 0) {
                Cache::tags(['guidelines_'.$corpusId.'_'.$index])->forever("getGuidelinesByCorpusAndAnnotationId_".$annotationName."_".$corpusId."_".$index, $results);
            }
        }


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
    public function getFormatsByCorpus($corpusId,$index){

        $results = array();
        if (Cache::tags(['formats_'.$corpusId.'_'.$index])->has("getFormatsByCorpus_".$corpusId."_".$index)){
            $results = Cache::tags(['formats_'.$corpusId.'_'.$index])->get("getFormatsByCorpus_".$corpusId."_".$index);
        }
        else {
            $queryBuilder = new QueryBuilder();

            $queryBody = $queryBuilder->buildTermsAggregationQueryByMatchQuery(
                array(
                    "field" => "in_corpora",
                    "value" => $corpusId
                ),
                array(
                    "name" => "formats",
                    "field" => "formats.keyword"
                )
            );

            $params = [
                'index' => $index,
                'type' => 'doc',
                'body' => $queryBody,
                'size'=> 100,
                'filter_path' => ['aggregations.formats.buckets.key']
            ];

            $results = Elasticsearch::search($params);
            if(array_key_exists('result', $results) && count($results['result']['hits']['hits']) > 0) {
                Cache::tags(['formats_'.$corpusId.'_'.$index])->forever("getFormatsByCorpus_".$corpusId."_".$index, $results);
            }

        }

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
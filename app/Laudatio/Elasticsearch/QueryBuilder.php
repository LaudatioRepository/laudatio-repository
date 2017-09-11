<?php

/**
 * Created by PhpStorm.
 * User: rolfguescini
 * Date: 04.07.17
 * Time: 15:21
 */
namespace App\Laudatio\Elasticsearch;

use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\Query\FullText\MatchQuery;
use ONGR\ElasticsearchDSL\Query\MatchAllQuery;
use ONGR\ElasticsearchDSL\Query\FullText\MultiMatchQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\RangeQuery;
Use ONGR\ElasticsearchDSL\Aggregation\Bucketing\DateRangeAggregation;
Use ONGR\ElasticsearchDSL\Aggregation\Bucketing\RangeAggregation;
use ONGR\ElasticsearchDSL\Search;
use Log;

class QueryBuilder
{

    public function buildMustQuery($data){
        $bool = new BoolQuery();
        foreach($data as $param){
            foreach ($param as $key => $value){
                $bool->add(new MatchQuery($key, $value), BoolQuery::MUST);
            }
        }

        $search = new Search();
        $search->addQuery($bool);

        $queryArray = $search->toArray();

        return $queryArray;
    }

    public function buildSingleMatchQuery($data){
        $matchQuery = null;
        foreach($data as $param){
            foreach ($param as $key => $value){
                if($value != ""){
                    $matchQuery = new MatchQuery($key, $value);
                }

            }
        }

        $search = new Search();
        $search->addQuery($matchQuery);

        $queryArray = $search->toArray();

        return $queryArray;
    }

    public function buildMultiMatchQuery($data){
        $multiMatchQuery = null;
        $multiMatchQuery = new MultiMatchQuery($data['fields'],$data['query']);
        $search = new Search();
        $search->addQuery($multiMatchQuery);
        $queryArray = $search->toArray();
        return $queryArray;
    }

    public function buildMatchAllQuery($data){
        $matchAllQuery = new MatchAllQuery($data);
        $search = new Search();
        $search->addQuery($matchAllQuery);
        $queryArray = $search->toArray();

        return $queryArray;
    }

    public function buildMustRangeQuery($data) {
        $bool = new BoolQuery();
        foreach ($data as $value){
            if($value != ""){
                $rangeQuery = null;
                if($value->from && !$value->to){
                    $rangeQuery = new RangeQuery(
                        $value->field,
                        [
                            'gte' => $value->from,
                        ]
                    );
                }
                else if(!$value->from && $value->to){
                    $rangeQuery = new RangeQuery(
                        $value->field,
                        [
                            'lte' => $value->to
                        ]
                    );
                }
                else if($value->from && $value->to){
                    $rangeQuery = new RangeQuery(
                        $value->field,
                        [
                            'gte' => $value->from,
                            'lte' => $value->to
                        ]
                    );
                }

                $bool->add($rangeQuery, BoolQuery::MUST);
            }

        }
        $search = new Search();
        $search->addQuery($bool);

        $queryArray = $search->toArray();

        return $queryArray;
    }


    public function buildMustFilterRangeQuery($fielddata, $rangedata) {
        $bool = new BoolQuery();
        $fieldMap = array(
            "corpusYearTo" => "corpus_publication_publication_date",
            "corpus_publication_publication_date" => "corpus_publication_publication_date",
            "corpusSizeTo" => "corpus_size_value",
            "corpus_size_value" => "corpus_size_value",
            "document_publication_publishing_date" => "document_publication_publishing_date",
            "document_publication_publishing_date_to" => "document_publication_publishing_date",
            "document_size_extent" => "document_size_extent",
            "document_size_extent_to" => "document_size_extent"

        );


        foreach($fielddata as $param){
            foreach ($param as $key => $value){
                $bool->add(new MatchQuery($key, $value), BoolQuery::MUST);
            }
        }
        foreach ($rangedata as $rangeDataKey => $rangedatum){
            $rangeQuery =  null;
            if($rangedatum != null && $rangedatum != ""){
                if(strpos($rangeDataKey,"To") !== false || strpos($rangeDataKey,"to") !== false){
                    $rangeQuery = new RangeQuery(
                        $fieldMap[$rangeDataKey],
                        [
                            'lte' => $rangedatum
                        ]
                    );
                }
                else{
                    if($fieldMap[$rangeDataKey] == "corpus_publication_publication_date" || $fieldMap[$rangeDataKey] == "document_publication_publishing_date"){
                        $rangeQuery = new RangeQuery(
                            $fieldMap[$rangeDataKey],
                            [
                                'gt' => $rangedatum
                            ]
                        );
                    }
                    else{
                        $rangeQuery = new RangeQuery(
                            $fieldMap[$rangeDataKey],
                            [
                                'gte' => $rangedatum
                            ]
                        );
                    }
                }
                $bool->add($rangeQuery, BoolQuery::FILTER);
            }
        }

        $search = new Search();
        $search->addQuery($bool);

        $queryArray = $search->toArray();

        return $queryArray;
    }

    public function buildRangeQuery($field, $from = null, $to = null) {
        $rangeQuery = null;
        if($from && !$to){
            $rangeQuery = new RangeQuery(
                $field,
                [
                    'gte' => $from,
                ]
            );
        }
        else if(!$from && $to){
            $rangeQuery = new RangeQuery(
                $field,
                [
                    'lte' => $to
                ]
            );
        }
        else if($from && $to){
            $rangeQuery = new RangeQuery(
                $field,
                [
                    'gte' => $from,
                    'lte' => $to
                ]
            );
        }

        $search = new Search();
        $search->addQuery($rangeQuery);

        $queryArray = $search->toArray();

        return $queryArray;
    }
}
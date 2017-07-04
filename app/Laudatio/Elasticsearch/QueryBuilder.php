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
use ONGR\ElasticsearchDSL\Search;

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
}
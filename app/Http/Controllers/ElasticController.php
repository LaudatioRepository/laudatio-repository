<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cviebrock\LaravelElasticsearch\Facade;
use Elasticsearch;

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
        $params = [
            'index' => 'corpus',
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


    public function searchDocumentIndex(Request $request)
    {
        $params = [
            'index' => 'document',
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
}

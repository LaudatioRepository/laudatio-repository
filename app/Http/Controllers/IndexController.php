<?php

namespace App\Http\Controllers;

use App\Custom\ElasticsearchInterface;
use App\Custom\LaudatioUtilsInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class IndexController extends Controller
{

    protected $ElasticService;
    protected $LaudatioUtilService;
    protected $ccBaseUri;

    /**
     * IndexController constructor.
     */
    public function __construct(ElasticsearchInterface $Elasticservice, LaudatioUtilsInterface $laudatioUtils)
    {
        $this->ElasticService = $Elasticservice;
        $this->LaudatioUtilService = $laudatioUtils;
        $this->ccBaseUri = config('laudatio.ccBaseuri');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $corpusresponses = $this->ElasticService->getPublishedCorpora();
        $corpusdata = array();
        $documentcount = 0;
        $annotationcount = 0;

        $entries = null;
        $perPageArray = array();
        $sortedCollection = array();
        $perPage = null;
        $sortKriterium = null;

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $responseArray = $this->LaudatioUtilService->getPublishedCorpusData($corpusresponses,$this->ElasticService, $perPage ,$sortKriterium, $currentPage);
        return view('index')
            ->with('corpusdata',$responseArray['entries'])
            ->with('totalCount',$responseArray['totalcount'])
            ->with('perPageArray',$responseArray['perPageArray'])
            ->with('perPage',$responseArray['perPage'])
            ->with('ccBaseUri',$this->ccBaseUri);
    }
}
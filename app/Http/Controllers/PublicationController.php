<?php

namespace App\Http\Controllers;

use App\Publication;
use Illuminate\Http\Request;

class PublicationController extends Controller
{


    protected $GitRepoService;
    protected $laudatioUtils;
    protected $GitLabService;
    protected $elasticService;
    public function __construct(GitRepoInterface $Gitservice,  LaudatioUtilsInterface $laudatioUtils,GitLabInterface $GitLabService, ElasticsearchInterface $elasticService)
    {
        $this->GitRepoService = $Gitservice;
        $this->laudatioUtils = $laudatioUtils;
        $this->GitLabService = $GitLabService;
        $this->elasticService = $elasticService;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //First check if we can safely publish

        $result = null;
        $corpusid = $request->input('corpusid');
        $corpuspath = $request->input('corpuspath');

        $result = $this->GitRepoService->checkForMissingCorpusFiles($corpuspath."/TEI-HEADERS");
        dd($result);


        //if we can publish, find out what the current publication version is for the corpus

        //create a new index with the right  version

        //ingest

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function show(Publication $publication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function edit(Publication $publication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publication $publication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publication $publication)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Corpus;
use App\Document;
use App\Custom\GitRepoInterface;
use App\Custom\LaudatioUtilsInterface;
use GrahamCampbell\Flysystem\FlysystemManager;
use App\Custom\ElasticsearchInterface;
use Illuminate\Http\Request;
use Response;
use Log;

class DocumentController extends Controller
{


    protected $GitRepoService;
    protected $LaudatioUtilService;
    protected $elasticService;
    protected $flysystem;

    public function __construct(GitRepoInterface $GitRepoService, FlysystemManager $flysystem,LaudatioUtilsInterface $laudatioUtils,ElasticsearchInterface $elasticService)
    {
        $this->GitRepoService = $GitRepoService;
        $this->LaudatioUtilService = $laudatioUtils;
        $this->flysystem = $flysystem;
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
        //
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
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        $result = array();
        $status = "";
        try {
            $corpusid = $request->input('corpusid');
            $corpusPath = $request->input('path');
            $toBeDeleted = $request->input('tobedeleted');

            if(count($document->corpus()) > 0) {
                $document->corpus()->detach();
            }

            if(count($document->annotations()) > 0) {
                $document->annotations()->detach();
            }

            $document->delete();

            $status = "success";
            $result['delete_document_content_response']  = "Document content was successfully deleted";
        }
        catch (\Exception $e) {
            $status = "error";
            $result['delete_document_content_response']  = "There was a problem deleting the Document content. The error was: ($e) A message has been sent to the site administrator. Please try again later";
        }

        $response = array(
            'status' => $status,
            'msg' => $result,
        );

        return Response::json($response);

    }

    public function destroyDocumentContent(Request $request) {
        $result = array();
        $status = "success";

        try{
            $corpusid = $request->input('corpusid');
            $corpus = Corpus::findOrFail($corpusid);
            $corpusPath = $request->input('path');
            $auth_user_name = $request->input('auth_user_name');
            $auth_user_id = $request->input('auth_user_id');
            $auth_user_email = $request->input('auth_user_email');
            $toBeDeletedCollection = $request->input('tobedeleted');
            $corpusIsVersioned = $this->LaudatioUtilService->corpusIsVersioned($corpusid);

            foreach ($toBeDeletedCollection as $toBeDeleted) {
                $fileDeleteResult = false;

                if($corpusIsVersioned) {
                    $fileDeleteResult = $this->GitRepoService->deleteFile($this->flysystem,$corpusPath."/".$toBeDeleted['fileName'],$auth_user_name,$auth_user_email);
                }
                else{
                    $fileDeleteResult = $this->GitRepoService->deleteUntrackedFile($this->flysystem,$corpusPath."/".$toBeDeleted['fileName']);
                }


                if($fileDeleteResult) {

                    $document = Document::findOrFail($toBeDeleted['databaseId']);

                    if($corpusIsVersioned) {

                        $searchData = array();
                        array_push($searchData,array(
                            "_id" => $document->elasticsearch_id
                        ));

                        $elasticSearchDeleteResult = $this->elasticService->deleteIndexedObject($document->elasticsearch_index,$searchData);

                        if(!$elasticSearchDeleteResult['error']) {
                            if(count($document->annotations()) > 0) {
                                $document->annotations()->detach();
                            }
                            $document->delete();

                            $pushResult = $this->GitRepoService->pushFiles($corpusPath,$corpusid,$auth_user_name);
                        }

                        $this->LaudatioUtilService->emptyDocumentCacheByCorpusId($corpus->corpus_id,$document->elasticsearch_index);
                        $this->LaudatioUtilService->emptyDocumentCacheByDocumentIndex($document->elasticsearch_index);
                    }
                    else {
                        if(count($document->annotations()) > 0) {
                            $document->annotations()->detach();
                        }
                        $document->delete();
                    }

                }//end if filedeleted
            }


            $result['delete_content_response']  = "Document content was successfully deleted";

        }
        catch (\Exception $e) {
            $status = "error";
            $result['delete_content_response']  = "There was a problem deleting the Document content. The error was: ($e) A message has been sent to the site administrator. Please try again later";
        }


        $response = array(
            'status' => $status,
            'msg' => $result,
        );

        return Response::json($response);
    }
}

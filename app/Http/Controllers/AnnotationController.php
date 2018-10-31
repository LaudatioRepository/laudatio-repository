<?php

namespace App\Http\Controllers;

use App\Annotation;
use App\Document;
use App\Custom\GitRepoInterface;
use App\Custom\LaudatioUtilsInterface;
use GrahamCampbell\Flysystem\FlysystemManager;
use App\Custom\ElasticsearchInterface;
use Illuminate\Http\Request;
use Response;
use Log;

class AnnotationController extends Controller
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
     * @param  \App\Annotation  $annotation
     * @return \Illuminate\Http\Response
     */
    public function show(Annotation $annotation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Annotation  $annotation
     * @return \Illuminate\Http\Response
     */
    public function edit(Annotation $annotation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Annotation  $annotation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Annotation $annotation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Annotation  $annotation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Annotation $annotation)
    {
        $result = array();
        $status = "";
        try {
            $corpusid = $request->input('corpusid');
            $corpusPath = $request->input('path');
            $toBeDeleted = $request->input('tobedeleted');

            if(count($annotation->documents()) > 0) {
                $annotation->documents()->detach();
            }

            $annotation->delete();

            $status = "success";
            $result['delete_annotation_content_response']  = "Document content was successfully deleted";
        }
        catch (\Exception $e) {
            $status = "error";
            $result['delete_annotation_content_response']  = "There was a problem deleting the Document content. The error was: ($e) A message has been sent to the site administrator. Please try again later";
        }

        $response = array(
            'status' => $status,
            'msg' => $result,
        );

        return Response::json($response);

    }

    public function destroyAnnotationContent(Request $request) {
        $result = array();
        $status = "success";
        $loggedInUser = \Auth::user();

        try{
            $corpusid = $request->input('corpusid');
            $corpusPath = $request->input('path');
            $auth_user_name = $request->input('auth_user_name');
            $auth_user_id = $request->input('auth_user_id');
            $auth_user_email = $request->input('auth_user_email');
            $toBeDeletedCollection = $request->input('tobedeleted');

            foreach ($toBeDeletedCollection as $toBeDeleted) {
                $fileDeleteResult = $this->GitRepoService->deleteFile($this->flysystem,$corpusPath."/".$toBeDeleted['fileName'],$auth_user_name,$auth_user_email);

                if($fileDeleteResult) {
                    $annotation = Annotation::findOrFail($toBeDeleted['databaseId']);

                    $searchData = array();
                    array_push($searchData,array(
                        "_id" => $annotation->elasticsearch_id
                    ));

                    $elasticSearchDeleteResult = $this->elasticService->deleteIndexedObject($annotation->elasticsearch_index,$searchData);

                    if(!$elasticSearchDeleteResult['error']) {
                        if(count($annotation->documents()) > 0) {
                            $annotation->documents()->detach();
                        }
                        $annotation->delete();

                        $pushResult = $this->GitRepoService->pushFiles($corpusPath,$corpusid,$auth_user_name);
                    }
                }
            }

            $result['delete_content_response']  = "Annotation content was successfully deleted";

        }
        catch (\Exception $e) {
            $status = "error";
            $result['delete_content_response']  = "There was a problem deleting the Annotation content. The error was: ($e) A message has been sent to the site administrator. Please try again later";
        }


        $response = array(
            'status' => $status,
            'msg' => $result,
        );

        return Response::json($response);
    }
}

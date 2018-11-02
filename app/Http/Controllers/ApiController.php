<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Corpus;
use App\Document;
use App\Annotation;
use App\Custom\LaudatioUtilsInterface;
use Response;
use Log;

class ApiController extends Controller
{
    protected $LaudatioUtilService;

    public function __construct(LaudatioUtilsInterface $laudatioUtils)
    {
        $this->LaudatioUtilService = $laudatioUtils;
    }

    /**
     * getDatabaseIdByFilenameAndCorpusId
     * @param Request $request
     * @return mixed
     */
    public function getDatabaseIdByFilenameAndCorpusId(Request $request){
        $result = array();
        $status = "success";

        try{
            $dataArray = $request->input('dataArray');

            foreach($dataArray as $item) {
                $model = $this->LaudatioUtilService->getModelByFileName($item['filename'], $item['type'], false ,$item['corpusid']);
                $modelarray = array();
                if($model) {
                    $modelarray['database_id'] = $model[0]->id;
                    $modelarray['file_name'] = $model[0]->file_name;
                    $modelarray['created_at'] = $model[0]->created_at;
                    $modelarray['content_response']  = "The document id was successfully fetched";
                    array_push($result,$modelarray);
                }
            }
        }
        catch (\Exception $e) {
            $status = "error";
            $result['content_response']  = "There was a problem fetching the database id. The error was: ($e)";
        }


        $response = array(
            'status' => $status,
            'msg' => $result,
        );

        return Response::json($response);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Corpus;
use App\CorpusFile;
use App\Custom\GitRepoInterface;
use App\Custom\LaudatioUtilsInterface;
use GrahamCampbell\Flysystem\FlysystemManager;
use Response;
use Log;

class ApiController extends Controller
{
    protected $LaudatioUtilService;
    protected $GitRepoService;
    protected $flysystem;

    public function __construct(LaudatioUtilsInterface $laudatioUtils,GitRepoInterface $GitRepoService, FlysystemManager $flysystem)
    {
        $this->LaudatioUtilService = $laudatioUtils;
        $this->GitRepoService = $GitRepoService;
        $this->flysystem = $flysystem;
    }


    public function destroyFormatFileContent(Request $request) {
        $result = array();
        $status = "success";

        try{
            $corpusid = $request->input('corpusid');
            $corpusPath = $request->input('path');
            $auth_user_name = $request->input('auth_user_name');
            $auth_user_id = $request->input('auth_user_id');
            $auth_user_email = $request->input('auth_user_email');
            $toBeDeletedCollection = $request->input('tobedeleted');

            foreach ($toBeDeletedCollection as $toBeDeleted) {
                if(!is_array($toBeDeleted)){
                    $toBeDeleted = json_decode($toBeDeleted);
                }

                $corpusFile = CorpusFile::findOrFail($toBeDeleted['databaseId']);

                $fileDeleteResult = $this->GitRepoService->deleteFile($this->flysystem,$corpusPath."/".$toBeDeleted['fileName'],$auth_user_name,$auth_user_email);
                if($fileDeleteResult) {

                    if(count($corpusFile->corpus()) > 0) {
                        $corpusFile->corpus()->dissociate();
                        $corpusFile->delete();
                        $pushResult = $this->GitRepoService->pushFiles($corpusPath,$corpusid,$auth_user_name);
                    }
                }
            }

            $result['delete_content_response']  = "Corpus file content was successfully deleted";

        }
        catch (\Exception $e) {
            $status = "error";
            $result['delete_content_response']  = "There was a problem deleting the Corpus file content. The error was: ($e) A message has been sent to the site administrator. Please try again later";
        }


        $response = array(
            'status' => $status,
            'msg' => $result,
        );
        Log::info("RESTURNING: ".print_r($response,1));
        return Response::json($response);
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
                $type = $item['type'];
                if(strpos($item['type'],'format') !== false) {
                    $type = 'CORPUS-DATA';
                }
                $model = $this->LaudatioUtilService->getModelByFileName($item['filename'], $type, false ,$item['corpusid']);
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\Custom\ValidatorInterface;
use GrahamCampbell\Flysystem\FlysystemManager;
use Log;

class ValidateTEIController extends Controller
{
    protected $flySystem;
    protected $basePath;
    protected $validationService;


    public function __construct(FlysystemManager $flySystem, ValidatorInterface $validationService) {
        $this->flySystem = $flySystem;
        $this->basePath = config('laudatio.basePath');
        $this->validationService = $validationService;
    }


    public function validateXmlFile(Request $request) {
        try{
            $dirPath = $request->directorypath;
            $xmlfile = $request->fileName;

            $this->validationService->setXml($xmlfile);

            $corpusproject = CorpusProject::findOrFail($request->input('project_id'));



            $result['validatexml_response']  = "";
            $status = "success";
        }
        catch (\Exception $e) {
            $status = "error";
            $result['validatexml_response']  = "There was a problem validating the XML";
            //$e->getMessage();

        }


        $response = array(
            'status' => $status,
            'message' => $result,
        );

        return Response::json($response);
    }
}


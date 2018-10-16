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
    protected $schemaPath;
    protected $validationService;


    public function __construct(FlysystemManager $flySystem, ValidatorInterface $validationService) {
        $this->flySystem = $flySystem;
        $this->schemaPath = config('laudatio.schemaPath');
        $this->validationService = $validationService;
    }

    public function checkWellFormedNess(Request $request) {
        try{
            $dirPath = $request->directorypath;
            $xmlfile = $request->fileName;

            $this->validationService->setXml($xmlfile);

            $wellFormednessResult = $this->validationService->isWellFormed();

            $result['wellformedxml_response']  = $xmlfile." was Wellformed";
            $status = "success";
        }
        catch (\Exception $e) {
            $status = "error";
            $result['wellformedxml_response']  = $xmlfile." was not Wellformed: ".$e->getMessage();
            //$e->getMessage();

        }


        $response = array(
            'status' => $status,
            'message' => $result,
        );

        return Response::json($response);
    }

    public function validateXmlFile(Request $request) {
        try{
            $dirPath = $request->directorypath;
            $dirPathArray = explode("/",$dirPath);
            $corpusProjectPath = $dirPathArray[0];
            $corpusPath = $dirPathArray[1];
            $headerPath = $dirPathArray[$last_id];

            $xmlfile = $request->xmlFileName;

            $this->validationService->setXml($dirPath."/".$xmlfile);
            $this->validationService->setRelaxNGSchema($this->schemaPath."/".$headerPath."/".$headerPath.".rng");


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


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GrahamCampbell\Flysystem\FlysystemManager;
use App\Custom\LaudatioUtilsInterface;
use Log;
use Response;
use Chumper\Zipper\Zipper;

class DownloadsController extends Controller
{
    protected $flysystem;
    protected $connection;
    protected $basePath;
    protected $laudatioUtils;

    public function __construct(FlysystemManager $flysystem, LaudatioUtilsInterface $laudatioUtils)
    {
        $this->flysystem = $flysystem;
        $this->connection = $this->flysystem->getDefaultConnection();
        $this->basePath = config('laudatio.basePath');
        $this->laudatioUtils = $laudatioUtils;
    }

    public function teiDownload($path) {

        $header_filesystem = $this->flysystem->listContents($path.'/TEI-HEADERS');
        $zipper = new Zipper();
        $uniqueName = strtr(base64_encode(openssl_random_pseudo_bytes(16)), "+/=", "XXX");
        $zipper->make($uniqueName.'.zip');

        for ($i = 0; $i < count($header_filesystem);$i++){

            if($header_filesystem[$i]['type'] == "dir"){
                $subfiles =  $this->flysystem->listContents($header_filesystem[$i]['path']);
                $subfilearray = array();
                for($j=0;$j < count($subfiles);$j++){
                    $zipper->folder($header_filesystem[$i]['path'])->add($this->basePath.'/'.$subfiles[$j]['path']);
                }
            }
        }

        $zipper->close();
        $response = \Response::download($uniqueName.'.zip');
        ob_end_clean();
        return $response;
    }

    public function citeDownload(Request $request) {
        $citeFormat = null;
        $format = "";

        $result = null;


        try{
            $data = $request->input('data');
            //$format = $request->input('format');
            $result = $this->laudatioUtils->buildCiteFormat($data);
            $status = "success";
        }
        catch (\Exception $e) {
            $status = "error";
            $result['citedata_error_response']  = "There was a problem fetching the citation. A message has been sent to the site administrator. Please try again later";
        }


        $response = array(
            'status' => $status,
            'message' => $result
        );

        return Response::json($response);
    }



}

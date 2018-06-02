<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GrahamCampbell\Flysystem\FlysystemManager;
use App\Custom\LaudatioUtilsInterface;
use Log;
use Zipper;

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

        //$files = glob($this->basePath.'/'.$path.'/TEI-HEADERS');
        $header_filesystem = $this->flysystem->listContents($path.'/TEI-HEADERS');
        $zipper = new \Chumper\Zipper\Zipper;
        $uniqueName = strtr(base64_encode(openssl_random_pseudo_bytes(16)), "+/=", "XXX");
        $zipper->make('public/'.$uniqueName.'.zip');

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
        return response()->download('public/'.$uniqueName.'.zip');
    }

}

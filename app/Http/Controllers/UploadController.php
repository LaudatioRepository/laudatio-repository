<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use GrahamCampbell\Flysystem\FlysystemManager;
use DB;
use App\Custom\LaudatioUtilsInterface;
use Log;

class UploadController extends Controller
{

    protected $flysystem;
    protected $laudatioUtilsService;
    protected $connection;
    protected $blacklist = array('.git','README.md');
    protected $basePath;


    public function __construct(FlysystemManager $flysystem, LaudatioUtilsInterface $laudatioUtilsService)
    {
        $this->flysystem = $flysystem;
        $this->basePath = config('laudatio.basePath');
        $this->laudatioUtilsService = $laudatioUtilsService;
        $this->connection = $this->flysystem->getDefaultConnection();
    }

    public function uploadForm($dirname = "")
    {
        $isLoggedIn = \Auth::check();

        $dirArray = explode("/",$dirname);
        $corpusPath = $dirArray[1];
        $corpus = DB::table('corpuses')->where('directory_path',$corpusPath)->get();

        return view('gitLab.uploadform',["dirname" => $dirname,"corpusid" => $corpus[0]->id])
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',\Auth::user());
    }

    public function uploadSubmit(UploadRequest $request)
    {
        $updated = false;
        $dirPath = $request->directorypath;;
        $corpusId = $request->corpusid;


        foreach ($request->formats as $format) {
            $fileName = $format->getClientOriginalName();

            $filePath = $dirPath.'/'.$fileName;
            $exists = $this->flysystem->has($filePath);
            if(!$exists){
                $stream = fopen($format->getRealPath(), 'r+');
                $this->flysystem->writeStream($filePath, $stream);
            }
            else{
                $stream = fopen($format->getRealPath(), 'r+');
                $this->flysystem->updateStream($filePath, $stream);
                $updated = true;
            }

            if (is_resource($stream)) {
                fclose($stream);
            }

            $xmlpath = $this->basePath.'/'.$filePath;

            if(!empty($filePath)){
                $dirPathArray = explode("/",$dirPath);
                end($dirPathArray);
                $last_id=key($dirPathArray);
                $xmlNode = simplexml_load_file($xmlpath);
                $json = $this->laudatioUtilsService->parseXMLToJson($xmlNode, array());

                if($dirPathArray[$last_id] == 'corpus'){
                    $corpus = $this->laudatioUtilsService->setCorpusAttributes($json,$corpusId,$fileName);
                }
                else if($dirPathArray[$last_id] == 'document'){
                    $document = $this->laudatioUtilsService->setDocumentAttributes($json,$corpusId,$fileName);
                }
                else if($dirPathArray[$last_id] == 'annotation'){
                    $annotation = $this->laudatioUtilsService->setAnnotationAttributes($json,$corpusId,$fileName);
                    $preparationSteps = $this->laudatioUtilsService->setPreparationAttributes($json,$annotation->id,$corpusId);
                }
            }

        }
        return redirect()->route('admin.corpora.show',['path' => $dirPath,'corpus' => $corpusId]);
    }
}
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
        $dirPath = $request->directorypath;;
        $entityId = $request->corpusid;


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
            }

            if (is_resource($stream)) {
                fclose($stream);
            }

            $xmlpath = $this->basePath.'/'.$filePath;

            if(!empty($filePath)){
                $xmlNode = simplexml_load_file($xmlpath);
                $json = $this->laudatioUtilsService->parseXMLToJson($xmlNode, array());

                if(strpos($dirPath,'corpus') !== false){
                    $corpus = $this->laudatioUtilsService->setCorpusAttributes($json,$entityId);
                }
                else if(strpos($dirPath,'document') !== false){
                    $document = $this->laudatioUtilsService->setDocumentAttributes($json,$entityId);
                }
                else if(strpos($dirPath,'annotation') !== false){
                    $annotation = $this->laudatioUtilsService->setAnnotationAttributes($json,$entityId);
                }
            }




        }
        return redirect()->route('admin.corpora.show',['path' => $dirPath,'corpus' => $entityId]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use GrahamCampbell\Flysystem\FlysystemManager;
use DB;


class UploadController extends Controller
{

    protected $flysystem;
    protected $connection;
    protected $blacklist = array('.git','README.md');

    public function __construct(FlysystemManager $flysystem)
    {
        $this->flysystem = $flysystem;
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
        $dirPath = $request->directorypath;
        $corpusId = $request->corpusid;

        foreach ($request->formats as $format) {
            $fileName = $format->getClientOriginalName();
            $exists = $this->flysystem->has($dirPath."/".$fileName);
            if(!$exists){
                $stream = fopen($format->getRealPath(), 'r+');
                $this->flysystem->writeStream($dirPath."/".$fileName, $stream);
            }
            else{
                $stream = fopen($format->getRealPath(), 'r+');
                $this->flysystem->updateStream($dirPath."/".$fileName, $stream);
            }

            if (is_resource($stream)) {
                fclose($stream);
            }


        }
        return redirect()->route('admin.corpora.show',['path' => $dirPath,'corpus' => $corpusId]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use GrahamCampbell\Flysystem\FlysystemManager;


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
        return view('gitLab.uploadform',["dirname" => $dirname])
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',\Auth::user());
    }

    public function uploadSubmit(UploadRequest $request)
    {
        $dirPath = $request->directorypath;

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
        return redirect()->route('gitRepo.route',['path' => $dirPath]);
    }
}
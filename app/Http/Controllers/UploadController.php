<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use GrahamCampbell\Flysystem\FlysystemManager;
use App\Laudatio\GitLaB\GitFunction;


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
        $gitFunction = new GitFunction();
        $dirPath = $request->directorypath;

        foreach ($request->formats as $format) {
            $fileName = $format->getClientOriginalName();
            $newFilename = $gitFunction->normalizeFileName($fileName);

            $exists = $this->flysystem->has($dirPath."/".$newFilename);
            if(!$exists){
                $stream = fopen($format->getRealPath(), 'r+');
                $this->flysystem->writeStream($dirPath."/".$newFilename, $stream);
            }
            else{
                $stream = fopen($format->getRealPath(), 'r+');
                $this->flysystem->updateStream($dirPath."/".$newFilename, $stream);
            }

            if (is_resource($stream)) {
                fclose($stream);
            }


        }
        return redirect()->route('gitRepo.route',['path' => $dirPath]);
    }
}
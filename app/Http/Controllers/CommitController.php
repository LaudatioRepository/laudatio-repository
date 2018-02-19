<?php

namespace App\Http\Controllers;
use App\Http\Requests\CommitRequest;
use App\CorpusProject;
use App\Corpus;
use Log;

class CommitController extends Controller
{
    public function commitForm($dirname = "")
    {
        $corpusId = request()->corpus;
        if(!$corpusId){
            $pathArray = explode("/",$dirname);
            $corpusProjectPath = $pathArray[0];
            $corpusPath = $pathArray[1];

            $corpusProjectObject = CorpusProject::where([
                "directory_path" => $corpusProjectPath
            ])->get();
            $corpusObject = Corpus::where([
                "directory_path" => $corpusPath
            ])->get();

            if(null != $corpusProjectObject && null != $corpusObject){
                $corpusId = $corpusObject[0]->id;
            }


        }
        $isLoggedIn = \Auth::check();
        return view('gitLab.commitform',["dirname" => $dirname, "corpusid" => $corpusId])
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',\Auth::user());
    }

    public function commitSubmit(CommitRequest $request)
    {
        return redirect()->action(
            'GitRepoController@commitFiles', ['dirname' =>  $request->directorypath, 'commitmessage' => $request->commitmessage, 'corpusid' => $request->corpusid]
        );
    }

}
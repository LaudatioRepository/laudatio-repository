<?php

namespace App\Http\Controllers;
use App\Http\Requests\CommitRequest;

class CommitController extends Controller
{
    public function commitForm($dirname = "")
    {
        $isLoggedIn = \Auth::check();
        return view('gitLab.commitform',["dirname" => $dirname])
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',\Auth::user());
    }

    public function commitSubmit(CommitRequest $request)
    {
        return redirect()->action(
            'GitRepoController@commitFiles', ['dirname' =>  $request->directorypath, 'commitmessage' => $request->commitmessage]
        );
    }

}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CorpusProject;

class CorpusProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $isLoggedIn = \Auth::check();
        $user = \Auth::user();
        $CorpusProjects = CorpusProject::all();

        return view('admin.corpusprojectadmin.index', compact('CorpusProjects'))
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();
        return view('admin.corpusprojectadmin.create')
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'corpusproject_name' => 'required',
            'corpusproject_description' => 'required'
        ]);

        CorpusProject::create([
            "name" => request('corpusproject_name'),
            "description" => request('corpusproject_description')
        ]);
        return redirect('/corpusprojects');
    }

    /**
     * @param CorpusProject $corpusProject
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(CorpusProject $corpusProject){
        return view('admin.corpusprojectadmin.show', compact('CorpusProject'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.corpusprojectadmin.edit', compact('CorpusProject'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return view('admin.corpusprojectadmin.destroy', compact('CorpusProject'));
    }
}

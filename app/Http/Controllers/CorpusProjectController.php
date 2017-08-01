<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CorpusProject;
use App\Corpus;

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
        $CorpusProjects = CorpusProject::latest()->get();

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
        return redirect()->route('admin.corpusProject.index');
    }

    /**
     * @param CorpusProject $corpusproject
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(CorpusProject $corpusproject){
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();
        return view('admin.corpusprojectadmin.show', compact('corpusproject'))
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }

    public function assign(CorpusProject $corpusproject) {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();
        $corpora = Corpus::latest()->get();
        $filteredList = array();

        foreach ($corpora as $corpus){
            if(!$corpusproject->corpora->contains($corpus)){
                array_push($filteredList,$corpus);
            }
        }

        return view('admin.corpusprojectadmin.assign_corpora')
            ->with('corpusproject', $corpusproject)
            ->with('corpora', $filteredList)
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }

    public function storeRelations($id)
    {

        $this->validate(request(), [
            'corpora' => 'required',
        ]);

        $corpusproject = CorpusProject::find($id);
        foreach (request('corpora') as $corpusid){
            $corpus = Corpus::find($corpusid);
            $corpusproject->corpora()->attach($corpus);
        }

        return redirect()->route('admin.corpusProject.index');
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

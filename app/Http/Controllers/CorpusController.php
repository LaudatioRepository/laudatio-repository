<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Corpus;

class CorpusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();
        $corpora = Corpus::latest()->get();

        return view('admin.corpusadmin.index', compact('corpora'))
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
        return view('admin.corpusadmin.create')
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
            'corpus_name' => 'required',
            'corpus_description' => 'required'
        ]);

        Corpus::create([
            "name" => request('corpus_name'),
            "description" => request('corpus_description')
        ]);
        return redirect()->route('admin.corpora.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Corpus $corpus)
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();
        return view('admin.corpusadmin.show', compact('corpus'))
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }
}

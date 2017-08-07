<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CorpusProject;
use App\Corpus;
use App\User;
use App\Custom\GitRepoInterface;
use GrahamCampbell\Flysystem\FlysystemManager;


class CorpusProjectController extends Controller
{
    protected $GitRepoService;

    public function __construct(GitRepoInterface $Gitservice,FlysystemManager $flysystem)
    {
        $this->GitRepoService = $Gitservice;
        $this->flysystem = $flysystem;
        $this->connection = $this->flysystem->getDefaultConnection();
        $this->basePath = config('laudatio.basePath');
    }

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

        // Create the directory structure for the Corpus Project
        $filePath = $this->GitRepoService->createProjectFileStructure($this->flysystem,request('corpusproject_name'));
        if($filePath){
            CorpusProject::create([
                'name' => request('corpusproject_name'),
                'description' => request('corpusproject_description'),
                'directory_path' => $filePath
            ]);
        }


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


    /**
     * @param CorpusProject $corpusproject
     * @return $this
     */
    public function edit(CorpusProject $corpusproject)
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();
        return view('admin.corpusprojectadmin.edit', compact('corpusproject'))
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }

    /**
     * @param Request $request
     * @param CorpusProject $corpusproject
     * @return $this
     */
    public function update(Request $request, CorpusProject $corpusproject)
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();

        $corpusproject->update([
            "name" => request('corpusproject_name'),
            "description" => request('corpusproject_description')
        ]);

        return view('admin.corpusprojectadmin.show', compact('corpusproject'))
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }

    /**
     * @param CorpusProject $corpusproject
     * @return $this
     */
    public function delete(CorpusProject $corpusproject)
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();
        return view('admin.corpusprojectadmin.delete', compact('corpusproject'))
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }

    /**
     * @param Request $request
     * @param CorpusProject $corpusproject
     * @return $this
     */
    public function destroy(Request $request, CorpusProject $corpusproject)
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();

        if(count($corpusproject->corpora()) > 0) {
            $corpusproject->corpora()->detach();
        }

        if(count($corpusproject->users()) > 0) {
            $corpusproject->users()->detach();
        }

        $corpusproject->delete();
        $CorpusProjects = CorpusProject::latest()->get();

        return view('admin.corpusprojectadmin.index', compact('CorpusProjects'))
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }

    /**
     * @param CorpusProject $corpusproject
     * @return $this
     */
    public function assignCorpora(CorpusProject $corpusproject) {
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

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeCorpusRelations($id)
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
     * @param CorpusProject $corpusproject
     * @return $this
     */
    public function assignUsers(CorpusProject $corpusproject) {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();
        $users = User::latest()->get();
        $filteredList = array();

        foreach ($users as $user){
            if(!$corpusproject->users->contains($user)){
                array_push($filteredList,$user);
            }
        }

        return view('admin.corpusprojectadmin.assign_users')
            ->with('corpusproject', $corpusproject)
            ->with('users', $users)
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeUserRelations($id)
    {

        $this->validate(request(), [
            'users' => 'required',
        ]);

        $corpusproject = CorpusProject::find($id);
        foreach (request('users') as $userId){
            $user = User::find($userId);
            $corpusproject->users()->attach($user);
        }

        return redirect()->route('admin.corpusProject.index');
    }
}

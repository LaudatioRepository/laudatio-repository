<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Corpus;
use App\CorpusProject;
use App\Custom\GitRepoInterface;
use GrahamCampbell\Flysystem\FlysystemManager;

class CorpusController extends Controller
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
    public function create(CorpusProject $corpusproject)
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();
        return view('admin.corpusadmin.create')
            ->with('isLoggedIn', $isLoggedIn)
            ->with('corpusProjectId',$corpusproject->id)
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
            'corpus_description' => 'required',
            'corpusProjectId' => 'required'
        ]);

        $corpusProject = CorpusProject::find(request('corpusProjectId'));

        // Create the directory structure for the Corpus
        $corpusProjectPath = $corpusProject->directory_path;
        $corpusPath = null;
        if(request('corpus_name')){
            $corpusPath = $this->GitRepoService->createCorpusFileStructure($this->flysystem,$corpusProjectPath,request('corpus_name'));
        }

        if($corpusPath){
            $corpus = Corpus::create([
                "name" => request('corpus_name'),
                "description" => request('corpus_description'),
                'directory_path' => $corpusPath
            ]);

            $corpus->corpusprojects()->attach($corpusProject);
        }

        return redirect()->route('admin.corpora.index');
    }

    /**
     * @param Corpus $corpus
     * @return $this
     */
    public function show(Corpus $corpus,$path = "",$show = "")
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();

        $corpusProjects = $corpus->corpusprojects()->get();
        $corpusProject_directory_path = '';
        //dd($corpusProjects);
        if(count($corpusProjects) == 1) {
            $corpusProject_directory_path = $corpusProjects->first()->directory_path;
        }
        else{
            // what to do when we can assign corpora to many projects?
        }

        $corpusPath = "";
        $corpus_directory_path = $corpus->directory_path;
        if($path == ""){
            $corpusPath = $corpusProject_directory_path."/".$corpus_directory_path;
        }
        else{
            $corpusPath = $path;
        }

        $fileData = $this->GitRepoService->getCorpusFiles($this->flysystem,$corpusPath);
        //dd($fileData);

        return view("admin.corpusadmin.show",["corpus" => $corpus, "projects" => $fileData['projects'], "pathcount" => $fileData['pathcount'],"path" => $fileData['path'],"previouspath" => $fileData['previouspath']])
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }

    /**
     * @param Corpus $corpus
     * @return $this
     */
    public function edit(Corpus $corpus)
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();
        return view('admin.corpusadmin.edit', compact('corpus'))
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }

    /**
     * @param Request $request
     * @param Corpus $corpus
     * @return $this
     */
    public function update(Request $request, Corpus $corpus)
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();

        $corpus->update([
            "name" => request('corpus_name'),
            "description" => request('corpus_description')
        ]);

        return view('admin.corpusadmin.show', compact('corpus'))
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }


    /**
     * @param Corpus $corpus
     * @return $this
     */
    public function delete(Corpus $corpus)
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();

        return view('admin.corpusadmin.delete', compact('corpus'))
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }

    /**
     * @param Request $request
     * @param Corpus $corpus
     * @return $this
     */
    public function destroy(Request $request, Corpus $corpus)
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();

        if(count($corpus->corpusprojects()) > 0) {
            $corpus->corpusprojects()->detach();
        }

        if(count($corpus->users()) > 0) {
            $corpus->users()->detach();
        }

        $corpus->delete();
        $corpora = Corpus::latest()->get();

        return view('admin.corpusadmin.index', compact('corpora'))
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Corpus;
use App\CorpusProject;
use App\User;
use App\Role;
use App\Custom\GitRepoInterface;
use App\Custom\GitLabInterface;
use GrahamCampbell\Flysystem\FlysystemManager;
use Illuminate\Support\Facades\Auth;
use Response;
use Log;

class CorpusController extends Controller
{
    protected $GitRepoService;

    public function __construct(GitRepoInterface $Gitservice,GitLabInterface $GitLabService,FlysystemManager $flysystem)
    {
        $this->GitRepoService = $Gitservice;
        $this->GitLabService = $GitLabService;
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

        $corpusProjects = array();

        foreach ($corpora as $corpus){
            $corpusProjectsTemp = $corpus->corpusprojects()->get();
            $cp = isset($corpusProjectsTemp[0]) ? $corpusProjectsTemp[0] : false;
            if($cp) {
                $corpusProjects[$corpus->id] = $corpusProjectsTemp[0]->directory_path;
            }
        }

        return view('/project.corpus.index', compact('corpora'))
            ->with('isLoggedIn', $isLoggedIn)
            ->with('corpusProjects', $corpusProjects)
            ->with('user',$user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_old(CorpusProject $corpusproject)
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();
        return view('project.corpus.create')
            ->with('isLoggedIn', $isLoggedIn)
            ->with('corpusProjectId',$corpusproject->id)
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
        $corpusProjectPath = $corpusproject->directory_path;
        $corpusProjectId = $corpusproject->gitlab_id;

        // Create the directory structure for the Corpus
        $corpusProjectPath = $corpusproject->directory_path;
        $corpusCount = count($corpusproject->corpora()->get());
        $corpus_name = "Untitled_".$corpusProjectId."_".($corpusCount++);
        $corpusPath = $this->GitRepoService->createCorpusFileStructure($this->flysystem,$corpusProjectPath,$corpus_name);


        if($corpusPath){
            $corpus = Corpus::create([
                "name" => $corpus_name,
                "description" => "",
                'directory_path' => $corpusPath
            ]);

            $corpus->corpusprojects()->attach($corpusproject);
        }

        return redirect()->route('project.corpora.index');
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
            //'corpus_name' => 'required',
            'corpus_description' => 'required',
            'corpusProjectId' => 'required'
        ]);


        $corpusProject = CorpusProject::find(request('corpusProjectId'));
        $corpusProjectPath = $corpusProject->directory_path;
        $corpusProjectId = $corpusProject->gitlab_id;

        // Create the directory structure for the Corpus
        $corpusProjectPath = $corpusProject->directory_path;
        $corpusCount = count($corpusProject->corpora()->get());
        $corpus_name = "Untitled_".$corpusProjectId."_".($corpusCount++);
        $corpusPath = $this->GitRepoService->createCorpusFileStructure($this->flysystem,$corpusProjectPath,$corpus_name);


        if($corpusPath){
            $corpus = Corpus::create([
                "name" => $corpus_name,
                "description" => request('corpus_description'),
                'directory_path' => $corpusPath
            ]);

            $corpus->corpusprojects()->attach($corpusProject);
        }

        return redirect()->route('project.corpora.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_untitled(Request $request)
    {
        $this->validate(request(), [
            //'corpus_name' => 'required',
            'corpus_description' => 'required',
            'corpusProjectId' => 'required'
        ]);

        $corpusProject = CorpusProject::find(request('corpusProjectId'));

        // Create the directory structure for the Corpus
        $corpusProjectPath = $corpusProject->directory_path;
        $corpusProjectId = $corpusProject->gitlab_id;
        $corpusPath = null;
        /**
        if(request('corpus_name')){
            $corpusPath = $this->GitRepoService->createCorpusFileStructure($this->flysystem,$corpusProjectPath,request('corpus_name'));
        }
        else{

        }
         * */

        $corpusPath = "Untitled".$corpusProjectId;
        if($corpusPath){
            $corpus = Corpus::create([
                "name" => "Untitled",
                "description" => request('corpus_description'),
                'directory_path' => $corpusPath
            ]);
            $corpus->corpusprojects()->attach($corpusProject);
            /*
            $gitLabResponse = $this->GitLabService->createGitLabProject(
                //request('corpus_name'),
                "Untitled",
                array(
                    'namespace_id' => $corpusProjectId,
                    'description' => request('corpus_description'),
                    'visibility' => 'public'
                )

            );
            Log::info("gitLabResponse: Corpus ".print_r($gitLabResponse,1));

            $corpus = Corpus::create([
                "name" => request('corpus_name'),
                "description" => request('corpus_description'),
                'directory_path' => $corpusPath,
                'gitlab_group_id' => $corpusProjectId,
                'gitlab_id' => $gitLabResponse['id'],
                'gitlab_web_url' => $gitLabResponse['web_url'],
                'gitlab_namespace_path' => $gitLabResponse['name_with_namespace']
            ]);

            $corpus->corpusprojects()->attach($corpusProject);
            */
        }

        return redirect()->route('project.corpora.index');
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

        $corpusBasePath = "";//substr($corpusPath,0,strrpos($corpusPath,"/"));


        $fileData = array(
            "corpusData" => array(
                'path' => $corpusPath.'/CORPUS-DATA',
                'hasdir' => false
            ),
            "corpusDataFolder" => "",
            "headerData" => array(
                'path' => $corpusPath.'/TEI-HEADERS',
                'hasdir' => false
            ),
            "headerDataFolder" => "",
            "folderType" => ""
        );
        $folder = "";
        $folderType = "";
        $user_roles = array();
        if(strpos($corpusPath,"Untitled") === false){
            $pathArray = explode("/",$corpusPath);
            $corpusBasePath = $pathArray[0]."/".$pathArray[1];
            if(strpos($corpusPath,"CORPUS-DATA") !== false && strpos($corpusPath,"TEI-HEADERS") === false){
                $corpusData = $this->GitRepoService->getCorpusDataFiles($this->flysystem,$corpusPath);
                $headerData = $this->GitRepoService->getCorpusFiles($this->flysystem,$corpusBasePath.'/TEI-HEADERS');
                $folderType = "CORPUS-DATA";

            }
            else if(strpos($corpusPath,"TEI-HEADERS") !== false && strpos($corpusPath,"CORPUS-DATA") === false){
                $corpusData = $this->GitRepoService->getCorpusDataFiles($this->flysystem,$corpusBasePath.'/CORPUS-DATA');
                $headerData = $this->GitRepoService->getCorpusFiles($this->flysystem,$corpusPath);
                $folderType = "TEI-HEADERS";
            }
            else{
                $corpusData = $this->GitRepoService->getCorpusDataFiles($this->flysystem,$corpusPath.'/CORPUS-DATA');
                $headerData = $this->GitRepoService->getCorpusFiles($this->flysystem,$corpusPath.'/TEI-HEADERS');
            }

            $corpusDataFolder = substr($corpusData['path'],strrpos($corpusData['path'],"/")+1);
            $headerDataFolder = substr($headerData['path'],strrpos($headerData['path'],"/")+1);
            $fileData = array(
                "corpusData" => $corpusData,
                "corpusDataFolder" => $corpusDataFolder,
                "headerData" => $headerData,
                "headerDataFolder" => $headerDataFolder,
                "folderType" => $folderType
            );


            $corpusUsers = $corpus->users()->get();

            foreach ($corpusUsers as $corpusUser){
                if(!isset($user_roles[$corpusUser->id])){
                    $user_roles[$corpusUser->id] = array();
                }

                $role = Role::find($corpusUser->pivot->role_id);
                if($role){
                    array_push($user_roles[$corpusUser->id],$role->name);
                }

            }
        }
        //dd($corpusUsers );

        return view("project.corpus.show",["corpus" => $corpus, "corpusproject_directory_path" => $corpusProject_directory_path, "fileData" => $fileData])
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user_roles',$user_roles)
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
        return view('project.corpus.edit', compact('corpus'))
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

        $corpusProjects = $corpus->corpusprojects()->get();
        $corpusproject = null;
        $corpusProject_directory_path = '';
        if(count($corpusProjects) == 1) {
            $corpusproject = $corpusProjects->first();
            $corpusProject_directory_path = $corpusproject->directory_path;
        }
        else{
            // what to do when we can assign corpora to many projects?
        }

        $corpora = $corpusproject->corpora()->get();

        $user_roles = array();
        $corpusProjectUsers = $corpusProjects->first()->users()->get();
        foreach ($corpusProjectUsers as $corpusProjectUser){
            if(!isset($user_roles[$corpusProjectUser->id])){
                $user_roles[$corpusProjectUser->id]['roles'] = array();
            }
            $user_roles[$corpusProjectUser->id]['user_name'] = $corpusProjectUser->name;

            $role = Role::find($corpusProjectUser->pivot->role_id);
            array_push($user_roles[$corpusProjectUser->id]['roles'],$role->name);
        }


        return view('project.corpusproject.show', compact('corpusproject'))
            ->with('isLoggedIn', $isLoggedIn)
            ->with('corpora',$corpora)
            ->with('user_roles',$user_roles)
            ->with('user',$user);
    }


    /**
     * @param Corpus $corpus
     * @return $this
     */
    public function delete(Corpus $corpus, $corpusproject_directory_path)
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();

        $corpusProject = CorpusProject::where('directory_path', '=', $corpusproject_directory_path)->get();

        return view('project.corpus.delete', compact('corpus'))
            ->with('projectId', $corpusProject[0]->id)
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }


    /**
     * @param Request $request
     * @param Corpus $corpus
     * @return $this
     */
    public function destroy(Request $request, Corpus $corpus, $projectId)
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();

        $gitLabProjectId = $corpus->gitlab_id;
        $corpusProject = CorpusProject::find($projectId);

        if(count($corpus->corpusprojects()) > 0) {
            $corpus->corpusprojects()->detach();
        }

        if(count($corpus->users()) > 0) {
            $corpus->users()->detach();
        }


        if(count($corpus->documents) > 0){
            foreach ($corpus->documents as $document){

                if(count($document->annotations) > 0){
                    foreach ($document->annotations as $annotation){
                            if(count($annotation->documents()) > 0) {
                                $annotation->documents()->detach();
                            }
                            if(count($annotation->preparations) > 0) {
                                $annotation->preparations()->delete();
                            }
                    }//end for annotations
                    $document->annotations()->delete();
                }//end if annotations
            }
            $corpus->documents()->delete();
        }

        if(count($corpus->annotations) > 0){
            $corpus->annotations()->delete();
        }

        if($gitLabProjectId != ""){
            $this->GitLabService->deleteGitLabProject($gitLabProjectId);
        }

        $corpus->delete();

        $corpusPath = $corpusProject->directory_path.'/'.$corpus->directory_path;
        $this->GitRepoService->deleteCorpusFileStructure($this->flysystem,$corpusPath);

        $corpora = array();
        $corpora = Corpus::latest()->get();

        $corpusProjects = array();

        foreach ($corpora as $corpus){
            $corpusProjectsTemp = $corpus->corpusprojects()->get();
            $cp = isset($corpusProjectsTemp[0]) ? $corpusProjectsTemp[0] : false;
            if($cp){
                $corpusProjects[$corpus->id] = $corpusProjectsTemp[0]->directory_path;
            }
        }

        return view('project.corpus.index', compact('corpora'))
            ->with('isLoggedIn', $isLoggedIn)
            ->with('corpusProjects', $corpusProjects)
            ->with('user',$user);
    }


    /**
     * @param Corpus $corpus
     * @return $this
     */
    public function assignCorpusUsers(Corpus $corpus) {

        $isLoggedIn = \Auth::check();
        $loggedInUser = \Auth::user();
        $users = User::latest()->get();
        $filteredList = array();

        foreach ($users as $user){
            if(!$corpus->users->contains($user)){
                array_push($filteredList,$user);
            }
        }

        $user_roles = array();
        $corpusUsers = $corpus->users()->get();


        foreach ($corpusUsers as $corpusUser){
            $role = Role::find($corpusUser->pivot->role_id);

            if(!isset($user_roles[$corpusUser->pivot->role_id])){
                $user_roles[$corpusUser->pivot->role_id] = array();
            }
                array_push($user_roles[$corpusUser->pivot->role_id],$corpusUser->id);
        }

        /*
        $projects = $corpus->corpusprojects()->get();
        $project_user_roles = array();

        foreach ($projects as $project){
            $projectUsers = $project->users()->get();
            foreach ($projectUsers as $projectUser){
                $project_user_roles[$projectUser->id] = $projectUser->pivot->role_id;
            }
        }
*/
        $roles = Role::all();
        $filteredRoles = array();
        foreach ($roles as $role){
                if(
                    !$role->hasPermissionTo('Administer the application') &&
                    !$role->hasPermissionTo('Can create corpus project') &&
                    ($role->hasPermissionTo('Can create corpus')
                        || $role->hasPermissionTo('Can edit corpus')
                    )
                ){
                    array_push($filteredRoles,$role);
            }
        }

        //dd($filteredRoles);

        return view('project.corpus.assign_corpusroles_to_user')
            ->with('corpus', $corpus)
            ->with('users', $users)
            ->with('user',$loggedInUser)
            ->with('roles', $filteredRoles)
            ->with('user_roles',$user_roles)
            ->with('isLoggedIn', $isLoggedIn)
            ->with('loggedInUser',$loggedInUser);

    }

    public function storeRelationsByCorpus(Request $request)
    {

        $input =$request ->all();
        $msg = "";
        if ($request->ajax()){
            $msg .= "<p>Assigned the following roles to user </p>";
            $role_users = $input['role_users'];
            $corpus = Corpus::find($input['corpus_id']);
            $msg .= "<ul>";


            foreach($role_users as $roleId => $user_data) {
                $role = Role::find($roleId);
                if($role){
                    $msg .= "<li>".$role->name."<ul>";
                    foreach($user_data as $userId) {
                        $user = User::find($userId);

                        if($user) {
                            if(!$user->roles->contains($role)){
                                $user->roles()->attach($role);
                            }

                            $msg .= "<li>".$user->name."</li>";
                            $corpus->users()->save($user,['role_id' => $roleId]);

                        }

                    }
                    $msg .= "</ul></li>";
                }
            }//end foreach

            $msg .= "</ul>";
        }

        $response = array(
            'status' => 'success',
            'msg' => $msg,
        );

        return Response::json($response);
    }

    public function deleteRelationsByCorpus(Request $request){
        $input =$request ->all();
        $msg = "";
        if ($request->ajax()){

            $msg .= "<p>Removed the following user from the project: </p>";
            $userId = $input['userId'];
            $roleId = $input['roleId'];
            $corpus = Corpus::find($input['corpusId']);
            $user = User::find($userId);
            $corpus->users()->detach($userId);
            $msg .= "<ul>";
            $msg .= "<li>".$user->name."</li>";
            $msg .= "</ul>";
        }

        $response = array(
            'status' => 'success',
            'msg' => $msg,
        );

        return Response::json($response);
    }

    public function  destroyCorpusUser($corpusId,$userId){
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();

        $corpus = Corpus::find($corpusId);
        $corpus->users()->detach($userId);

        $roles = Role::latest()->get();
        return view('project.useradmin.roles.index', compact('roles'))
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }
}

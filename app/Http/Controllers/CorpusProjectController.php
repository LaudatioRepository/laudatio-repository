<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CorpusProject;
use App\Corpus;
use App\User;
use App\Role;
use App\Custom\GitRepoInterface;
use App\Custom\GitLabInterface;
use GrahamCampbell\Flysystem\FlysystemManager;
use Response;
use Log;


class CorpusProjectController extends Controller
{
    protected $GitRepoService;
    protected $GitLabService;

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
    public function index(){

        $isLoggedIn = \Auth::check();
        $user = \Auth::user();
        $CorpusProjects = CorpusProject::latest()->get();

        $corpus_projects = array();


        foreach ($CorpusProjects as $corpusProject){
            if(!array_key_exists($corpusProject->id, $corpus_projects)){
                $corpus_projects[$corpusProject->id] = array();
                $corpus_projects[$corpusProject->id]['user_roles'] = array();
                $corpus_projects[$corpusProject->id]['corpora'] = array();
            }

            $corpus_projects[$corpusProject->id]['name'] = $corpusProject->name;
            $corpus_projects[$corpusProject->id]['description'] = $corpusProject->description;
            $corpus_projects[$corpusProject->id]['directory_path'] = $corpusProject->directory_path;


            $corpusProjectUsers = $corpusProject->users()->get();

            foreach ($corpusProjectUsers as $corpusProjectUser){
                $user_role = array();
                $role = Role::find($corpusProjectUser->pivot->role_id);
                if($role){
                    $user_role['user_name'] = $corpusProjectUser->name;
                    $user_role['user_id'] = $corpusProjectUser->id;

                    $user_role['role_name'] = $role->name;
                    array_push($corpus_projects[$corpusProject->id]['user_roles'],$user_role);
                }
            }

            foreach ($corpusProject->corpora()->get() as $projectCorpus){
                if(!array_key_exists($projectCorpus->id, $corpus_projects[$corpusProject->id]['corpora'])){
                    $corpus_projects[$corpusProject->id]['corpora'][$projectCorpus->id] = array();
                    $corpus_projects[$corpusProject->id]['corpora'][$projectCorpus->id]['user_roles'] = array();
                }
                $corpus_projects[$corpusProject->id]['corpora'][$projectCorpus->id]['name'] = $projectCorpus->name;
                $corpus_projects[$corpusProject->id]['corpora'][$projectCorpus->id]['id'] = $projectCorpus->id;
                $corpus_projects[$corpusProject->id]['corpora'][$projectCorpus->id]['corpuspath'] = $corpusProject->directory_path."/".$projectCorpus->directory_path;
                $corpus_projects[$corpusProject->id]['corpora'][$projectCorpus->id]['workflow_status'] = $projectCorpus->workflow_status;
                $corpus_projects[$corpusProject->id]['corpora'][$projectCorpus->id]['elasticsearch_id'] = $projectCorpus->elasticsearch_id;
                $corpus_projects[$corpusProject->id]['corpora'][$projectCorpus->id]['corpus_logo'] = $projectCorpus->corpus_logo;

                $corpusUsers = $projectCorpus->users()->get();
                foreach ($corpusUsers as $corpusUser){
                    $user_role = array();
                    $role = Role::find($corpusUser->pivot->role_id);
                    if($role){
                        $user_role['user_name'] = $corpusUser->name;
                        $user_role['user_id'] = $corpusUser->id;
                        $user_role['role_name'] = $role->name;
                        array_push($corpus_projects[$corpusProject->id]['corpora'][$projectCorpus->id]['user_roles'],$user_role);
                    }

                }

            }
        }
        //dd($corpus_projects);
        return view('project.corpusproject.index')
            ->with('corpusProjects',$corpus_projects)
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
        return view('project.corpusproject.create')
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
        //$this->GitRepoService->createGitProject($filePath);
        if($filePath){

            $gitLabResponse = $this->GitLabService->createGitLabGroup(
                request('corpusproject_name'),
                $filePath,
                request('corpusproject_description'),
                'public'
                );

            //Log::info("gitLabResponse: CorpusProject ".print_r($gitLabResponse,1));

            if($gitLabResponse['id']) {
                $corpusproject = CorpusProject::create([
                    'name' => request('corpusproject_name'),
                    'description' => request('corpusproject_description'),
                    'directory_path' => $filePath,
                    'gitlab_group_path' => $gitLabResponse['path'],
                    'gitlab_id' => $gitLabResponse['id'],
                    'gitlab_web_url' => $gitLabResponse['web_url'],
                    'gitlab_parent_id' => $gitLabResponse['parent_id']
                ]);
            }
            else{
                $corpusproject = CorpusProject::create([
                    'name' => request('corpusproject_name'),
                    'description' => request('corpusproject_description'),
                    'directory_path' => $filePath,
                ]);
            }



            $user = \Auth::user();
            $corpusproject->users()->save($user,['role_id' => 2]);
            $projectAdminRole = Role::findById(2);
            $user->roles()->sync($projectAdminRole);

        }

        return redirect()->route('corpusProject.index');
    }

    /**
     * @param CorpusProject $corpusproject
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(CorpusProject $corpusproject){
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();

        $user_roles = array();
        $corpusProjectUsers = $corpusproject->users()->get();
        $corpora = $corpusproject->corpora()->get();

        //dd($corpusProjectUsers);
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
            ->with('user_roles',$user_roles)
            ->with('corpora',$corpora)
            ->with('user',$user);
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function update(Request $request)
    {

        $status = "success";

        $result = array();
        $corpusproject = CorpusProject::findOrFail($request->input('projectid'));

        try{
            $corpusproject->update([
                "name" => $request->input('corpusproject_name'),
                "description" => $request->input('corpusproject_description')
            ]);
            $result['eloquent_response']  = "Project was successfully updated";
            $status = "success";
        }
        catch (\Exception $e) {
            $status = "error";
            $result['eloquent_response']  = "There was a problem updating the Project data. A message has been sent to the site administrator. Please try again later";
            //$e->getMessage();

        }


        $params = array(
            'name' => $request->input('corpusproject_name'),
            'path' => $corpusproject->gitlab_group_path,
            'description' => $request->input('corpusproject_description'),
            'visibility' => 'public'
        );

        try{
            $gitLabResponse = $this->GitLabService->updateGitLabGroup($corpusproject->gitlab_id,$params);
            if($status != 'error'){
                $status = "success";
                $result['gitlab_response']  = "Project was successfully versioned";
            }


        }
        catch (\Exception $e) {
            $status = "error";
            $result['gitlab_response'] =  "There was a problem versioning the Project data. A message has been sent to the site administrator. Please try again later";//$e->getMessage();
        }


        $response = array(
            'status' => $status,
            'message' => $result,
        );

        return Response::json($response);
    }

    /**
     * @param CorpusProject $corpusproject
     * @return $this
     */
    public function delete(CorpusProject $corpusproject)
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();
        return view('project.corpusproject.delete', compact('corpusproject'))
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

        $projectCorpora = $corpusproject->corpora();

        if(count($projectCorpora) > 0) {
            $corpusproject->corpora()->detach();
        }

        if(count($corpusproject->users()) > 0) {
            $corpusproject->users()->detach();
        }

        $gitLabGroupId = $corpusproject->gitlab_id;

        foreach($projectCorpora as $projectCorpus) {
            $this->GitLabService->unlinkProjectFromGroup($projectCorpus->gitlab_id,$gitLabGroupId);
        }

        $this->GitLabService->deleteGitLabGroup($gitLabGroupId);

        $corpusproject->delete();
        $CorpusProjects = CorpusProject::latest()->get();

        $this->GitRepoService->deleteProjectFileStructure($this->flysystem,$corpusproject->directory_path);

        return view('project.corpusproject.index', compact('CorpusProjects'))
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

        return view('project.corpusproject.assign_corpora')
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

        return redirect()->route('project.corpusProject.index');
    }

    public function invitations(){
        $isLoggedIn = \Auth::check();
        $loggedInUser = \Auth::user();
        return view('project.corpusproject.invite')
            ->with('isLoggedIn', $isLoggedIn)
            ->with('loggedInUser',$loggedInUser);
    }

    /**
     * @param CorpusProject $corpusproject
     * @return $this
     */
    public function assignUsers(CorpusProject $corpusproject) {
        $isLoggedIn = \Auth::check();
        $loggedInUser = \Auth::user();
        $users = User::latest()->get();
        $filteredList = array();

        foreach ($users as $user){
            if(!$corpusproject->users->contains($user)){
                array_push($filteredList,$user);
            }
        }

        $user_roles = array();
        $corpusProjectUsers = $corpusproject->users()->get();


        foreach ($corpusProjectUsers as $corpusProjectUser){
            $role = Role::find($corpusProjectUser->pivot->role_id);

            if(!isset($user_roles[$corpusProjectUser->pivot->role_id])){
                $user_roles[$corpusProjectUser->pivot->role_id] = array();
            }


            array_push($user_roles[$corpusProjectUser->pivot->role_id],$corpusProjectUser->id);
        }

        $roles = Role::all();
        $filteredRoles = array();
        foreach ($roles as $role){
            if($role->hasPermissionTo('Can create corpus project') && $role->super_user == 0){
                array_push($filteredRoles,$role);
            }
        }


        return view('project.corpusproject.assign_projectroles_to_user')
            ->with('corpusproject', $corpusproject)
            ->with('users', $users)
            ->with('roles', $filteredRoles)
            ->with('user_roles',$user_roles)
            ->with('isLoggedIn', $isLoggedIn)
            ->with('loggedInUser',$loggedInUser);


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

        return redirect()->route('project.corpusProject.index');
    }


    public function storeRelationsByProject(Request $request)
    {

        $input =$request ->all();
        $msg = "";
        if ($request->ajax()){
            $msg .= "<p>Assigned the following roles to user </p>";
            $role_users = $input['role_users'];
            $corpus_project = CorpusProject::find($input['project_id']);
            $msg .= "<ul>";
            foreach($role_users as $roleId => $user_data) {
                $role = Role::find($roleId);
                if($role){
                    $msg .= "<li>".$role->name."<ul>";
                    foreach($user_data as $userId) {
                        $user = User::find($userId);

                        if($user) {
                            $user->roles()->attach($role);
                            $msg .= "<li>".$user->name."</li>";
                            $corpus_project->users()->save($user,['role_id' => $roleId]);
                        }
                    }
                    $msg .= "</ul></li>";
                }
            }
            $msg .= "</ul>";
        }

        $response = array(
            'status' => 'success',
            'msg' => $msg,
        );

        return Response::json($response);
    }

    public function  destroyCorpusProjectUser($corpusProjectId,$userId){
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();

        $corpusProject = CorpusProject::find($corpusProjectId);
        $corpusProject->users()->detach($userId);

        $roles = Role::latest()->get();
        return view('admin.useradmin.roles.index', compact('roles'))
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }

    public function deleteRelationsByProject(Request $request){
        $input =$request ->all();
        $msg = "";
        if ($request->ajax()){

            $msg .= "<p>Removed the following user from the project: </p>";
            $userId = $input['userId'];
            $corpusProject = CorpusProject::find($input['projectId']);
            $user = User::find($userId);
            $corpusProject->users()->detach($userId);
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
}

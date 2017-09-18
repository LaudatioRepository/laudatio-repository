<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\User;
use App\CorpusProject;
use App\Corpus;
use Response;
use Log;
use DB;

class RoleController extends Controller
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
        $roles = Role::latest()->get();

        return view('admin.useradmin.roles.index', compact('roles'))
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
        return view('admin.useradmin.roles.create')
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
            'role_name' => 'required'
        ]);

        $role_super_user = 0;
        if(request('role_superuser') == 'on'){
            $role_super_user = 1;
        }


        $role_type = "";

        if(request('role_type') != null){
            $role_type = request('role_type');
        }

        Role::create([
            "name" => request('role_name'),
            "description" => request('role_description'),
            "role_type" => $role_type,
            'super_user' => $role_super_user
        ]);

        session()->flash('message', request('role_name').' was sucessfully created!');
        return redirect()->route('admin.roles.index');
    }


    /**
     * @param Role $role
     * @return $this
     */
    public function show(Role $role)
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();

        $project_user_roles = array();
        $projectuserdata = DB::table('corpus_project_user')->select("corpus_project_id",'user_id', "role_id")->where("role_id",$role->id)->get();

        foreach ($projectuserdata as $data){
            $user = User::find($data->user_id);
            $projectRole = Role::find($data->role_id);
            $corpus_project = CorpusProject::find($data->corpus_project_id);
            if(!isset($project_user_roles[$data->user_id])){
                $project_user_roles[$data->user_id] = array();
                $project_user_roles[$data->user_id]['user_name'] = $user->name;
                $project_user_roles[$data->user_id]['user_id'] = $user->id;
                $project_user_roles[$data->user_id]['role_data'] = array();
            }
            if(isset($user)){

                array_push($project_user_roles[$data->user_id]['role_data'],array(
                    "project_name" => $corpus_project->name,
                    "project_id" => $corpus_project->id
                ));
            }

        }

        $corpus_user_roles = array();
        $corpususerdata = DB::table('corpus_user')->select("corpus_id",'user_id', "role_id")->where("role_id",$role->id)->get();
        foreach ($corpususerdata as $cdata){
            $user = User::find($cdata->user_id);
            $corpusrole = Role::find($cdata->role_id);
            $corpus = Corpus::find($cdata->corpus_id);
            if(!isset($corpus_user_roles[$cdata->user_id])){
                $corpus_user_roles[$cdata->user_id] = array();
                $corpus_user_roles[$cdata->user_id]['user_name'] = $user->name;
                $corpus_user_roles[$cdata->user_id]['user_id'] = $user->id;
                $corpus_user_roles[$cdata->user_id]['role_data'] = array();
            }

            if(isset($user)){

                array_push($corpus_user_roles[$cdata->user_id]['role_data'],array(
                    "corpus_name" => $corpus->name,
                    "corpus_id" => $corpus->id,
                ));
            }

        }

        //dd("projectuserdata: ".print_r($project_user_roles,1)."\ncorpususerdata: ".print_r($corpus_user_roles,1));

        return view('admin.useradmin.roles.show', compact('role'))
            ->with('isLoggedIn', $isLoggedIn)
            ->with('project_user_roles', $project_user_roles)
            ->with('corpus_user_roles', $corpus_user_roles)
            ->with('user',$user);
    }

    /**
     * @param Role $role
     * @return $this
     */
    public function edit(Role $role)
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();
        return view('admin.useradmin.roles.edit', compact('role'))
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }

    /**
     * @param Request $request
     * @param Role $role
     * @return $this
     */
    public function update(Request $request, Role $role)
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();

        $role->update([
            'name' => $request->get('role_name'),
            'description' => $request->get('role_description'),
        ]);

        return view('admin.useradmin.roles.show', compact('role'))
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }

    /**
     * @param Role $role
     * @return $this
     */
    public function delete(Role $role)
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();
        return view('admin.useradmin.roles.delete', compact('role'))
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }

    /**
     * @param Request $request
     * @param Role $role
     * @return $this
     */
    public function destroy(Request $request, Role $role)
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();

        if(count($role->users()) > 0) {
            $role->users()->detach();
        }

        $role->delete();
        $roles = Role::latest()->get();
        return view('admin.useradmin.roles.index', compact('roles'))
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }

    /**
     * @return $this
     */
    public function assignUsers() {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();

        $usercollection = User::all();
        $users = array();
        $roles = Role::where('super_user',1)->get();
        foreach ($usercollection as $useritem){
            if(!$useritem->roles->contains(1)){
                array_push($users,$useritem);
            }
        }


        return view('admin.useradmin.roles.assign_superusers')
            ->with('roles', $roles)
            ->with('users', $users)
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }

    public function assignRolesToUsers($corpusProjectId, $userId) {
        $isLoggedIn = \Auth::check();
        $loggedInUser = \Auth::user();
        $corpusproject = CorpusProject::find($corpusProjectId);
        $user = User::find($userId);
        $roles = Role::where('super_user',0)->get();

        return view('admin.useradmin.roles.assign_roles_to_user')
            ->with('corpusProject', $corpusproject)
            ->with('user', $user)
            ->with('roles', $roles)
            ->with('isLoggedIn', $isLoggedIn)
            ->with('loggedInUser',$loggedInUser);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function storeRelations(Request $request)
    {

        $input =$request ->all();
        $msg = "";
        if ($request->ajax()){
            $msg .= "<p>Assigned the following users to the following roles</p>";
            $role_users = $input['role_users'];
            $msg .= "<ul>";
            foreach($role_users as $roleId => $user_data) {
                $role = Role::find($roleId);
                if($role){
                    $msg .= "<li>".$role->name."<ul>";

                    foreach($user_data as $userId) {
                        $user = User::find($userId);
                        if($user) {
                            $msg .= "<li>".$user->name."</li>";
                            $role->users()->attach($user);
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

    public function removeRoleFromUser($roleId, $userId){
        $isLoggedIn = \Auth::check();
        $loggedInUser = \Auth::user();
        $role = Role::find($roleId);
        $user = User::find($userId);
        $role->users()->detach($user);
        $roles = Role::latest()->get();
        session()->flash('message', $role->name.' was sucessfully revoked for user '.$user->name);

        return view('admin.useradmin.roles.index', compact('roles'))
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$loggedInUser);
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
}

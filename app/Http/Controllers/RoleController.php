<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Role;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Session;
use Auth;
use App\User;
use App\CorpusProject;
use App\Corpus;
use Response;
use Log;
use DB;

class RoleController extends Controller
{

    public function __construct() {
        //$this->middleware(['auth', 'isAdmin']);//isAdmin middleware lets only users with a //specific permission permission to access these resources
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
        $roles = Role::all();

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
        $permissions = Permission::all();

        return view('admin.useradmin.roles.create',['permissions' => $permissions])
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
            'name' => 'required',
            'permissions' => 'required'
        ]);


        $role_super_user = 0;
        if(request('role_superuser') == 'on'){
            $role_super_user = 1;
        }

        $role_type = "";

        if(request('role_type') != null){
            $role_type = request('role_type');
        }

        $role = new Role();
        $role->name = request('name');
        $role->description = request('role_description');
        $role->role_type = $role_type;
        $role->super_user = $role_super_user;

        $role->save();
        $permissions = $request['permissions'];

        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail();
            //Fetch the newly created role and assign permission
            $role = Role::where('name', '=', request('name'))->first();
            $role->givePermissionTo($p);
        }

        return redirect()->route('admin.roles.index')
            ->with('flash_message',
                'Role'. $role->name.' added!');
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
        $permissions = Permission::all();
        return view('admin.useradmin.roles.edit', compact('role','permissions'))
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
            'name' => $request->get('name'),
            'description' => $request->get('description'),
        ]);


        $input = $request->except(['permissions']);
        $permissions = $request['permissions'];
        $role->fill($input)->save();

        $p_all = Permission::all();//Get all permissions

        foreach ($p_all as $p) {
            $role->revokePermissionTo($p); //Remove all permissions associated with role
        }

        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail(); //Get corresponding form //permission in db
            $role->givePermissionTo($p);  //Assign permission to role
        }

        return redirect()->route('admin.roles.index')
            ->with('flash_message',
                'Role'. $role->name.' updated!')
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
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();

        $role = Role::findOrFail($id);

        /*
        if(count($role->users()) > 0) {
            $role->users()->detach();
        }
        */

        $role->delete();
        return redirect()->route('admin.roles.index')
            ->with('flash_message',
                'Role deleted!')
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
        $role = Role::where('super_user',1)->get();
        foreach ($usercollection as $useritem){
            if(!$useritem->roles->contains($role[0]->id)){
                array_push($users,$useritem);
            }
        }

        return view('admin.useradmin.roles.assign_superusers')
            ->with('roles', $role)
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
        Log::info("INPÖT: ".print_r($input, 1));
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
                            //$role->users()->attach($user);
                            $user->roles()->sync($role);
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
                            $corpus_project->users()->save($user,['role_id' => $roleId,'project_id' => $corpus_project->id, 'corpus_id' => 0]);

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

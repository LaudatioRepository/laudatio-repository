<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\User;
use App\CorpusProject;
use Response;
use Log;

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

        Role::create([
            "name" => request('role_name'),
            "description" => request('role_description'),
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
        return view('admin.useradmin.roles.show', compact('role'))
            ->with('isLoggedIn', $isLoggedIn)
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

        $users = User::all();
        $roles = Role::latest()->get();

        return view('admin.useradmin.roles.assign_users')
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

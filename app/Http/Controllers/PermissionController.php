<?php

namespace App\Http\Controllers;

//use App\Permission;
use Illuminate\Http\Request;
//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'isAdmin']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
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
        $permissions = Permission::all(); //Get all permissions

        return view('admin.permissions.index')
            ->with('permissions', $permissions)
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
        $roles = Role::get(); //Get all roles
        return view('admin.permissions.create')
            ->with('roles', $roles)
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
        $this->validate($request, [
            'name'=>'required|max:40',
        ]);

        $name = $request['name'];
        $description = $request['description'];
        $permission = new Permission();
        $permission->name = $name;
        $permission->description = $description;

        $roles = $request['roles'];

        $permission->save();

        if (!empty($request['roles'])) { //If one or more role is selected
            foreach ($roles as $role) {
                $r = Role::where('id', '=', $role)->firstOrFail(); //Match input role to db record

                $permission = Permission::where('name', '=', $name)->first(); //Match input //permission to db record
                $r->givePermissionTo($permission);
            }
        }

        return redirect()->route('permissions.index')
            ->with('flash_message',
                'Permission'. $permission->name.' added!');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function show($id)
    {
        return redirect('admin.permissions');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();
        $permission = Permission::findOrFail($id);

        return view('admin.permissions.edit', compact('permission'))
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $this->validate($request, [
            'name'=>'required|max:40',
        ]);
        $input = $request->all();
        $permission->fill($input)->save();

        return redirect()->route('permissions.index')
            ->with('flash_message',
                'Permission'. $permission->name.' updated!');

    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        //Make it impossible to delete this specific permission
        if ($permission->name == "Administer roles & permissions") {
            return redirect()->route('admin.permissions.index')
                ->with('flash_message',
                    'Cannot delete this Permission!');
        }

        $permission->delete();

        return redirect()->route('permissions.index')
            ->with('flash_message',
                'Permission deleted!');

    }
}

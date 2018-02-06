<?php
/**
 * Created by PhpStorm.
 * User: rolfguescini
 * Date: 01.02.18
 * Time: 11:24
 */

namespace App\Http\Controllers;


class AdminController extends Controller
{

    public function __construct() {
        $this->middleware(['auth', 'isAdmin']);//isAdmin middleware lets only users with a //specific permission permission to access these resources
    }

    public function index()
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();
        return view('admin.adminIndex')
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }
}
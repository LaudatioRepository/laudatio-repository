<?php

namespace App\Http\Controllers;

class IndexController extends Controller
{
    /**
     * IndexController constructor.
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    public function admin()
    {
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();
        return view('admin.adminIndex')
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    /**
     * @return $this
     */
    public function index(){
        $isLoggedIn = \Auth::check();
        $user = \Auth::user();
        return view('admin.dashboard.index')
            ->with('isLoggedIn', $isLoggedIn)
            ->with('user',$user);
    }
}

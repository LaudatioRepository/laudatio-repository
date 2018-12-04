<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\Controller as Controller;
class LaudatioRegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    /**
     * RegisterController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function registerUser(){
        return view('auth.registeruser');
    }


    public function registerConsent(Request $request){
        $validated = $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'gitlab_ssh_pubkey' => 'required|string|unique:users',
            'affiliation' => 'required|string|max:255',
            'laudatiopassword' => 'required|between:8,255|confirmed'
        ]);

        $formArray = array(
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'gitlab_ssh_pubkey' => $request->input('gitlab_ssh_pubkey'),
            'gitlab-use-check' => 1,
            'affiliation' => $request->input('affiliation'),
            'laudatiopassword' => $request->input('laudatiopassword')
        );

        $request->session()->put($request->input('email'), $formArray);
        return view('auth.registerconsent')->with("email",$request->input('email'));
    }

    public function registerForm(){
        return view('auth.registerform');
    }

    public function storeRegister(Request $request) {
        $data = $request->session()->get($request->input('email'));
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'gitlab_ssh_pubkey' => $data['gitlab_ssh_pubkey'],
            'gitlab-use-agree' => $data['gitlab-use-check'],
            'terms-of-use-agree' => 1,
            'affiliation' => $data['affiliation'],
            'password' => bcrypt($data['laudatiopassword']),
        ]);
        return redirect('admin');
    }
}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'gitlabemail' => 'required|string|email|max:255|unique:users',
            'ssh-key' => 'required|string|max:255',
            'laudatio-password' => 'required|string|min:6|confirmed',
            'affiliation' => 'required|string|max:255'
        ]);
    }

    public function registerConsent(Request $request){
        $formArray = array(
            'name' => $request->input('name'),
            'gitlabemail' => $request->input('gitlabemail'),
            'ssh-key' => $request->input('ssh-key'),
            'gitlab-use-check' => 1,
            'affiliation' => $request->input('affiliation'),
            'laudatio-password' => $request->input('laudatio-password')
        );
        Log::info("GOT DATA: ".print_r($formArray, 1));
        return view('auth.registerconsent')->with("formdata",$formArray);
    }

    public function registerForm(){
        return view('auth.registerform');
    }

}


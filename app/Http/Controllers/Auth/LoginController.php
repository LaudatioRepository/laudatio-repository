<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use Log;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function doLogin(Request $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $redirect = '/dashboard';
            if(Auth::user()->hasPermissionTo('Administer the application')){
                $redirect = '/corpusprojects';
            }
            else{
                $redirect = '/dashboard';
            }
            $response = array('success' => true, 'redirect' => $redirect);

            return response()->json($response);
        }
        else{
            $response = array('success' => false, 'message' => 'Invalid login credentials');
            return response()->json($response);
        }
    }
}

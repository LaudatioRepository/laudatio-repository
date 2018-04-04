<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use Illuminate\Support\Facades\Redirect;
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

    public function doRegister(){}

    public function doLogin(Request $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $redirect = '/dashboard';
            /*
            if(Auth::user()->hasPermissionTo('Administer the application')){
                $redirect = '/corpusprojects';
            }
            else{
                $redirect = '/dashboard';
            }
*/
            $intended = $request->session()->get('url.intended');
            $urlArray = explode("/",$intended);
            $redirect = '/'.join('/',array_slice($urlArray, 3));

            $response = array('success' => true, 'redirect' => $redirect);
            return response()->json($response);
        }
        else{
            $response = array('success' => false, 'message' => 'Invalid login credentials');
            return response()->json($response);
        }
    }

    public function signin(Request $request){
        return view('/auth.signin');
    }
}

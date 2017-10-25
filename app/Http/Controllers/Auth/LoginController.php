<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\User;
//use Auth;
use App\OauthDriver;
use App\OauthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Adldap\Laravel\Facades\Adldap;
use Log;

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
    protected $redirectTo = '/admin';

    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username() {
        return config('adldap_auth.usernames.eloquent');
    }


    protected function validateLogin(Request $request) {
        $this->validate($request, [
            $this->username() => 'required|string|regex:/^\w+$/',
            'password' => 'required|string',
        ]);
    }

    protected function attemptLogin(Request $request) {
        $credentials = $request->only($this->username(), 'password');
        $username = $credentials[$this->username()];
        $password = $credentials['password'];

        $user_format = env('ADLDAP_USER_FORMAT', 'cn=%s,'.env('ADLDAP_BASEDN', ''));
        $userdn = sprintf($user_format, $username);

        if(Adldap::auth()->attempt($userdn, $password, $bindAsUser = false)) {

            // the user exists in the LDAP server, with the provided password
            $user = User::where($this->username(), $username) -> first();
            Log::info("passed: : ".print_r($user,1));

            if ( !$user ) {
                // the user doesn't exist in the local database
                $user = new \App\User();
                $user->name = $username;
                $user->username = $username;
                $user->password = '';
            }
            // by logging the user we create the session so there is no need to login again (in the configured time)
            $this->guard()->login($user, true);
            return true;
        }
        // the user doesn't exist in the LDAP server or the password is wrong
        return false;
    }

    public function socialLogin($social){
        return Socialite::driver($social)->redirect();
    }

    public function handleProviderCallback($social){
        $userSocial = Socialite::driver($social)->user();

        $user_by_email = User::where(['email' => $userSocial->getEmail()])->first();
        $user_by_id = OAuthUser::where('oauth_id', $userSocial->getId())->first();


        if(null == OAuthDriver::where('name', $social)->first()){
            $oauthDriver = \App\OAuthDriver::firstOrNew([
                'name' => $social,
                'active' => 1,
            ]);
            $oauthDriver->save();
        }

        if ($user_by_email) {
            $user = $user_by_email;
        } else if ($user_by_id) {
            $user = $user_by_id;
        } else {
            // Create User
            $user = User::create([
                'name' => $userSocial->getName(),
                'email' => $userSocial->getEmail(),
                'oauth_id' => $userSocial->getId(),
                'avatar' => $userSocial->avatar
            ]);

            $oauthUser = \App\OAuthUser::firstOrNew([
                'user_id' => $user->id,
                'oauth_id' => $userSocial->getId(),
            ]);


            $oauthUser->user_id = $user->id;
            $oauthUser->oauth_id = $userSocial->getId();
            $oauthUser->access_token = $userSocial->token;
            $oauthUser->refresh_token = $userSocial->refreshToken;
            $oauthUser->oauth_driver_id = OAuthDriver::where('name', $social)->first()->id;
            $oauthUser->save();
        }




        if($user){
            Auth::login($user);
            return redirect()->route('admin');
        }
        else{
            return view('auth.register',['name' => $userSocial->getName(), 'email' => $userSocial->getEmail()]);
        }
    }
}

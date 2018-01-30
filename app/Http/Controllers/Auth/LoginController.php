<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\User;
use Auth;
use App\OauthDriver;
use App\OauthUser;

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

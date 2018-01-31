<?php
/**
 * Created by PhpStorm.
 * User: rolfguescini
 * Date: 31.01.18
 * Time: 16:51
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
class ProjectMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = User::all()->count();
        if (!($user == 1)) {
            if (!Auth::user()->hasPermissionTo('Work period')) //If user does //not have this permission
            {
                abort('401');
            }
        }

        return $next($request);
    }
}
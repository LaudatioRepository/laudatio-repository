<?php
/**
 * Created by PhpStorm.
 * User: rolfguescini
 * Date: 19.10.17
 * Time: 11:37
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Laudatio\GitLab\GitLabService;

class GitLabServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton('App\Custom\GitLabInterface', function ($app){
            return new GitLabService();
        });
    }
}

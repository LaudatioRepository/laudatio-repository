<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Laudatio\GitLab\GitRepoService;

class GitRepoProvider extends ServiceProvider
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
        $this->app->singleton('App\Custom\GitRepoInterface', function ($app){
            $instance = $this->app->make('App\Laudatio\Utils\LaudatioUtilService');
            return new GitRepoService($instance);
        });
    }
}

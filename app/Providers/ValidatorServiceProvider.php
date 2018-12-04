<?php
/**
 * Created by PhpStorm.
 * User: rolfguescini
 * Date: 09.10.18
 * Time: 09:40
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Laudatio\Utils\ValidatorService;

class ValidatorServiceProvider extends ServiceProvider
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
        $this->app->singleton('App\Custom\ValidatorInterface', function ($app){
            $instance = $this->app->make('App\Laudatio\Utils\ValidatorService');
            return new ValidatorService($instance);
        });
    }
}

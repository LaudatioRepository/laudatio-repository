<?php
/**
 * Created by PhpStorm.
 * User: rolfguescini
 * Date: 19.10.17
 * Time: 11:37
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Laudatio\Utils\LaudatioUtilService;
class LaudatioUtilsServiceProvider extends ServiceProvider
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
        $this->app->singleton('App\Custom\LaudatioUtilsInterface', function ($app){
            return new LaudatioUtilService();
        });
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Laudatio\Elasticsearch\ElasticService;

class ElasticServiceProvider extends ServiceProvider
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
        $this->app->singleton('App\Custom\ElasticsearchInterface', function ($app){
            return new ElasticService();
        });
    }
}

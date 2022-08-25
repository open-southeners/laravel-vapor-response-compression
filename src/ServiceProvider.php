<?php

namespace OpenSoutheners\LaravelVaporResponseCompression;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/response-compression.php' => config_path('response-compression.php'),
            ], 'response-compression');
        }
    }
}

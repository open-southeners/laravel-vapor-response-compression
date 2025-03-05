<?php

namespace OpenSoutheners\LaravelResponseCompression\Tests;

use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
        $app['config']->set(
            'response-compression',
            include_once __DIR__.'/../config/response-compression.php'
        );
    }
}

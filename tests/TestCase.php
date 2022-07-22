<?php

namespace OpenSoutheners\LaravelVaporResponseCompression\Tests;

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
        $app['config']->set('vapor', [
            'response_compression' => [
                'threshold' => 10000,
                'level' => [
                    'br' => 10,
                    'gzip' => 9,
                    'deflate' => 9,
                ],
            ],
        ]);
    }
}

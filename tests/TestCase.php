<?php

namespace OpenSoutheners\PhpPackage\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use OpenSoutheners\PhpPackage\ServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }
}

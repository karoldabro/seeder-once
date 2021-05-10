<?php

namespace Kdabrow\SeederOnce\Tests;

use Kdabrow\SeederOnce\Providers\SeederOnceProvider;
use Orchestra\Testbench\TestCase as TestbenchTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestCase extends TestbenchTestCase
{
    /**
     * Get package providers.  At a minimum this is the package being tested, but also
     * would include packages upon which our package depends, e.g. Cartalyst/Sentry
     * In a normal app environment these would be added to the 'providers' array in
     * the config/app.php file.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            SeederOnceProvider::class,
        ];
    }
}

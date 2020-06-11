<?php

namespace Lionix\LaravelPostmanRoutes\Tests;

use Illuminate\Support\Str;
use Lionix\LaravelPostmanRoutes\ServiceProvider;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

class BaseTestCase extends TestbenchTestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $app['config']->set('postman-routes.api-key', Str::random(25));
    }
}

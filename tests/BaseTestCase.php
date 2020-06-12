<?php

namespace Lionix\LaravelPostmanRoutes\Tests;

use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Illuminate\Support\Str;
use Lionix\LaravelPostmanRoutes\ServiceProvider;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

class BaseTestCase extends TestbenchTestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app->useEnvironmentPath(dirname(__DIR__, 1));

        $app->bootstrapWith([LoadEnvironmentVariables::class]);
        
        parent::getEnvironmentSetUp($app);
    }

    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $app['config']->set('postman-routes.api-key', env('POSTMAN_API_KEY'));
    }
}

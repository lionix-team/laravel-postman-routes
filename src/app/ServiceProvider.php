<?php

namespace Lionix\LaravelPostmanRoutes;

use Illuminate\Support\ServiceProvider as Provider;
use Lionix\LaravelPostmanRoutes\Commands\PostmanRoutesCreateApiCommand;
use Lionix\LaravelPostmanRoutes\Commands\PostmanRoutesSyncCommand;
use Lionix\LaravelPostmanRoutes\Contracts\Services\PostmanServiceInterface;
use Lionix\LaravelPostmanRoutes\Services\PostmanService;

class ServiceProvider extends Provider
{
    public function register()
    {
        $this->app->bind(
            PostmanServiceInterface::class,
            function () {
                return new PostmanService(
                    config('postman-routes.api-key', ''),
                );
            }
        );
    }

    public function boot()
    {
        $this->publishes([
            dirname(__DIR__, 1) . '/config/postman-routes.php' => config_path('postman-routes.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                //
            ]);
        }
    }
}

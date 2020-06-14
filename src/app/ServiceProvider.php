<?php

namespace Lionix\LaravelPostmanRoutes;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use Illuminate\Support\ServiceProvider as Provider;
use Lionix\LaravelPostmanRoutes\Commands\PostmanRoutesMakeCollectionCommand;
use Lionix\LaravelPostmanRoutes\Contracts\Services\PostmanServiceInterface;
use Lionix\LaravelPostmanRoutes\Contracts\Utils\RouteExtractorInterface;
use Lionix\LaravelPostmanRoutes\Contracts\Utils\RouteResolverInterface;
use Lionix\LaravelPostmanRoutes\Services\PostmanService;
use Lionix\LaravelPostmanRoutes\Utils\BaseRouteExtractor;
use Lionix\LaravelPostmanRoutes\Utils\BaseRouteResolver;

class ServiceProvider extends Provider
{
    public function register()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/config/postman-routes.php', 'postman-routes'
        );

        $this->app->bind(
            PostmanServiceInterface::class,
            PostmanService::class
        );

        $this->app->bind(
            RouteExtractorInterface::class,
            BaseRouteExtractor::class
        );

        $this->app->bind(
            RouteResolverInterface::class,
            BaseRouteResolver::class
        );

        $this->app->when(PostmanService::class)
            ->needs('$token')
            ->give(function () {
                return config('postman-routes.api-key', '');
            });

        $this->app->when(PostmanService::class)
            ->needs(HandlerStack::class)
            ->give(function () {
                return HandlerStack::create(new CurlHandler());
            });
    }

    public function boot()
    {
        $this->publishes([
            dirname(__DIR__, 1) . '/config/postman-routes.php' => config_path('postman-routes.php'),
        ], 'laravel-postman-routes-config');

        $this->publishes([
            dirname(__DIR__, 1) . '/lang' => resource_path('lang/vendor/postman-routes'),
        ], 'laravel-postman-routes-lang');

        $this->loadTranslationsFrom(dirname(__DIR__, 1) . '/lang', 'postman-routes');

        if ($this->app->runningInConsole()) {
            $this->commands([
                PostmanRoutesMakeCollectionCommand::class,
            ]);
        }
    }
}

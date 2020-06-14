<?php

namespace Lionix\LaravelPostmanRoutes\Tests\Traits;

use GuzzleHttp\HandlerStack;
use Illuminate\Support\Str;
use Lionix\LaravelPostmanRoutes\DataMappers\CollectionEntityDataMapper;
use Lionix\LaravelPostmanRoutes\DataMappers\RouteEntityDataMapper;
use Lionix\LaravelPostmanRoutes\Services\PostmanService;

trait MocksPostmanService
{
    public function mockPostmanService(HandlerStack $handlerStack): PostmanService
    {
        return new PostmanService(
            Str::random(),
            $handlerStack,
            app()->make(CollectionEntityDataMapper::class),
            app()->make(RouteEntityDataMapper::class),
        );
    }
}

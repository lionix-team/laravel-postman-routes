<?php

namespace Lionix\LaravelPostmanRoutes\DataMappers;

use GuzzleHttp\Psr7\Response;
use Illuminate\Routing\Route;
use Lionix\LaravelPostmanRoutes\Entities\CollectionEntity;
use Lionix\LaravelPostmanRoutes\Entities\RouteEntity;

class RouteEntityDataMapper
{
    public function fromIlluminateRoute(Route $route): RouteEntity
    {
        return new RouteEntity(
            $route->getName(),
            $route->methods()[0],
            url($route->uri()),
            []
        );
    }

    public function toArray(RouteEntity $entity): array
    {
        return [
            'name' => $entity->getName(),
            'request' => [
                'url' => $entity->getUrl(),
                'method' => $entity->getMethod(),
                'body' => [
                    'mode' => 'raw',
                    'raw' => json_encode($entity->getBody()),
                ],
            ],
        ];
    }
}

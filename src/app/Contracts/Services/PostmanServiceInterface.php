<?php

namespace Lionix\LaravelPostmanRoutes\Contracts\Services;

use GuzzleHttp\HandlerStack;
use Lionix\LaravelPostmanRoutes\DataMappers\CollectionEntityDataMapper;
use Lionix\LaravelPostmanRoutes\DataMappers\RouteEntityDataMapper;
use Lionix\LaravelPostmanRoutes\Entities\CollectionEntity;

interface PostmanServiceInterface
{
    public function __construct(
        string $token,
        HandlerStack $handlerStack,
        CollectionEntityDataMapper $collectionEntityDataMapper,
        RouteEntityDataMapper $routeEntityDataMapper
    );

    public function useToken(string $token): PostmanServiceInterface;

    public function createCollection(string $collectionName, array $routes): CollectionEntity;
}

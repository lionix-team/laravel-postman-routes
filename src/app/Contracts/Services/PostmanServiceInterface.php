<?php

namespace Lionix\LaravelPostmanRoutes\Contracts\Services;

use Illuminate\Support\Collection;
use Lionix\LaravelPostmanRoutes\Entities\CollectionEntity;

interface PostmanServiceInterface
{
    public function __construct(string $token);

    public function createCollection(string $collectionName, Collection $routes): CollectionEntity;
}

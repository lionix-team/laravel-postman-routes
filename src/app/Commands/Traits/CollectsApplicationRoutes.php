<?php

namespace Lionix\LaravelPostmanRoutes\Commands\Traits;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Lionix\LaravelPostmanRoutes\DataMappers\RouteEntityDataMapper;

trait CollectsApplicationRoutes
{
    public function collectApplicationRoutes(
        RouteEntityDataMapper $mapper,
        string $filter = null
    ) {
        $collection = collect(Route::getRoutes())
            ->map([$mapper, 'fromRoute']);

        if (!is_null($filter)) {
            $collection = $collection->filter(function ($route) use ($filter) {
                return Str::is($filter, $route->getName());
            });
        }

        return $collection;
    }
}

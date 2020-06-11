<?php

namespace Lionix\LaravelPostmanRoutes\Tests\Traits;

use Faker\Factory as FakerFactory;
use Illuminate\Support\Collection;

trait GeneratesRoutes
{
    public function generateRoutes(int $from = 10, int $to = 100): Collection
    {
        $fakerFactory = FakerFactory::create();

        $routes = collect();

        for ($i = 0; $i < $fakerFactory->numberBetween($from, $to); $i++) {
            $routeUri = $fakerFactory->unique()->slug;
            $routes->push(
                $this->app['router']
                    ->get($routeUri, function () {
                        return 1;
                    })
            );
        }

        return $routes;
    }
}

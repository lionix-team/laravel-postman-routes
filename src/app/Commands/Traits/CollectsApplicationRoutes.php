<?php

namespace Lionix\LaravelPostmanRoutes\Commands\Traits;

use Illuminate\Support\Collection;

trait CollectsApplicationRoutes
{
    public function collectApplicationRoutes(string $filter): Collection
    {
        return collect([
            [
                'name' => config('app.name'),
                'request' => [
                    'url' => config('app.url'),
                    'method' => 'GET',
                ],
            ],
        ]);
    }
}

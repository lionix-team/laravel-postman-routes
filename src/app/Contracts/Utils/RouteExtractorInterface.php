<?php

namespace Lionix\LaravelPostmanRoutes\Contracts\Utils;

use Illuminate\Routing\Route;

interface RouteExtractorInterface
{
    public function extractRequestBody(Route $route): array;
}

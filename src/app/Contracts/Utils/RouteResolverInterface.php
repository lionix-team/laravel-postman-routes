<?php

namespace Lionix\LaravelPostmanRoutes\Contracts\Utils;

use Illuminate\Routing\Route;

interface RouteResolverInterface
{
    public function resolveName(Route $route): string;

    public function resolveMethod(Route $route): string;

    public function resolveUrl(Route $route): string;
}

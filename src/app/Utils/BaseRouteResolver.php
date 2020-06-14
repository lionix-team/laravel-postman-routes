<?php

namespace Lionix\LaravelPostmanRoutes\Utils;

use Illuminate\Routing\Route;
use Lionix\LaravelPostmanRoutes\Contracts\Utils\RouteResolverInterface;

class BaseRouteResolver implements RouteResolverInterface
{
    public function resolveName(Route $route): string
    {
        return $route->getName();
    }

    public function resolveMethod(Route $route): string
    {
        return $route->methods()[0];
    }

    public function resolveUrl(Route $route): string
    {
        return url($route->uri());
    }
}

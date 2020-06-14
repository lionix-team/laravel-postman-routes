<?php

namespace Lionix\LaravelPostmanRoutes\Utils;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Lionix\LaravelPostmanRoutes\Contracts\Utils\RouteExtractorInterface;
use ReflectionFunction;
use ReflectionNamedType;
use ReflectionObject;

class BaseRouteExtractor implements RouteExtractorInterface
{
    protected function extractAction(Route $route)
    {
        if ($route->getAction('controller')) {
            $controllerRef = new ReflectionObject($route->getController());

            return $controllerRef->getMethod($route->getActionMethod());
        }

        return new ReflectionFunction($route->getAction('uses'));
    }

    protected function extractRequest(Route $route)
    {
        $action = $this->extractAction($route);

        foreach ($action->getParameters() as $parameter) {
            $parameterType = $parameter->getType();
            if (
                $parameterType instanceof ReflectionNamedType
                && is_subclass_of($parameterType->getName(), Request::class)
            ) {
                return $parameterType->getName()::capture();
            }
        }

        return null;
    }

    public function extractRequestBody(Route $route): array
    {
        $request = $this->extractRequest($route);

        if ($request) {
            return collect($request->rules())
                ->filter(function ($rules) {
                    return is_string($rules) || is_array($rules);
                })
                ->map(function ($rules) {
                    return is_string($rules) ? $rules : implode('|', $rules);
                })
                ->toArray();
        }

        return [];
    }
}

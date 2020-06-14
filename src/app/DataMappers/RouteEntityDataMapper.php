<?php

namespace Lionix\LaravelPostmanRoutes\DataMappers;

use Illuminate\Routing\Route;
use Lionix\LaravelPostmanRoutes\Contracts\Utils\RouteExtractorInterface;
use Lionix\LaravelPostmanRoutes\Contracts\Utils\RouteResolverInterface;
use Lionix\LaravelPostmanRoutes\Entities\RouteEntity;

class RouteEntityDataMapper
{
    protected $extractor;

    protected $resolver;

    public function __construct(
        RouteExtractorInterface $extractor,
        RouteResolverInterface $resolver
    ) {
        $this->extractor = $extractor;
        $this->resolver = $resolver;
    }

    public function fromRoute(Route $route): RouteEntity
    {
        return new RouteEntity(
            $this->resolver->resolveName($route),
            $this->resolver->resolveMethod($route),
            $this->resolver->resolveUrl($route),
            $this->extractor->extractRequestBody($route)
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

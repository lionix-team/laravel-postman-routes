<?php

namespace Lionix\LaravelPostmanRoutes\Services;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Middleware;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use Lionix\LaravelPostmanRoutes\Contracts\Services\PostmanServiceInterface;
use Lionix\LaravelPostmanRoutes\DataMappers\CollectionEntityDataMapper;
use Lionix\LaravelPostmanRoutes\DataMappers\RouteEntityDataMapper;
use Lionix\LaravelPostmanRoutes\Entities\CollectionEntity;
use Lionix\LaravelPostmanRoutes\Exceptions\PostmanApiKeyMissingException;
use Psr\Http\Message\RequestInterface;

class PostmanService implements PostmanServiceInterface
{
    /**
     * @var string
     */
    const COLLECTION_SCHEMA = 'https://schema.getpostman.com/json/collection/v2.1.0/collection.json';

    /**
     * @var string
     */
    protected $token;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var \GuzzleHttp\HandlerStack
     */
    protected $handlerStack;

    /**
     * @var \Lionix\LaravelPostmanRoutes\DataMappers\CollectionEntityDataMapper
     */
    protected $collectionEntityDataMapper;

    /**
     * @var \Lionix\LaravelPostmanRoutes\DataMappers\RouteEntityDataMapper
     */
    protected $routeEntityDataMapper;

    public function __construct(
        string $token,
        HandlerStack $handlerStack,
        CollectionEntityDataMapper $collectionEntityDataMapper,
        RouteEntityDataMapper $routeEntityDataMapper
    ) {
        if (!$token) {
            throw new PostmanApiKeyMissingException("Postman API key is missing!");
        }

        $this->token = $token;
        $this->handlerStack = $handlerStack;
        $this->collectionEntityDataMapper = $collectionEntityDataMapper;
        $this->routeEntityDataMapper = $routeEntityDataMapper;

        $this->handlerStack->push(
            Middleware::mapRequest(function (RequestInterface $request) {
                return $request->withHeader('X-Api-Key', $this->token);
            })
        );

        $this->client = new Client([
            'handler' => $this->handlerStack,
        ]);
    }

    public function useToken(string $token): PostmanServiceInterface
    {
        return new static(
            $token,
            $this->handlerStack,
            $this->collectionEntityDataMapper,
            $this->routeEntityDataMapper
        );
    }

    public function createCollection(string $collectionName, array $routes): CollectionEntity
    {
        $response = $this->client->request(
            'POST',
            'https://api.getpostman.com/collections',
            [
                'json' => [
                    'collection' => [
                        'info' => [
                            'name' => $collectionName,
                            'schema' => self::COLLECTION_SCHEMA,
                        ],
                        'item' => array_map([$this->routeEntityDataMapper, 'toArray'], $routes),
                    ],
                ],
            ]
        );

        return $this->collectionEntityDataMapper->fromResponse($response);
    }
}

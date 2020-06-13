<?php

namespace Lionix\LaravelPostmanRoutes\Services;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Middleware;
use Illuminate\Support\Collection;
use Lionix\LaravelPostmanRoutes\Contracts\Services\PostmanServiceInterface;
use Lionix\LaravelPostmanRoutes\Entities\CollectionEntity;
use Lionix\LaravelPostmanRoutes\Exceptions\PostmanApiKeyMissingException;
use Lionix\LaravelPostmanRoutes\Services\Traits\MapsResponseToEntities;
use Psr\Http\Message\RequestInterface;

class PostmanService implements PostmanServiceInterface
{
    use MapsResponseToEntities;

    const COLLECTION_SCHEMA = 'https://schema.getpostman.com/json/collection/v2.1.0/collection.json';

    /**
     * @var string
     */
    protected $token;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    public function __construct(string $token)
    {
        if (!$token) {
            throw new PostmanApiKeyMissingException("Postman API key is not set!");
        }

        $this->token = $token;

        $stack = HandlerStack::create(new CurlHandler());

        $stack->push(Middleware::mapRequest(function (RequestInterface $request) {
            return $request->withHeader('X-Api-Key', $this->token);
        }));

        $this->client = new Client([
            'handler' => $stack,
        ]);
    }

    public function createCollection(string $collectionName, Collection $routes): CollectionEntity
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
                        'item' => $routes->toArray(),
                    ],
                ],
            ]
        );

        return $this->mapResponseToCollectionEntity($response);
    }
}

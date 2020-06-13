<?php

namespace Lionix\LaravelPostmanRoutes\Services\Traits;

use GuzzleHttp\Psr7\Response;
use Lionix\LaravelPostmanRoutes\Entities\CollectionEntity;
use Lionix\LaravelPostmanRoutes\Exceptions\PostmanApiUnexpectedResponseException;
use stdClass;
use Throwable;

trait MapsResponseToEntities
{
    protected function parseResponseBody(Response $response): stdClass
    {
        $body = json_decode($response->getBody());

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new PostmanApiUnexpectedResponseException(
                "Failed parsing the response: " . json_last_error_msg()
            );
        }

        return $body;
    }

    protected function mapResponseToCollectionEntity(Response $response): CollectionEntity
    {
        $body = $this->parseResponseBody($response);

        try {
            $collection = CollectionEntity::fromStdClass($body->collection);
        } catch (Throwable $th) {
            throw new PostmanApiUnexpectedResponseException(
                "Could not map the response to collection entity!"
            );
        }

        return $collection;
    }
}

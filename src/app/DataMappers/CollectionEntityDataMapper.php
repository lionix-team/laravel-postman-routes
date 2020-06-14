<?php

namespace Lionix\LaravelPostmanRoutes\DataMappers;

use GuzzleHttp\Psr7\Response;
use Lionix\LaravelPostmanRoutes\Entities\CollectionEntity;
use Lionix\LaravelPostmanRoutes\Exceptions\PostmanApiUnexpectedResponseException;

class CollectionEntityDataMapper
{
    public function fromResponse(Response $response): CollectionEntity
    {
        $body = json_decode($response->getBody());

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new PostmanApiUnexpectedResponseException(
                "Failed parsing the response: " . json_last_error_msg()
            );
        }

        try {
            $collection = new CollectionEntity(
                $body->collection->id,
                $body->collection->uid,
                $body->collection->name
            );
        } catch (Throwable $th) {
            throw new PostmanApiUnexpectedResponseException(
                "Could not map the response to collection entity"
            );
        }

        return $collection;
    }
}

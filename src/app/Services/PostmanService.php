<?php

namespace Lionix\LaravelPostmanRoutes\Services;

use Lionix\LaravelPostmanRoutes\Contracts\Services\PostmanServiceInterface;
use Lionix\LaravelPostmanRoutes\Exceptions\PostmanApiKeyMissingException;

class PostmanService implements PostmanServiceInterface
{
    private $token;

    public function __construct(string $token)
    {
        if (!$token) {
            throw new PostmanApiKeyMissingException("Postman API key is not set!");
        }

        $this->token = $token;
    }
}

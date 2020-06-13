<?php

namespace Lionix\LaravelPostmanRoutes\Commands\Traits;

use Lionix\LaravelPostmanRoutes\Contracts\Services\PostmanServiceInterface;
use Lionix\LaravelPostmanRoutes\Exceptions\PostmanApiKeyMissingException;

trait CreatesPostmanService
{
    public function createPostmanService(): PostmanServiceInterface
    {
        try {
            $service = app()->make(PostmanServiceInterface::class);
        } catch (PostmanApiKeyMissingException $e) {
            $solution = $e->getSolution();

            $this->error($solution->getSolutionTitle());
            $this->comment($solution->getSolutionDescription());

            exit(1);
        }

        return $service;
    }
}

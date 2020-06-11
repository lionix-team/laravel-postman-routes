<?php

namespace Lionix\LaravelPostmanRoutes\Exceptions;

use Exception;
use Facade\IgnitionContracts\BaseSolution;
use Facade\IgnitionContracts\ProvidesSolution;
use Facade\IgnitionContracts\Solution;

class PostmanApiKeyMissingException extends Exception implements ProvidesSolution
{
    public function getSolution(): Solution
    {
        return BaseSolution::create($this->message)
            ->setSolutionDescription(
                "Set your 'POSTMAN_API_KEY' .env variable and refresh your configuration cache."
            );
    }
}

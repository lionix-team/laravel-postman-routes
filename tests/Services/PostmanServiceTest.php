<?php

namespace Lionix\LaravelPostmanRoutes\Tests\Services;

use Lionix\LaravelPostmanRoutes\Contracts\Services\PostmanServiceInterface;
use Lionix\LaravelPostmanRoutes\Exceptions\PostmanApiKeyMissingException;
use Lionix\LaravelPostmanRoutes\Tests\BaseTestCase;

class PostmanServiceTest extends BaseTestCase
{
    public function testWhenTokenIsMissingThrowPostmanApiKeyMissingException()
    {
        $this->app['config']->set('postman-routes.api-key', '');
        
        $this->expectException(PostmanApiKeyMissingException::class);

        $this->app->make(PostmanServiceInterface::class);
    }
}

<?php

namespace Lionix\LaravelPostmanRoutes\Tests\Services;

use Faker\Factory as FakerFactory;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Lionix\LaravelPostmanRoutes\Contracts\Services\PostmanServiceInterface;
use Lionix\LaravelPostmanRoutes\Entities\RouteEntity;
use Lionix\LaravelPostmanRoutes\Exceptions\PostmanApiKeyMissingException;
use Lionix\LaravelPostmanRoutes\Tests\BaseTestCase;
use Lionix\LaravelPostmanRoutes\Tests\Traits\MocksPostmanService;

class PostmanServiceTest extends BaseTestCase
{
    use MocksPostmanService;

    public function testConfigTokenMissingPostmanApiKeyMissingExceptionThrown()
    {
        $this->app['config']->set('postman-routes.api-key', '');

        $this->expectException(PostmanApiKeyMissingException::class);

        $this->app->make(PostmanServiceInterface::class);
    }

    public function testCreateCollectionCorrectlyMapCollectionInstance()
    {
        $fakerFactory = FakerFactory::create();

        $collectionApiResponse = [
            'collection' => [
                'id' => $fakerFactory->uuid,
                'uid' => $fakerFactory->uuid,
                'name' => $fakerFactory->realText(15),
            ],
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($collectionApiResponse)),
        ]);

        $service = $this->mockPostmanService(HandlerStack::create($mock));

        $exprectedCollection = $collectionApiResponse['collection'];

        $collection = $service->createCollection($fakerFactory->title(), []);

        $this->assertSame($collection->getId(), $exprectedCollection['id']);
        $this->assertSame($collection->getUid(), $exprectedCollection['uid']);
        $this->assertSame($collection->getName(), $exprectedCollection['name']);
    }
}

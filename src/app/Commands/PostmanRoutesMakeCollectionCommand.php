<?php

namespace Lionix\LaravelPostmanRoutes\Commands;

use Illuminate\Console\Command;
use Lionix\LaravelPostmanRoutes\Commands\Traits\CollectsApplicationRoutes;
use Lionix\LaravelPostmanRoutes\Commands\Traits\CreatesPostmanService;
use Lionix\LaravelPostmanRoutes\Commands\Traits\ProcessesPostmanServiceRequest;
use Lionix\LaravelPostmanRoutes\DataMappers\RouteEntityDataMapper;

class PostmanRoutesMakeCollectionCommand extends Command
{
    use CreatesPostmanService, ProcessesPostmanServiceRequest, CollectsApplicationRoutes;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'postman-routes:make-collection {name} {--filter=} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create postman collection';

    /**
     * @var \Lionix\LaravelPostmanRoutes\Contracts\Services\PostmanServiceInterface
     */
    protected $service;

    /**
     * @var \Lionix\LaravelPostmanRoutes\DataMappers\RouteEntityDataMapper
     */
    protected $routeEntityDataMapper;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(RouteEntityDataMapper $routeEntityDataMapper)
    {
        $this->routeEntityDataMapper = $routeEntityDataMapper;

        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info(trans('postman-routes::console.collecting-routes'));

        $routes = $this->collectApplicationRoutes(
            $this->routeEntityDataMapper,
            $this->option('filter')
        );

        if (
            !$this->option('force')
            && !$routes->count()
            && !$this->confirm(trans('postman-routes::console.create-empty-collection'))
        ) {
            return 0;
        }

        $this->info(trans('postman-routes::console.service-init'));

        $this->service = $this->createPostmanService();

        $this->info(trans('postman-routes::console.sending-the-request'));

        $collection = $this->processPostmanServiceRequest(function () use ($routes) {
            return $this->service->createCollection(
                $this->argument('name'),
                $routes->toArray()
            );
        });

        $this->info(trans('postman-routes::console.collection-created', [
            'name' => $collection->getName(),
        ]));

        $this->comment(trans('postman-routes::console.collection-id', [
            'id' => $collection->getId(),
        ]));

        $this->comment(trans('postman-routes::console.collection-uid', [
            'uid' => $collection->getUid(),
        ]));
    }
}

<?php

namespace Lionix\LaravelPostmanRoutes\Entities;

use Lionix\LaravelPostmanRoutes\Contracts\Entities\CanBeMadeFromStdClassInterface;
use stdClass;

class CollectionEntity
{
    private $id;

    private $uid;

    private $name;

    public function __construct(string $id, string $uid, string $name)
    {
        $this->id = $id;
        $this->uid = $uid;
        $this->name = $name;
    }
    
    public function getId(): string
    {
        return $this->id;
    }

    public function getUid(): string
    {
        return $this->uid;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

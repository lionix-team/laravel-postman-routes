<?php

namespace Lionix\LaravelPostmanRoutes\Entities;

class RouteEntity
{
    private $name;

    private $method;

    private $url;

    private $body;

    public function __construct(string $name, string $method, string $url, array $body)
    {
        $this->name = $name;
        $this->method = $method;
        $this->url = $url;
        $this->body = $body;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getBody(): array
    {
        return $this->body;
    }
}

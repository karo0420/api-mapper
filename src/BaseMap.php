<?php

namespace Karo0420\ApiMapper;

use GuzzleHttp\Client;

abstract class BaseMap
{

    public string $mapName = '';
    public string $mapId   = '';

    protected array $headers = [];
    public array $preparedRoutes = [];

    abstract public function baseUrl(): string;
    abstract protected function routes(): array;

    public function __construct(private Loader $loader)
    {
        $this->preparedRoutes = $this->routes();
        $this->loader->setMap($this);
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function __call(string $name, array $arguments)
    {
        return $this->loader->$name($arguments[0]??null);
    }

    public function __get(string $name)
    {
        return $this->loader->$name;
    }


}
<?php

namespace Karo0420\ApiMapper;

use Karo0420\ApiMapper\Traits\Remotable;
use JetBrains\PhpStorm\Pure;

class Route
{

    use Remotable;

    private array $params = [];

    private array $headers = [];

    private array $payload = [];

    private array $query   = [];

    private string $baseUrl = '';

    private Mapper $mapper;

    private array $routePayload = [];

    private string $OriginalUrl = '';

    public function __construct(
        private string $url,
        private string $method
    )
    {
      $this->OriginalUrl = $url;
    }

    #[Pure] public static function get(string $url, Mapper $mapper)
    {
        return self::makeInstance($url, 'GET', $mapper);
    }

    #[Pure] public static function post(string $url, Mapper $mapper): Route
    {
        return self::makeInstance($url, 'POST', $mapper);
    }

    #[Pure] public static function put(string $url, Mapper $mapper): Route
    {
        return self::makeInstance($url, 'PUT', $mapper);
    }

    #[Pure] public static function delete(string $url, Mapper $mapper): Route
    {
        return self::makeInstance($url, 'DELETE', $mapper);
    }

    #[Pure] private static function makeInstance($url, $method, Mapper $mapper): Route
    {
        $routeInstance = new self($url, $method);
        $routeInstance->mapper = $mapper;
        return $routeInstance;
    }

    public function getMapper(): Mapper
    {
        return $this->mapper;
    }

    public function setBaseUrl(string $baseUrl): self
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    public function addParam(array $param): self
    {
        $this->params = array_merge($this->params, $param);
        return $this;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function reset()
    {
        $this->params = [];
        $this->url = $this->OriginalUrl;
    }

    public function fillParams(): self
    {
        foreach ($this->params as $key => $param) {
            $this->url = $this->replace($key, $param, $this->url);
            $this->setHeaderParams([$key => $param]);
            $this->setPayloadParams([$key => $param]);
            $this->setQueryParams([$key => $param]);
        }
        return $this;
    }

    public function withHeader(array $header): self
    {
        $this->addHeader($header);
        return $this;
    }

    public function withPayload(mixed $payload): self
    {
        $this->addPayload($payload);
        return $this;
    }

    private function addPayload(array $payload)
    {
        $this->payload = array_merge($this->payload, $payload);
    }

    public function withQuery(array $query): self
    {
        $this->addQuery($query);
        return $this;
    }

    private function addQuery(array $query)
    {
        $this->query = array_merge($this->query, $query);
    }

    private function setHeaderParams(array $params)
    {
        foreach ($params as $key => $value)
            $this->headers = $this->replaceArray($key, $value, $this->headers);
    }

    private function setPayloadParams(array $params)
    {
        foreach ($params as $key => $value)
            $this->payload = $this->replaceArray($key, $value, $this->payload);
    }

    private function setQueryParams(array $params)
    {
        foreach ($params as $key => $value)
            $this->query = $this->replaceArray($key, $value, $this->query);
    }

    private function replace($find, $replaceWith, $searchIn): array|string
    {
        return str_replace('{'.$find.'}', $replaceWith, $searchIn);
    }

    private function replaceArray($find, $replaceWith, $searchIn): array
    {
        $temp = [];
        foreach ($searchIn as $key => $value) {
            if (is_array($value)) {
                $temp[$key] = $this->replaceArray($find, $replaceWith, $value);
            }else {
                $temp[$key] = $this->replace($find, $replaceWith, $value);
            }
        }
        return $temp;
    }

    public function getPathUrl(): string
    {
        return $this->url;
    }

    #[Pure] public function getFullUrl(): string
    {
        return $this->baseUrl.$this->getPathUrl();
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function visit(): string
    {
        //print_r($this->getFullQuery());
        $this->fillParams();
        $response = $this->load(
            $this->method,
            $this->getFullUrl(),
            $this->getFullHeader(),
            $this->getFullPayload(),
            $this->getFullQuery()
        );
        return $response->getBody()->getContents();
    }

    private function addHeader(array $header): void
    {
        $this->headers = array_merge($this->headers, $header);
    }

    public function getFullHeader(): array
    {
        return $this->headers;
    }

    public function getFullPayload(): array
    {
        return $this->payload;
    }

    public function getFullQuery(): array
    {
        return $this->query;
    }



}
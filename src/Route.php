<?php

namespace Karo0420\ApiMapper;

use Karo0420\ApiMapper\Traits\Remotable;
use JetBrains\PhpStorm\Pure;

class Route
{

    use Remotable;

    private array $headers = [];
    private array $payload = [];

    private array $routePayload = [];

    public function __construct(
        private string $url,
        private string $verb
    )
    {
    }

    #[Pure] public static function get(string $url)
    {
        return new self($url, 'GET');
    }

    #[Pure] public static function post(string $url): Route
    {
        return new self($url, 'POST');
    }

    #[Pure] public static function put(string $url): Route
    {
        return new self($url, 'PUT');
    }

    #[Pure] public static function delete(string $url): Route
    {
        return new self($url, 'DELETE');
    }

    public function withHeader(array $header): self
    {
        $this->addHeader($header);
        return $this;
    }

    public function withPayload(mixed $payload): self
    {
        $this->payload = $payload;
        return $this;
    }

    public function params(array $params): void
    {
        foreach ($params as $key => $param)
            $this->url = str_replace('{'.$key.'}', $param, $this->url);
    }

    public function headerParams(array $params): void
    {
        foreach ($params as $key => $param)
            foreach ($this->getFullHeader() as $headerkey => $headerValue)
                $this->addHeader([$headerkey => str_replace('{'.$key.'}', $param, $headerValue)]);
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function visit(array $params = null): string
    {
        $fullHeaders = $this->getFullHeader();
        //print_r($fullHeaders);
        //print_r($this->payload);
        if ($params) {
            $this->params($params);
            $this->headerParams($params);
        }
        return $this->load($this->verb, $this->url, $fullHeaders, $this->payload);
    }

    private function addHeader(array $header): void
    {
        foreach ($header as $key=>$value) {
            $this->headers[$key] = $value;
        }
        //$this->headers = array_merge($this->headers, $header);
    }

    public function getFullHeader(): array
    {
        return $this->headers;
    }

    public function getPayload(): array
    {
        return $this->routePayload;
    }

}
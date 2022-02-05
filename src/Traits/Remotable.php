<?php

namespace Karo0420\ApiMapper\Traits;

use GuzzleHttp\Client;

trait Remotable
{
    protected function load(string $verb, string $url, array $headers = [], array $payload = [])
    {
        $client = new Client();
        $response = $client->request($verb, $url, [
            'headers' => $headers,
            'json'    => $payload
        ]);
        return $response->getBody()->getContents();
    }
}
<?php

namespace Karo0420\ApiMapper\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;
use Psr\Http\Message\ResponseInterface;

trait Remotable
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function load(string $method, string $url, array $headers = [], array $payload = [], array $query = []): ResponseInterface
    {

        //print_r($headers);
        $client = new Client();
        return $client->request($method, $url, [
            'headers' => $headers,
            'json'    => $payload,
            'query'   => $query,
//            'on_stats' => function (TransferStats $stats) {
//            }
        ]);
    }
}
<?php

namespace Karo0420\ApiMapper\Interfaces;

use Karo0420\ApiMapper\Route;

interface RouteGetRequestInterface
{
    public function withHeader(array $header): Route;

    public function getUrl(): string;

}
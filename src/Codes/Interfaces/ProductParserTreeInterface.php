<?php

namespace Karo0420\ApiMapper\Interfaces;

interface ProductParserTreeInterface
{
    public function __get(string $name);
    public function __set(string $name, $value): void;

    //public function toArray(string $productData): array;
}
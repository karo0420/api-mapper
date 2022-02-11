<?php

namespace Karo0420\ApiMapper;

interface ItemInterface
{
    public function toArray(): array;

    public function getItems(): array;

    public function additional(array $data): ItemInterface;

}
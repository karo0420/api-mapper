<?php

namespace Karo0420\ApiMapper;

class Item implements ItemInterface
{

    private array $fields = [];

    public function __set(string $name, $value): void
    {
        $this->fields[$name] = $value;
    }

    public function __get(string $name)
    {
        return $this->fields[$name];
    }

    public function toArray(): array
    {
        return $this->fields;
    }

    public function additional(array $data): ItemInterface
    {
        foreach ($data as $key => $value)
            $this->$key = $value;
        return $this;
    }

    public function getItems(): array
    {
        return [];
    }
}
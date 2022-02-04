<?php

namespace Karo0420\ApiMapper;

class Product
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
        $returnArray = [];
        foreach ($this->fields as $key => $field) {
            if (is_object($field)) {
                $leafArray = $field->toArray();
                $returnArray[$key] = $leafArray;
            }else
                $returnArray[$key] = $field;
        }
        return $returnArray;
    }
}
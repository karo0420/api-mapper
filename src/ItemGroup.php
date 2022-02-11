<?php

namespace Karo0420\ApiMapper;

class ItemGroup implements ItemInterface
{
    private array $items = [];

    public function addItem(ItemInterface $item)
    {
        array_push($this->items, $item);
    }

    public function toArray(): array
    {
        $tempArr = [];
        foreach ($this->items as $item)
            $tempArr[] = $item->toArray();
        return $tempArr;
    }

    public function additional(array $data): ItemInterface
    {
        foreach ($this->items as $item)
            $item->additional($data);
        return $this;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
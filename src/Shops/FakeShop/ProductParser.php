<?php

namespace Karo0420\ApiMapper\Shops\FakeShop;

class ProductParser extends \Karo0420\ApiMapper\ProductParser
{

    protected function neededKeys(): array
    {
        return [
            'id',
            'image' => 'ax',
            'likes',
            'text'
        ];
    }

    protected function collectionNeededKeys(): array
    {
        return [
            'data' => $this->neededKeys()
        ];
    }

}
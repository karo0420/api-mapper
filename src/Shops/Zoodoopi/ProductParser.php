<?php

namespace Karo0420\ApiMapper\Shops\Zoodoopi;

class ProductParser extends \Karo0420\ApiMapper\ProductParser
{

    protected function neededKeys(): array
    {
        return [
            'id',
            'title',
            'price',
            'description',
            'category',
            'image' => 'ax',
            'rating' => [
                'rate',
                'count'
            ]
        ];
    }

    protected function collectionNeededKeys(): array
    {
        return [];
    }

}
<?php

namespace Karo0420\ApiMapper\Shops\Zoodoopi;

use Karo0420\ApiMapper\Mapper;

class ProductMapper extends Mapper
{

    protected function neededKeys(): array
    {
        return [
            'id',
            'title',
            'price',
            'description',
            'image',
            'category'
        ];
    }

    protected function collectionNeededKeys(): array
    {
        return [];
    }
}
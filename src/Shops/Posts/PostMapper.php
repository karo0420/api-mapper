<?php

namespace Karo0420\ApiMapper\Shops\Posts;

use Karo0420\ApiMapper\Mapper;

class PostMapper extends Mapper
{

    protected function neededKeys(): array
    {
        return [
            'id',
            'title',
            'body',
            'userId',
        ];
    }

    protected function collectionNeededKeys(): array
    {
        return [

        ];
    }
}
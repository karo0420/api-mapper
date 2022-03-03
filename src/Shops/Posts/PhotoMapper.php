<?php

namespace Karo0420\ApiMapper\Shops\Posts;

use Karo0420\ApiMapper\Mapper;

class PhotoMapper extends Mapper
{

    protected function neededKeys(): array
    {
        return [
            'id',
            'albumId',
            'title',
            'url',
            'thumbnailUrl'
        ];
    }

    protected function collectionNeededKeys(): array
    {
        return [];
    }

    protected function dataWrappedIn(): string
    {
        return '';
    }
}
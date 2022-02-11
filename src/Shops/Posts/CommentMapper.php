<?php

namespace Karo0420\ApiMapper\Shops\Posts;

use Karo0420\ApiMapper\Mapper;

class CommentMapper extends Mapper
{

    protected function neededKeys(): array
    {
        return [
            'id',
            'postId',
            'name',
            'email',
            'body'
        ];
    }

    protected function collectionNeededKeys(): array
    {
        return [];
    }
}
<?php

namespace Karo0420\ApiMapper\Shops\Posts;

use Karo0420\ApiMapper\BaseMap;
use Karo0420\ApiMapper\Route;

class Posts extends BaseMap
{

    public string $mapName = 'Poster';
    public string $mapId   = '2';

    protected array $headers = [
        'app-id' => 'felan'
    ];

    public function baseUrl(): string
    {
        return 'https://jsonplaceholder.typicode.com';
    }

    protected function routes(): array
    {
        return [
            'posts' => [
                'all'      => Route::get('/posts', PostMapper::collection())
                    ->withQuery([
                        'userId' => '{user}'
                    ])
                ,
                'detail'   => Route::get('/posts/{detail}', new PostMapper()),
                'comments' => Route::get('/posts/{posts}/comments', CommentMapper::collection()),
                'photos'   => Route::get('/albums/{posts}/photos', PhotoMapper::collection()),
                'create'   => Route::post('/posts', new PostMapper())
                    ->withPayload([
                        'title' => '{title}',
                        'body'  => '{body}',
                        'userId' => '{user}'
                    ]),
                'update' => Route::put('/posts/{posts}', new PostMapper())
                    ->withPayload([
                        'title' => '{title}',
                        'body'  => '{body}',
                        'userId' => '{user}'
                    ])->withQuery([
                        'limit' => '{limit}'
                    ])
            ],
        ];
    }


}
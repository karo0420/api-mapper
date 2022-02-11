<?php

namespace Karo0420\ApiMapper\Shops\Zoodoopi;

use Karo0420\ApiMapper\BaseMap;
use Karo0420\ApiMapper\Route;

class Zoodoopi extends BaseMap
{

    public string $mapName = 'Zoodoopi';
    public string $mapId   = '1';

    protected function routes(): array
    {
        return [
            'products' => [
                'all'    => Route::get('/products', ProductMapper::collection()),
                'detail' => Route::get('/products/{detail}', new ProductMapper())
            ],
            'categories' => [
                'list'     => Route::get('/products/categories', CategoryMapper::collection()),
                'products' => Route::get('/products/category/{categories}', ProductMapper::collection())
            ],
            'test' => [
                'test2' => [
                    'test3' => Route::get('/products', ProductMapper::collection())
                ]
            ]
        ];
    }

    public function baseUrl(): string
    {
        return 'https://fakestoreapi.com';
    }
}
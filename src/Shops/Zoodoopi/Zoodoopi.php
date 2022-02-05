<?php

namespace Karo0420\ApiMapper\Shops\Zoodoopi;

use Karo0420\ApiMapper\BaseShop;
use Karo0420\ApiMapper\Route;

class Zoodoopi extends BaseShop
{

    protected function prepareRoutes(): array
    {
        return [
            'products' => [
                'all' => Route::get('https://fakestoreapi.com/products'),
                'detail' => Route::get('https://fakestoreapi.com/products/{id}')
            ]
        ];
    }
}
<?php

namespace Karo0420\ApiMapper\Shops\FakeShop;

use Karo0420\ApiMapper\BaseShop;
use Karo0420\ApiMapper\Route;

class FakeShop extends BaseShop
{

    protected array $headers = [
        'app-id' => '61f3ceaf8c9d66b784faf7cd'
    ];

    protected function prepareRoutes(): array
    {
        return [
            'base_url' => Route::get('https://dummyapi.io/data/v1'),
            'products' => Route::get('https://dummyapi.io/data/v1/post'),
            'product_detail' => Route::get('https://dummyapi.io/data/v1/post/{id}')
                ->withHeader([
                    'fake' => 'from',
                    'user-agent' => 'felan hast browser'
                ])
                ->withPayload([
                    'product' => [
                        'id' => 'id_from_payload'
                    ]
                ])
        ];
    }
}
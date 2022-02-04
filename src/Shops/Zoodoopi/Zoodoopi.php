<?php

namespace Karo0420\ApiMapper\Shops\Zoodoopi;

use Karo0420\ApiMapper\BaseShop;
use Karo0420\ApiMapper\Route;

/**
 * set protected $headers property , to send header with all requests
 *
 */

class Zoodoopi extends BaseShop
{

    protected array $headers = [];

    protected function prepareRoutes(): array
    {
        return [
            'base_url'          => Route::get('https://fakestoreapi.com'),
            'product_detail'    => Route::get('https://fakestoreapi.com/products/{id}')
                                        ->withHeader([
                                            'zoodoopi' => 'besan',
                                        ]),
            'products'          => Route::get('https://fakestoreapi.com/products'),
            'category_all'      => Route::get('https://fakestoreapi.com/products/categories'),
            'category_products' => Route::get('https://fakestoreapi.com/products/category/{id}')
        ];
    }


}
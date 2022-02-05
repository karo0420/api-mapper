<?php

namespace Karo0420\ApiMapper\Shops;

use Karo0420\ApiMapper\ProductLoader;
use Karo0420\ApiMapper\Shops\Zoodoopi\ProductParser;
use Karo0420\ApiMapper\Shops\Zoodoopi\Zoodoopi;

class ShopFactory
{
    public static function create()
    {
        return new Zoodoopi(new ProductLoader(new ProductParser()), ['shop_name'=> 'Zoodoopi', 'shop_id'=>1]);
    }
}
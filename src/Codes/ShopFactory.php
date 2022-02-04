<?php

namespace Karo0420\ApiMapper;

use Karo0420\ApiMapper\Shops\FakeShop\FakeShop;
use Karo0420\ApiMapper\Shops\Zoodoopi\ProductParser;
use Karo0420\ApiMapper\Shops\Zoodoopi\Zoodoopi;

class ShopFactory
{

    const ZOODOOPI = 1;
    const FAKESHOP = 2;

    public static function create(int $shopId)
    {
        switch ($shopId) {
            case self::ZOODOOPI:
                return new Zoodoopi(
                    new ProductLoader(
                        new ProductParser()
                    ),
                    new CategoryLoader(),
                    ['shop_name' => 'Zoodoopi', 'shop_id' => 1]
                );
                break;
            case self::FAKESHOP:
                return new FakeShop(new ProductLoader(new \Karo0420\ApiMapper\Shops\FakeShop\ProductParser()), new CategoryLoader(), ['shop_name' => 'FakeShop', 'shop_id' => 2]);
                break;

        }

    }
}
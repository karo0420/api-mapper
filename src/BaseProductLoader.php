<?php

namespace Karo0420\ApiMapper;

use Karo0420\ApiMapper\ProductParser;
use Karo0420\ApiMapper\Traits\Remotable;

class BaseProductLoader
{

    protected BaseShop $shop;

    public function __construct(protected ProductParser $parser)
    {
    }

    public function setShop(BaseShop $shop)
    {
        $this->shop = $shop;
    }

}
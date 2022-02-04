<?php

namespace Karo0420\ApiMapper;

use Karo0420\ApiMapper\Traits\Remotable;

class CategoryLoader
{

    private BaseShop $shop;
    private string $categoryName;

    public function setShop(BaseShop $shop)
    {
        $this->shop = $shop;
    }

    public function setCategoryName(string $categoryName)
    {
        $this->categoryName = $categoryName;
        return $this;
    }

    public function getCategoryName()
    {
        return $this->categoryName;
    }

    public function products()
    {
        $product = clone $this->shop->getProductInstance();
        $product->setCategory($this);
        return $product;
    }

    public function all()
    {
        return $this->shop->routes['category_all']->visit();
    }
}
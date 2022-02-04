<?php

namespace Karo0420\ApiMapper;

use GuzzleHttp\Client;

abstract class BaseShop
{

    private string $shopName;
    private int    $shopId;

    protected array $headers = [];
    public    array $routes  = [];

    abstract protected function prepareRoutes(): array;

    public function __construct(protected ProductLoader $product, protected CategoryLoader $category, protected array $config)
    {
        $this->routes = $this->prepareRoutes();
        $this->shopName = $this->config['shop_name'];
        $this->shopId   = $this->config['shop_id'];
        $this->product->setShop($this);
        $this->category->setShop($this);
    }

    public function products()
    {
        return $this->product;
    }

    public function category(string $categoryName = '')
    {
        return $this->category->setCategoryName($categoryName);
    }

    public function getProductInstance()
    {
        return $this->product;
    }

    public function getShopName()
    {
        return $this->shopName;
    }

    public function getShopId()
    {
        return $this->shopId;
    }

    public function getHeaders()
    {
        return $this->headers;
    }


    public function __call(string $name, array $arguments)
    {

    }

}
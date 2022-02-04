<?php

namespace Karo0420\ApiMapper;

class ProductLoader extends BaseProductLoader
{

    private CategoryLoader $category;

    public function setCategory(CategoryLoader $category)
    {
        $this->category = $category;
    }

    public function detail(mixed $identifier)
    {
        return $this->parser->parse(
            $this->shop->routes['product_detail']->withHeader($this->shop->getHeaders())->visit(['id' => $identifier])
        );
    }

    public function all()
    {
        $prefix = '';
        if (isset($this->category) && $this->category->getCategoryName())
            $data = $this->shop->routes['category_products']->withHeader($this->shop->getHeaders())->visit(['id' => $this->category->getCategoryName()]);
        else
            $data = $this->shop->routes[$prefix . 'products']->withHeader($this->shop->getHeaders())->visit();
        return $this->parser->parseCollection($data);
    }

}
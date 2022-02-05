<?php

namespace Karo0420\ApiMapper;

abstract class ProductParser
{

    protected array $productData;

    public function parse(string $productData)
    {
        $product = $this->convertToArray($productData);
        $productModel = new Product();
        return $this->syncProductKeys($product, $productModel, $this->neededKeys());
    }

    public function parseCollection(string $productData): array
    {
        //print_r($productData);
        $productsArray = $this->convertToArray($productData);
        $productObj = new Product();
        $productStack = [];

        if (count($this->collectionNeededKeys())) {
            foreach ($this->collectionNeededKeys() as $collectionKeyName => $neededKeys) {
                //$productStack = [];
                foreach ($productsArray[$collectionKeyName] as $product) {
                    $productStack[] = $this->syncProductKeys($product, clone $productObj, $neededKeys);
                }
            }

        }else
            foreach ($productsArray as $product)
                $productStack[] = $this->syncProductKeys($product, clone $productObj, $this->neededKeys());
        return $productStack;
    }

    private function syncProductKeys(array $productArray, $productObj, array $neededKeys): Product
    {
        $c = new class extends Product {};
        foreach ($neededKeys as $key => $value) {
            $searchKey = is_numeric($key) ? $value : $key;
            $data = $productArray[$searchKey];
            if (is_array($value)) {
                $data = $this->syncProductKeys($data, clone $c, $value);
                $value = $key;
            }
            $productObj->$value = $data;
        }
        return $productObj;
    }

    private function convertToArray(string $productData): array
    {
        return json_decode($productData, true);
    }

    abstract protected function neededKeys(): array;
    abstract protected function collectionNeededKeys(): array;


}
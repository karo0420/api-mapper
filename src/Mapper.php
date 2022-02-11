<?php

namespace Karo0420\ApiMapper;

abstract class Mapper
{

    protected array $productData;
    private bool $isCollection = false;


    public static function collection()
    {
        $mapper = new static();
        $mapper->isCollection = true;
        return $mapper;
    }

    public function parse(string $productData)
    {
        $productArray = $this->convertToArray($productData);
        if (! $productArray)
            return null;
        if ($this->isCollection) {
            $result = $this->parseCollection($productArray);
        }else {
            $result = $this->syncProductKeys($productArray, new Item(), $this->neededKeys());
        }
        return $result;
    }

    public function parseCollection(array $productData)
    {
        //print_r($productData);
        $productsArray = $productData;
        $productGroup = new ItemGroup();

        if (count($this->collectionNeededKeys())) {
            foreach ($this->collectionNeededKeys() as $collectionKeyName => $neededKeys) {
                foreach ($productsArray[$collectionKeyName] as $product) {
                    $productGroup->addItem($this->syncProductKeys($product, new Item(), $neededKeys));
                }
            }

        }else {
            foreach ($productsArray as $product)
                $productGroup->addItem($this->syncProductKeys($product, new Item(), $this->neededKeys()));
        }
        return $productGroup;
    }

    private function syncProductKeys(mixed $productArray, $productObj, array $neededKeys): Item
    {
        if (! empty($productArray) && empty($neededKeys))
            $neededKeys = ['mapper_item'];
        foreach ($neededKeys as $key => $value) {
            $searchKey = is_numeric($key) ? $value : $key;
            if ($searchKey !== 'mapper_item')
                $data = $productArray[$searchKey]??null;
            else {
                $data = $productArray;
                $value = $key;
            }
            if (is_array($value)) {
                $data = $this->syncProductKeys($data, new Item(), $value);
                $value = $key;
            }
            $productObj->$value = $data;
        }
        return $productObj;
    }

    private function convertToArray(string $productData)
    {
        return json_decode($productData, true);
    }

    abstract protected function neededKeys(): array;
    abstract protected function collectionNeededKeys(): array;


}
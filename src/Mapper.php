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
        if ($this->isCollection) {
            $result = $this->parseCollection($productData);
        }else {
            $product = $this->convertToArray($productData);
            $result = $this->syncProductKeys($product, new Item(), $this->neededKeys());
        }
        return $result;
    }

    public function parseCollection(string $productData)
    {
        //print_r($productData);
        $productsArray = $this->convertToArray($productData);
        $productGroup = new ItemGroup();

        if (count($this->collectionNeededKeys())) {
            foreach ($this->collectionNeededKeys() as $collectionKeyName => $neededKeys) {
                foreach ($productsArray[$collectionKeyName] as $product) {
                    $productGroup->addItem($this->syncProductKeys($product, new Item(), $neededKeys));
                }
            }

        }else
            foreach ($productsArray as $product)
                $productGroup->addItem($this->syncProductKeys($product, new Item(), $this->neededKeys()));
        return $productGroup;
    }

    private function syncProductKeys(array $productArray, $productObj, array $neededKeys): Item
    {
        foreach ($neededKeys as $key => $value) {
            $searchKey = is_numeric($key) ? $value : $key;
            $data = $productArray[$searchKey]??null;
            if (is_array($value)) {
                $data = $this->syncProductKeys($data, new Item(), $value);
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
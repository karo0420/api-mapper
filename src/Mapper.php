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
            if ($this->dataWrappedIn())
                $productArray = $productArray[$this->dataWrappedIn()];
            $result = $this->syncProductKeys($productArray, new Item(), $this->neededKeys());
        }
        return $result;
    }

    public function parseCollection(array $productData)
    {
		$wrapTo = 'data';
		if (is_array($this->dataWrappedIn())) {
			$wrapkeys = array_keys($this->dataWrappedIn());
        	$wrappedIn = is_numeric($wrapkeys[0])?$this->dataWrappedIn()[0]:$wrapkeys[0];
			$wrapTo    = $this->dataWrappedIn()[$wrapkeys[0]]?$this->dataWrappedIn()[$wrapkeys[0]]:'data';
		}else {
			$wrappedIn = $this->dataWrappedIn();
		}
        

        $dataBackup = $productData;
        unset($productData[$wrappedIn]);
        $products = null;
        $meta = null;


        if (! $this->collectionNeededKeys() && ! $wrappedIn) {
            $products = $dataBackup;
            $wrappedIn = 'data';
        }elseif (! $this->collectionNeededKeys() && $wrappedIn) {
            // use product[data]
            $products = $dataBackup[$wrappedIn];
        }elseif($this->collectionNeededKeys() && ! $wrappedIn) {
            //meta
            $meta = $this->syncProductKeys($productData, new Item(), $this->collectionNeededKeys());
        }else {
            $meta = $this->syncProductKeys($productData, new Item(), $this->collectionNeededKeys());
            $products = $dataBackup[$wrappedIn];
        }

        $parsed = new ItemGroup();

        if ($products) {
            $productGroup = new ItemGroup();
            foreach ($products as $key => $product)
                $productGroup->addItem($this->syncProductKeys($product, new Item(), $this->neededKeys()));
        }

		if (isset($productGroup))
            $parsed->addItem($productGroup, $wrapTo);
        if ($meta)
            $parsed->addItem($meta, 'meta');
        return $parsed;

        /*//print_r($productData);
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
        return $productGroup;*/
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
    abstract protected function dataWrappedIn(): array|string;


}
<?php

namespace SWAPI\model;

use SWAPI\config\Response;

abstract class Product extends Model
{
    protected $sku;
    protected $name;
    protected $price;
    protected $productType;

    public function __construct($data)
    {
        // Validate the input data
        $this->validate($data);

        // Verify if there is no errors
        if (!$this->verify()) {
            return Response::handle(['error' => 'Invalid data'] + ['errors' => $this->getErrors()], 400);
        }

        // Bind the input data
        $this->bind($data);
    }

    public function validate($data)
    {
        if ($this->isMissing('sku', $data)) {
            $this->setError('sku', 'SKU is missing');
        }

        if ($this->isMissing('name', $data)) {
            $this->setError('name', 'Name is missing');
        }

        if ($this->isMissing('price', $data)) {
            $this->setError('price', 'Price is missing');
        } else if ($this->isNotNumber('price', $data)) {
            $this->setError('price', 'Price is not a number');
        }

        if ($this->isMissing('productType', $data)) {
            $this->setError('productType', 'Product type is missing');
        }
    }

    public function bind($data)
    {
        $this->setSku($data['sku']);
        $this->setName($data['name']);
        $this->setPrice($data['price']);
        $this->setProductType($data['productType']);
    }

    public function isSkuAlreadyExists($productService)
    {
        $productExists = $productService->fetchProductBySku($this->getSku());
        if ($productExists) {
            return Response::handle(['error' => 'Invalid data', 'errors' => ['sku' => 'SKU already exists']], 400);
        }
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }
    public function getProductType()
    {
        return $this->productType;
    }

    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setPrice($price)
    {
        $price = str_replace(',', '.', $price);
        $this->price = $price;
    }

    public function setProductType($productType)
    {
        $productType = strtolower($productType);
        $this->productType = $productType;
    }
}

<?php

namespace RAPI\model;

use RAPI\service\ProductService;
use Exception;

abstract class Product
{
    protected $sku;
    protected $name;
    protected $price;
    protected $productType;

    public function __construct($data)
    {
        // Validate the input data
        if (!isset($data['sku']) || !isset($data['name']) || !isset($data['price']) || !isset($data['productType'])) {
            throw new Exception('Invalid data', 400);
        }

        $this->setSku($data['sku']);
        $this->setName($data['name']);
        $this->setPrice($data['price']);
        $this->setProductType($data['productType']);
    }

    abstract public function save(ProductService $productService);

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

    /**
     * @param mixed $sku
     * @return self
     */
    public function setSku($sku): self
    {
        $this->sku = $sku;
        return $this;
    }

    /**
     * @param mixed $name
     * @return self
     */
    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param mixed $price
     * @return self
     */
    public function setPrice($price): self
    {
        $this->price = str_replace(',', '.', $price);
        return $this;
    }

    /**
     * @param mixed $productType
     * @return self
     */
    public function setProductType($productType): self
    {
        $this->productType = $productType;
        return $this;
    }
}

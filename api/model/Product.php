<?php

namespace RAPI\model;

use RAPI\config\Response;
use RAPI\service\ProductService;

abstract class Product
{
    protected $sku;
    protected $name;
    protected $price;
    protected $productType;
    public $errors = [];

    public function __construct($data)
    {
        // Validate the input data
        if (!isset($data['sku']) || empty($data['sku'])) {
            $this->errors['sku'] = 'SKU is missing';
        }

        if (!isset($data['name']) || empty($data['name'])) {
            $this->errors['name'] = 'Name is missing';
        }

        if (!isset($data['price']) || empty($data['price'])) {
            $this->errors['price'] = 'Price is missing';
        } else if (!is_numeric($data['price'])) {
            $this->errors['price'] = 'Price is not a number';
        }

        if (!isset($data['productType']) || empty($data['productType'])) {
            $this->errors['productType'] = 'Product type is missing';
        }

        if (count($this->errors)) {
            return Response::handle(['error' => 'Invalid data'] + ['errors' => $this->errors], 400);
        }

        // Bind the input data
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

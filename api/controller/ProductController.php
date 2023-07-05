<?php

namespace SWAPI\controller;

use SWAPI\service\ProductService;
use SWAPI\factory\ProductFactory;

class ProductController
{
    use ProductService;

    public function productList()
    {
        // Retrieve all products using the ProductService
        $products = $this->getAllProducts();

        // Collect product model exports
        $productExport = [];
        foreach ($products as $data) {
            // Create a new product instance in the right type
            $product = ProductFactory::createProduct($data);

            // Add data from product export
            $productExport[] = $product->export();
        }

        // Return all data from product exports
        return $productExport;
    }

    public function getProduct($sku)
    {
        // Retrieve all products using the ProductService
        $data = $this->fetchProductBySku($sku);

        // Create a new product instance in the right type
        $product = ProductFactory::createProduct($data);

        // Return data from product export
        return $product->export();
    }

    public function addProduct($data)
    {
        // Create a new product instance in the right type
        $product = ProductFactory::createProduct($data);

        // Check if sku already exists
        $product->isSkuAlreadyExists($this);

        // Save the product using the ProductService
        $product->save($this);
    }

    public function deleteProduct($sku)
    {
        // Delete product using the ProductService
        $this->deleteProductBySku($sku);
    }

    public function massDeleteProduct($skus)
    {
        // Delete all products using the ProductService
        $this->massDeleteProductsBySkus($skus);
    }
}

<?php

namespace SWAPI\controller;

use SWAPI\service\ProductService;
use SWAPI\factory\ProductFactory;

class ProductController
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function productList()
    {
        // Retrieve all products using the ProductService
        $products = $this->productService->getAllProducts();

        $productExport = [];
        foreach ($products as $data) {
            // Create a new product instance in the right type
            $product = ProductFactory::createProduct($data);

            // Return data in product export
            $productExport[] = $product->export();
        }

        return $productExport;
    }

    public function getProduct($sku)
    {
        // Retrieve all products using the ProductService
        $data = $this->productService->fetchProductBySku($sku);

        // Create a new product instance in the right type
        $product = ProductFactory::createProduct($data);

        // Return data in product export
        return $product->export();
    }

    public function addProduct($data)
    {
        // Create a new product instance in the right type
        $product = ProductFactory::createProduct($data);

        // Check if sku already exists
        $product->isSkuAlreadyExists($this->productService);

        // Save the product using the ProductService
        $product->save($this->productService);
    }

    public function deleteProduct($sku)
    {
        // Delete product using the ProductService
        $this->productService->deleteProductBySku($sku);
    }

    public function massDeleteProduct($skus)
    {
        // Delete all products using the ProductService
        $this->productService->massDeleteProductsBySkus($skus);
    }
}

<?php

namespace RAPI\controller;

use RAPI\config\Response;
use RAPI\service\ProductService;
use RAPI\factory\ProductFactory;
use PDOException;
use Exception;
use Error;

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

        return $products;
    }

    public function addProduct($data)
    {
        try {
            // Create a new product instance
            $product = ProductFactory::createProduct($data);

            // Check if sku already exists
            $product->isSkuAlreadyExists($this->productService);

            // Save the product using the ProductService
            $product->save($this->productService);

        } catch (PDOException | Exception | Error $e) {
            return Response::handle(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function getProduct($sku)
    {
        // Retrieve all products using the ProductService
        $product = $this->productService->fetchProductBySku($sku);

        return $product;
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

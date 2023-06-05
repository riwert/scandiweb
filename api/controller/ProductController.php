<?php

namespace RAPI\controller;

use RAPI\config\Response;
use RAPI\service\ProductService;
use RAPI\factory\ProductFactory;
use Exception;
use PDOException;

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

            // Save the product using the ProductService
            if ($this->productService->saveProduct($product)) {
                return Response::handle(['success' => 'Product saved successfully'], 201);
            }

        } catch (PDOException | Exception $e) {
            // Handle the exception, log the error, etc.
            return Response::handle(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function getProduct($sku)
    {
        if (!isset($sku)) {
            return Response::handle(['error' => 'Invalid data'], 400);
        }

        // Retrieve all products using the ProductService
        $product = $this->productService->getProductBySku($sku);

        return $product;
    }

    public function deleteProduct($sku)
    {
        if (!isset($sku)) {
            return Response::handle(['error' => 'Invalid data'], 400);
        }

        // Retrieve all products using the ProductService
        $this->productService->deleteProductBySku($sku);
    }

    public function massDeleteProduct($skus)
    {
        if (!isset($skus)) {
            return Response::handle(['error' => 'Invalid data'], 400);
        }

        // Retrieve all products using the ProductService
        $this->productService->massDeleteProductsBySkus($skus);
    }
}

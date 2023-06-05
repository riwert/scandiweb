<?php

require __DIR__.'/vendor/autoload.php';

use RAPI\config\Router;
use RAPI\controller\ProductController;
use RAPI\service\ProductService;

// Load ENV read lib
(Dotenv\Dotenv::createUnsafeImmutable(__DIR__))->load();

$router = new Router(getenv('BASE_PATH'));

$productService = new ProductService();
$productController = new ProductController($productService);

$router->addRoute('POST', '/product/saveApi', function () use ($productController) {
    $data = json_decode(file_get_contents('php://input'), true);
    return $productController->addProduct($data);
});

$router->addRoute('DELETE', '/product/delete', function ($params) use ($productController) {
    $sku = $params['sku'] ?? null;
    return $productController->deleteProduct($sku);
});

$router->addRoute('DELETE', '/product/massDelete', function ($params) use ($productController) {
    $skus = $params['skus'] ?? null;
    return $productController->massDeleteProduct($skus);
});

$router->addRoute('GET', '/product/get', function ($params) use ($productController) {
    $sku = $params['sku'] ?? null;
    return $productController->getProduct($sku);
});

$router->addRoute('GET', '/product', function () use ($productController) {
    return $productController->productList();
});

echo $router->handleRequest();

<?php

require __DIR__.'/vendor/autoload.php';

use SWAPI\config\Router;
use SWAPI\controller\ProductController;

// Set custom error and exception handlers
set_error_handler('SWAPI\config\Handler::handleError');
set_exception_handler('SWAPI\config\Handler::handleException');

// Load ENV read lib
(Dotenv\Dotenv::createUnsafeImmutable(__DIR__))->load();

$router = new Router(getenv('BASE_PATH'));

$productController = new ProductController();

$router->addRoute('GET', '/product/list', function () use ($productController) {
    return $productController->productList();
});

$router->addRoute('GET', '/product/get', function ($params) use ($productController) {
    // sku from url query param ?sku=
    $sku = $params['sku'] ?? null;
    return $productController->getProduct($sku);
});

$router->addRoute('POST', '/product/saveApi', function () use ($productController) {
    // data from body json payload
    $data = json_decode(file_get_contents('php://input'), true);
    return $productController->addProduct($data);
});

$router->addRoute('DELETE', '/product/delete', function ($params) use ($productController) {
    // sku from url query param ?sku=
    $sku = $params['sku'] ?? null;
    // data from body json payload
    $data = json_decode(file_get_contents('php://input'), true);
    // overwrite if sku exists in body json payload
    if (isset($data['sku'])) $sku = $data['sku'];
    return $productController->deleteProduct($sku);
});

$router->addRoute('DELETE', '/product/massDelete', function ($params) use ($productController) {
    // skus from url query param ?skus=
    $skus = $params['skus'] ?? null;
    // data from body json payload
    $data = json_decode(file_get_contents('php://input'), true);
    // overwrite if skus exists in body json payload
    if (isset($data['skus'])) $skus = $data['skus'];
    return $productController->massDeleteProduct($skus);
});

echo $router->handleRequest();

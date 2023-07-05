<?php

require __DIR__.'/vendor/autoload.php';

use SWAPI\config\Router;
use SWAPI\config\Response;
use SWAPI\controller\ProductController;

// Set the custom error handler
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    // Create an array with the error details
    $error = [
        'type' => 'error',
        'error' => $errstr,
        'file' => $errfile,
        'line' => $errline
    ];
    // Return the JSON response with appropriate HTTP status code
    return Response::handle($error, 500);
});

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

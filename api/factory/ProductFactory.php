<?php

namespace RAPI\factory;

use RAPI\config\Response;
use RAPI\model\DvdProduct;
use RAPI\model\BookProduct;
use RAPI\model\FurnitureProduct;

class ProductFactory
{
    private static $productTypes = [
        'dvd' => DvdProduct::class,
        'book' => BookProduct::class,
        'furniture' => FurnitureProduct::class
    ];

    public static function createProduct($data)
    {
        if (!isset($data['productType']) || empty($data['productType'])) {
            return Response::handle(['error' => 'Invalid data', 'errors' => ['productType' => 'Product type is missing']], 400);
        }

        if (!array_key_exists(strtolower($data['productType']), self::$productTypes)) {
            return Response::handle(['error' => 'Invalid data', 'errors' => ['productType' => 'Invalid product type']], 400);
        }

        $productClass = self::$productTypes[strtolower($data['productType'])];
        return new $productClass($data);
    }
}

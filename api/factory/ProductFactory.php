<?php

namespace RAPI\factory;

use RAPI\model\DvdProduct;
use RAPI\model\BookProduct;
use RAPI\model\FurnitureProduct;
use InvalidArgumentException;

class ProductFactory
{
    private static $productTypes = [
        'dvd' => DvdProduct::class,
        'book' => BookProduct::class,
        'furniture' => FurnitureProduct::class
    ];

    public static function createProduct($data)
    {
        $type = $data['productType'];

        if (!array_key_exists($type, self::$productTypes)) {
            throw new InvalidArgumentException('Invalid product type');
        }

        $productClass = self::$productTypes[$type];
        return new $productClass($data);
    }
}

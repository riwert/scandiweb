<?php

namespace RAPI\factory;

use RAPI\model\DvdProduct;
use RAPI\model\BookProduct;
use RAPI\model\FurnitureProduct;
use InvalidArgumentException;

class ProductFactory
{
    public static function createProduct($data)
    {
        switch ($data['productType']) {
            case 'dvd':
                return new DvdProduct($data);
            case 'book':
                return new BookProduct($data);
            case 'furniture':
                return new FurnitureProduct($data);
            default:
                throw new InvalidArgumentException('Invalid product type');
        }
    }
}

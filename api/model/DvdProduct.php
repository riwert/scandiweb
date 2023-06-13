<?php

namespace SWAPI\model;

use SWAPI\model\Product;

class DvdProduct extends Product
{
    protected $size;

    public function __construct($data)
    {
        $this->validateExtra($data);

        parent::__construct($data);

        $this->bindExtra($data);
    }

    public function validateExtra($data)
    {
        // Validate the input data
        if ($this->isMissing('size', $data)) {
            $this->setError('size', 'Size is missing');
        } else if ($this->isNotNumber('size', $data)) {
            $this->setError('size', 'Size is not a number');
        }
    }

    public function bindExtra($data)
    {
        $this->setSize($data['size']);
    }

    public function save($productService)
    {
        $productService->saveDvdProduct($this);
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $size = str_replace(',', '.', $size);
        $this->size = $size;
    }
}

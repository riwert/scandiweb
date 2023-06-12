<?php

namespace RAPI\model;

use RAPI\config\Response;
use RAPI\model\Product;

class FurnitureProduct extends Product
{
    protected $height;
    protected $length;
    protected $width;

    public function __construct($data)
    {
        $this->validateExtra($data);

        parent::__construct($data);

        $this->bindExtra($data);
    }

    public function validateExtra($data)
    {
        // Validate the input data
        if ($this->isMissing('height', $data)) {
            $this->setError('height', 'Height is missing');
        } else if ($this->isNotNumber('height', $data)) {
            $this->setError('height', 'Height is not a number');
        }

        if ($this->isMissing('length', $data)) {
            $this->setError('length', 'Length is missing');
        } else if ($this->isNotNumber('length', $data)) {
            $this->setError('length', 'Length is not a number');
        }

        if ($this->isMissing('width', $data)) {
            $this->setError('width', 'Width is missing');
        } else if ($this->isNotNumber('width', $data)) {
            $this->setError('width', 'Width is not a number');
        }
    }

    public function bindExtra($data)
    {
        $this->setHeight($data['height']);
        $this->setLength($data['length']);
        $this->setWidth($data['width']);
    }

    public function save($productService)
    {
        $productService->saveFurnitureProduct($this);
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setHeight($height)
    {
        $this->height = str_replace(',', '.', $height);
    }

    public function setLength($length)
    {
        $this->length = str_replace(',', '.', $length);
    }

    public function setWidth($width)
    {
        $this->width = str_replace(',', '.', $width);
    }
}

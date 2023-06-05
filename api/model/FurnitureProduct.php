<?php

namespace RAPI\model;

use RAPI\model\Product;
use Exception;

class FurnitureProduct extends Product
{
    protected $height;
    protected $length;
    protected $width;

    public function __construct($data)
    {
        parent::__construct($data);

        // Validate the input data
        if (!isset($data['height']) || !isset($data['length']) || !isset($data['width'])) {
            throw new Exception('Invalid data', 400);
        }

        $this->setHeight($data['height']);
        $this->setLength($data['length']);
        $this->setWidth($data['width']);
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

    /**
     * @param mixed $length 
     * @return self
     */
    public function setHeight($height): self {
        $this->height = str_replace(',', '.', $height);
        return $this;
    }

    /**
     * @param mixed $length 
     * @return self
     */
    public function setLength($length): self {
        $this->length = str_replace(',', '.', $length);
        return $this;
    }

    /**
     * @param mixed $width 
     * @return self
     */
    public function setWidth($width): self {
        $this->width = str_replace(',', '.', $width);
        return $this;
    }
}

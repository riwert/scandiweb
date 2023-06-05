<?php

namespace RAPI\model;

use RAPI\model\Product;
use Exception;

class DvdProduct extends Product
{
    protected $size;

    public function __construct($data)
    {
        parent::__construct($data);

        // Validate the input data
        if (!isset($data['size'])) {
            throw new Exception('Invalid data', 400);
        }

        $this->setSize($data['size']);
    }

    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size 
     * @return self
     */
    public function setSize($size): self
    {
        $this->size = $size;
        return $this;
    }
}

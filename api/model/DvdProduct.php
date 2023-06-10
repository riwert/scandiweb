<?php

namespace RAPI\model;

use RAPI\config\Response;
use RAPI\model\Product;

class DvdProduct extends Product
{
    protected $size;

    public function __construct($data)
    {
        parent::__construct($data);

        // Validate the input data
        if (!isset($data['size']) || empty($data['size'])) {
            $this->errors['size'] = 'Size is missing';
        }

        if (count($this->errors)) {
            return Response::handle(['error' => 'Invalid data'] + ['errors' => $this->errors], 400);
        }

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

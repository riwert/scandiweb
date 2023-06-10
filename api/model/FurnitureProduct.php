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
        parent::__construct($data);

        // Validate the input data
        if (!isset($data['height'])) {
            $this->errors['height'] = 'Height is missing';
        }

        if (!isset($data['length'])) {
            $this->errors['length'] = 'Length is missing';
        }

        if (!isset($data['width'])) {
            $this->errors['width'] = 'Width is missing';
        }

        if (count($this->errors)) {
            return Response::handle(['error' => 'Invalid data'] + ['errors' => $this->errors], 400);
        }

        // Bind the input data
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

    /**
     * @param mixed $length
     * @return self
     */
    public function setHeight($height): self
    {
        $this->height = str_replace(',', '.', $height);
        return $this;
    }

    /**
     * @param mixed $length
     * @return self
     */
    public function setLength($length): self
    {
        $this->length = str_replace(',', '.', $length);
        return $this;
    }

    /**
     * @param mixed $width
     * @return self
     */
    public function setWidth($width): self
    {
        $this->width = str_replace(',', '.', $width);
        return $this;
    }
}

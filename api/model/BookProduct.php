<?php

namespace RAPI\model;

use RAPI\model\Product;

class BookProduct extends Product
{
    protected $weight;

    public function __construct($data)
    {
        $this->validateExtra($data);
        
        parent::__construct($data);
        
        $this->bindExtra($data);
    }
    
    public function validateExtra($data)
    {
        // Validate the input data
        if ($this->isMissing('weight', $data)) {
            $this->setError('weight', 'Weight is missing');
        } else if ($this->isNotNumber('weight', $data)) {
            $this->setError('weight', 'Weight is not a number');
        }
    }
    
    public function bindExtra($data)
    {
        $this->setWeight($data['weight']);
    }

    public function save($productService)
    {
        $productService->saveBookProduct($this);
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight)
    {
        $weight = str_replace(',', '.', $weight);
        $this->weight = $weight;
    }
}

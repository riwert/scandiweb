<?php

namespace RAPI\model;

use RAPI\model\Product;
use Exception;

class BookProduct extends Product
{
    protected $weight;

    public function __construct($data)
    {
        parent::__construct($data);

        // Validate the input data
        if (!isset($data['weight'])) {
            throw new Exception('Invalid data', 400);
        }

        $this->setWeight($data['weight']);
    }

    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     * @return self
     */
    public function setWeight($weight): self
    {
        $this->weight = str_replace(',', '.', $weight);
        return $this;
    }
}

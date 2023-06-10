<?php

namespace RAPI\model;

use RAPI\config\Response;
use RAPI\model\Product;

class BookProduct extends Product
{
    protected $weight;

    public function __construct($data)
    {
        parent::__construct($data);

        // Validate the input data
        if (!isset($data['weight']) || empty($data['weight'])) {
            $this->errors['weight'] = 'Weight is missing';
        }

        if (count($this->errors)) {
            return Response::handle(['error' => 'Invalid data'] + ['errors' => $this->errors], 400);
        }

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

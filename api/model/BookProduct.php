<?php

namespace SWAPI\model;

use SWAPI\config\Response;
use SWAPI\model\Product;

class BookProduct extends Product
{
    protected $weight;

    public function __construct($data)
    {
        // Validate the input data
        $this->validate($data);

        // Verify if there is no errors
        if (!$this->verify()) {
            return Response::handle(['error' => 'Invalid data'] + ['errors' => $this->getErrors()], 400);
        }

        // Bind the input data
        $this->bind($data);
    }

    public function validate($data)
    {
        parent::validate($data);
        if ($this->isMissing('weight', $data)) {
            $this->setError('weight', 'Weight is missing');
        } else if ($this->isNotNumber('weight', $data)) {
            $this->setError('weight', 'Weight is not a number');
        }
    }

    public function bind($data)
    {
        parent::bind($data);
        $this->setWeight($data['weight']);
    }

    public function export()
    {
        $parentExport = parent::export();

        return array_merge($parentExport, [
            'weight' => $this->getWeight(),
        ]);
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

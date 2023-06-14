<?php

namespace SWAPI\model;

use SWAPI\config\Response;
use SWAPI\model\Product;

class DvdProduct extends Product
{
    protected $size;

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
        if ($this->isMissing('size', $data)) {
            $this->setError('size', 'Size is missing');
        } else if ($this->isNotNumber('size', $data)) {
            $this->setError('size', 'Size is not a number');
        }
    }

    public function bind($data)
    {
        parent::bind($data);
        $this->setSize($data['size']);
    }

    public function export()
    {
        $parentExport = parent::export();

        return array_merge($parentExport, [
            'size' => $this->getSize(),
        ]);
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

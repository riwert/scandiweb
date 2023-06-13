<?php

namespace SWAPI\model;

abstract class Model
{
    protected $errors = [];

    abstract public function validate($data);
    abstract public function bind($data);
    abstract public function save($service);

    public function getErrors()
    {
        return $this->errors;
    }

    public function setError($key, $value)
    {
        $this->errors[$key] = $value;
    }

    public function verify()
    {
        return !count($this->errors);
    }

    public function isMissing($key, $data)
    {
        return (!isset($data[$key]) || empty($data[$key]));
    }

    public function isNotNumber($key, $data)
    {
        $data[$key] = str_replace(',', '.', $data[$key]);
        return !is_numeric($data[$key]);
    }
}

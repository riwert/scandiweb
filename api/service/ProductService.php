<?php

namespace SWAPI\service;

use SWAPI\config\Database;
use SWAPI\config\Response;
use PDO;
use PDOException;
use Exception;
use Error;

class ProductService
{
    private $database;
    private $pdo;
    private $fields = [
        'sku',
        'name',
        'price',
        'productType',
        'size',
        'weight',
        'height',
        'length',
        'width',
    ];

    public function __construct()
    {
        try {
            $this->database = Database::getInstance();
            $this->pdo = $this->database->getConnection();
        } catch (PDOException | Exception | Error $e) {
            return Response::handle(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function saveDvdProduct($product)
    {
        try {
            if (!isset($product)) {
                throw new Exception('Invalid data', 400);
            }
            $stmt = $this->pdo->prepare('INSERT INTO products
                    (sku, name, price, productType, size)
                VALUES
                    (:sku, :name, :price, :productType, :size)
            ');
            $stmt->bindValue(':sku', $product->getSku());
            $stmt->bindValue(':name', $product->getName());
            $stmt->bindValue(':price', $product->getPrice());
            $stmt->bindValue(':productType', $product->getProductType());
            $stmt->bindValue(':size', $product->getSize());
            $stmt->execute();

            if ($stmt->rowCount()) {
                return Response::handle(['success' => 'Product added successfully'], 200);
            } else {
                return Response::handle(['error' => 'No product added'], 400);
            }
        } catch (PDOException | Exception | Error $e) {
            return Response::handle(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function saveBookProduct($product)
    {
        try {
            if (!isset($product)) {
                throw new Exception('Invalid data', 400);
            }
            $stmt = $this->pdo->prepare('INSERT INTO products
                    (sku, name, price, productType, weight)
                VALUES
                    (:sku, :name, :price, :productType, :weight)
            ');
            $stmt->bindValue(':sku', $product->getSku());
            $stmt->bindValue(':name', $product->getName());
            $stmt->bindValue(':price', $product->getPrice());
            $stmt->bindValue(':productType', $product->getProductType());
            $stmt->bindValue(':weight', $product->getWeight());
            $stmt->execute();

            if ($stmt->rowCount()) {
                return Response::handle(['success' => 'Product added successfully'], 200);
            } else {
                return Response::handle(['error' => 'No product added'], 400);
            }
        } catch (PDOException | Exception | Error $e) {
            return Response::handle(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function saveFurnitureProduct($product)
    {
        try {
            if (!isset($product)) {
                throw new Exception('Invalid data', 400);
            }
            $stmt = $this->pdo->prepare('INSERT INTO products
                    (sku, name, price, productType, height, length, width)
                VALUES
                    (:sku, :name, :price, :productType, :height, :length, :width)
            ');
            $stmt->bindValue(':sku', $product->getSku());
            $stmt->bindValue(':name', $product->getName());
            $stmt->bindValue(':price', $product->getPrice());
            $stmt->bindValue(':productType', $product->getProductType());
            $stmt->bindValue(':height', $product->getHeight());
            $stmt->bindValue(':length', $product->getLength());
            $stmt->bindValue(':width', $product->getWidth());
            $stmt->execute();

            if ($stmt->rowCount()) {
                return Response::handle(['success' => 'Product added successfully'], 200);
            } else {
                return Response::handle(['error' => 'No product added'], 400);
            }
        } catch (PDOException | Exception | Error $e) {
            return Response::handle(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function fetchProductBySku($sku)
    {
        try {
            if (!isset($sku)) {
                throw new Exception('Invalid data', 400);
            }
            $stmt = $this->pdo->prepare('SELECT '.implode(',', $this->fields).' FROM products WHERE sku=:sku LIMIT 1');
            $stmt->bindValue(':sku', $sku);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            return $product;
        } catch (PDOException | Exception | Error $e) {
            return Response::handle(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function deleteProductBySku($sku)
    {
        try {
            if (!isset($sku)) {
                throw new Exception('Invalid data', 400);
            }
            $stmt = $this->pdo->prepare('DELETE FROM products WHERE sku=:sku LIMIT 1');
            $stmt->bindValue(':sku', $sku);
            $stmt->execute();

            if ($stmt->rowCount()) {
                return Response::handle(['success' => 'Product deleted successfully'], 200);
            } else {
                return Response::handle(['error' => 'No product deleted'], 400);
            }
        } catch (PDOException | Exception | Error $e) {
            return Response::handle(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function massDeleteProductsBySkus($skus)
    {
        try {
            // Throw an exception for missing skus param
            if (!isset($skus)) {
                throw new Exception('Invalid data', 400);
            }

            // Extract comma separated skus from parameter
            $skus = explode(',', $skus);

            // Create an array of named parameters
            $namedParams = [];
            foreach ($skus as $index => $sku) {
                $paramName = ':sku' . $index;
                $namedParams[$paramName] = $sku;
            }

            // Create the placeholders for the named parameters
            $placeholders = implode(',', array_keys($namedParams));

            // Prepare the SQL statement with the dynamic placeholders
            $stmt = $this->pdo->prepare("DELETE FROM products WHERE sku IN ($placeholders)");
            foreach ($namedParams as $paramName => $value) {
                $stmt->bindValue($paramName, $value);
            }
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                return Response::handle(['success' => 'Product deleted successfully'], 200);
            } else if ($stmt->rowCount()) {
                return Response::handle(['success' => 'Products deleted successfully ('.$stmt->rowCount().')'], 200);
            } else {
                return Response::handle(['error' => 'No products deleted'], 400);
            }
        } catch (PDOException | Exception | Error $e) {
            return Response::handle(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function getAllProducts()
    {
        try {
            $stmt = $this->pdo->query('SELECT '.implode(',', $this->fields).' FROM products');
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $products;
        } catch (PDOException $e) {
            return Response::handle(['error' => $e->getMessage()], $e->getCode());
        }
    }
}

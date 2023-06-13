<?php

namespace SWAPI\config;

use PDO;

class Database
{
    private static $instance;
    private $pdo;
    private $host;
    private $username;
    private $password;
    private $database;

    private function __construct()
    {
        $this->host = getenv('DB_HOST');
        $this->username = getenv('DB_USER');
        $this->password = getenv('DB_PASS');
        $this->database = getenv('DB_NAME');

        $dsn = "mysql:host=$this->host;dbname=$this->database";
        $this->pdo = new PDO($dsn, $this->username, $this->password, [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        ]);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}

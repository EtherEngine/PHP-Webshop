<?php

class Database
{
    private $pdo;

    public function __construct($host, $webshop, $root, $password)
    {
        $dsn = "mysql:host=$host;webshop=$webshop;charset=utf8";
        $this->pdo = new PDO($dsn, $root, $password);
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}

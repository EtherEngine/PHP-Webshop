<?php

class Database
{
    private $pdo;

    public function __construct($host, $webshop, $root)
    {
        $dsn = "mysql:host=$host;webshop=$webshop;charset=utf8";
        $this->pdo = new PDO($dsn, $root);
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}

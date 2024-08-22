<?php

class Order
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=your_db', 'username', 'password');
    }

    public function getAllOrders()
    {
        $stmt = $this->pdo->query('SELECT * FROM orders');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

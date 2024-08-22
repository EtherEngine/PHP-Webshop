<?php

class SalesReport
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=your_db', 'username', 'password');
    }

    public function getReport()
    {
        $stmt = $this->pdo->query('SELECT product_id, SUM(quantity) as total_sold FROM order_items GROUP BY product_id');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

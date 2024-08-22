<?php

class Product
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=your_db', 'username', 'password');
    }

    public function add($data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO products (name, description, price, image, stock) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$data['name'], $data['description'], $data['price'], $data['image'], $data['stock']]);
    }

    public function edit($productId, $data)
    {
        $stmt = $this->pdo->prepare('UPDATE products SET name = ?, description = ?, price = ?, image = ?, stock = ? WHERE id = ?');
        $stmt->execute([$data['name'], $data['description'], $data['price'], $data['image'], $data['stock'], $productId]);
    }

    public function delete($productId)
    {
        $stmt = $this->pdo->prepare('DELETE FROM products WHERE id = ?');
        $stmt->execute([$productId]);
    }
}

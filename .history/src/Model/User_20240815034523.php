<?php

class User
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=your_db', 'username', 'password');
    }

    public function toggleStatus($userId)
    {
        $stmt = $this->pdo->prepare('SELECT status FROM users WHERE id = ?');
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $newStatus = ($user['status'] === 'active') ? 'inactive' : 'active';
        $updateStmt = $this->pdo->prepare('UPDATE users SET status = ? WHERE id = ?');
        $updateStmt->execute([$newStatus, $userId]);

        return $newStatus;
    }
}


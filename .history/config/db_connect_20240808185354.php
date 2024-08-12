<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=webshop', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    die('Verbindung zur Datenbank fehlgeschlagen: ' . $e->getMessage());
}
?>
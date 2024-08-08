<?php
session_start();
require __DIR__ . '/../config/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Leiten Sie den Benutzer zu PayPal weiter
echo "<h2>Sie werden zu PayPal weitergeleitet...</h2>";
// Hier sollte die Logik zur Weiterleitung zu PayPal eingefügt werden.
?>
<?php
session_start();
require __DIR__ . '/../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $shipping_address = $_POST['shipping_address'];
    $payment_method = $_POST['payment_method'];
    $cart = $_SESSION['cart'];
    $total_price = 0;

    foreach ($cart as $item) {
        $total_price += $item['price'] * $item['quantity'];
    }

    // Bestellung in der Datenbank speichern
    $stmt = $db->prepare("INSERT INTO orders (user_id, total_price, order_date, status, shipping_address, payment_method) VALUES (?, ?, NOW(), 'pending', ?, ?)");
    $stmt->bind_param("idsss", $user_id, $total_price, $shipping_address, $payment_method);
    $stmt->execute();

    // Bestellung erfolgreich gespeichert
    if ($stmt->affected_rows > 0) {
        // Bestellung erfolgreich -> Warenkorb leeren
        unset($_SESSION['cart']);
        header("Location: order_success.php");
    } else {
        // Fehler beim Speichern der Bestellung
        echo "Fehler bei der Bestellung.";
    }
}

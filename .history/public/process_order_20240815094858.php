<?php
session_start();
require __DIR__ . '/../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $street = $_POST['street'];
    $housenumber = $_POST['housenumber'];
    $city = $_POST['city'];
    $zipcode = $_POST['zipcode'];
    $country = $_POST['country'];
    $payment_method = $_POST['payment_method'];
    $cart = $_SESSION['cart'];
    $total_price = 0;

    foreach ($cart as $item) {
        $total_price += $item['price'] * $item['quantity'];
    }

    // Bestellung in der Datenbank speichern
    $stmt = $pdo->prepare("
        INSERT INTO orders (user_id, total_price, order_date, status, payment_method, firstname, lastname, street, housenumber, city, zipcode, country) 
        VALUES (?, ?, NOW(), 'pending', ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$user_id, $total_price, $payment_method, $firstname, $lastname, $street, $housenumber, $city, $zipcode, $country]);

    // Bestellung erfolgreich gespeichert
    if ($stmt->rowCount() > 0) {
        // Bestellung erfolgreich -> Warenkorb leeren
        unset($_SESSION['cart']);
        header("Location: order_success.php");
    } else {
        // Fehler beim Speichern der Bestellung
        echo "Fehler bei der Bestellung.";
    }
}

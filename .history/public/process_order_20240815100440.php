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

    // Speichern oder Aktualisieren der Benutzerdaten in der users-Tabelle
    $stmt = $pdo->prepare("
        UPDATE users 
        SET firstname = ?, lastname = ?, street = ?, housenumber = ?, city = ?, zipcode = ?, country = ? 
        WHERE id = ?
    ");
    $stmt->execute([$firstname, $lastname, $street, $housenumber, $city, $zipcode, $country, $user_id]);

    // Bestellung in der orders-Tabelle speichern
    $stmt = $pdo->prepare("
        INSERT INTO orders (user_id, total_price, order_date, status, payment_method, firstname, lastname, street, housenumber, city, zipcode, country) 
        VALUES (?, ?, NOW(), 'pending', ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$user_id, $total_price, $payment_method, $firstname, $lastname, $street, $housenumber, $city, $zipcode, $country]);

    // Abrufen der zuletzt eingefügten Bestell-ID
    $order_id = $pdo->lastInsertId();

    // Bestellpositionen in der order_items-Tabelle speichern
    $stmt = $pdo->prepare("
        INSERT INTO order_items (order_id, product_id, quantity, price) 
        VALUES (?, ?, ?, ?)
    ");
    foreach ($cart as $item) {
        $product_id = $item['id']; // Annahme: Jedes Element im Warenkorb hat eine 'id', die sich auf die products.id bezieht
        $quantity = $item['quantity'];
        $price = $item['price'];

        $stmt->execute([$order_id, $product_id, $quantity, $price]);
    }

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

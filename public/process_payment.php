<?php
session_start();
require __DIR__ . '/../config/db_connect.php';

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$payment_method = $_POST['payment_method'];
$total = 0;

// Berechnen der Gesamtsumme
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product) {
        $total += $product['price'] * $product['quantity'];
    }
}

switch ($payment_method) {
    case 'paypal':
        header('Location: paypal_payment.php');
        exit;
    case 'credit_card':
        header('Location: credit_card_payment.php');
        exit;
    case 'bank_transfer':
        // Senden Sie eine E-Mail mit den Banküberweisungsinformationen
        $user_email = $_SESSION['user_email']; // Vorausgesetzt, die E-Mail des Benutzers ist in der Session gespeichert
        $subject = "Banküberweisungsinformationen";
        $message = "Bitte überweisen Sie den Betrag von " . number_format($total, 2, ',', '.') . " € an die folgende Bankverbindung: [Bankinformationen].";
        $headers = "From: webshop@example.com";

        mail($user_email, $subject, $message, $headers);

        header('Location: bank_transfer_confirmation.php');
        exit;
    default:
        echo "Ungültige Zahlungsmethode.";
        exit;
}
?>
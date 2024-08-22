<?php
session_start();
require __DIR__ . '/../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Eingabevalidierung
    $user_id = $_SESSION['user_id'] ?? null;
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $street = trim($_POST['street']);
    $housenumber = trim($_POST['housenumber']);
    $city = trim($_POST['city']);
    $zipcode = trim($_POST['zipcode']);
    $country = trim($_POST['country']);
    $payment_method = trim($_POST['payment_method']);
    $cart = $_SESSION['cart'] ?? [];
    $total_price = 0;

    // Berechnung des Gesamtpreises
    foreach ($cart as $item) {
        $total_price += $item['price'] * $item['quantity'];
    }

    // Datenbankoperationen in einer Transaktion zusammenfassen
    $pdo->beginTransaction();

    try {
        // Speichern oder Aktualisieren der Benutzerdaten
        $stmt = $pdo->prepare("
            UPDATE users 
            SET firstname = ?, lastname = ?, street = ?, housenumber = ?, city = ?, zipcode = ?, country = ? 
            WHERE id = ?
        ");
        $stmt->execute([$firstname, $lastname, $street, $housenumber, $city, $zipcode, $country, $user_id]);

        // Bestellung in der orders-Tabelle speichern
        $stmt = $pdo->prepare("
            INSERT INTO orders (user_id, total_price, payment_method, created_at) 
            VALUES (?, ?, ?, NOW())
        ");
        $stmt->execute([$user_id, $total_price, $payment_method]);
        $order_id = $pdo->lastInsertId();

        // Bestelldetails in der order_details-Tabelle speichern
        $stmt = $pdo->prepare("
            INSERT INTO order_details (order_id, product_id, quantity, price) 
            VALUES (?, ?, ?, ?)
        ");
        foreach ($cart as $item) {
            $stmt->execute([$order_id, $item['id'], $item['quantity'], $item['price']]);
        }

        // Transaktion abschließen
        $pdo->commit();

        // Erfolgreiche Bestellung
        $_SESSION['success_message'] = "Bestellung erfolgreich abgeschlossen!";
        header("Location: success.php");
        exit;

    } catch (Exception $e) {
        // Bei einem Fehler: Transaktion zurückrollen
        $pdo->rollBack();
        $_SESSION['error_message'] = "Fehler bei der Bearbeitung Ihrer Bestellung.";
        header("Location: error.php");
        exit;
    }
} else {
    // Bei ungültiger Anfrage: Fehlermeldung anzeigen
    $_SESSION['error_message'] = "Ungültige Anfrage.";
    header("Location: error.php");
    exit;
}
?>
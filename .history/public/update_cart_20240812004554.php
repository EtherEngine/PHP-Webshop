<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = (int) $_POST['quantity'];

    if (isset($_SESSION['cart'][$product_id])) {
        if ($quantity > 0) {
            $_SESSION['cart'][$product_id]['quantity'] = $quantity;
        } else {
            unset($_SESSION['cart'][$product_id]); // Entferne das Produkt, wenn die Menge 0 ist
        }

        // Berechne den neuen Gesamtbetrag
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        echo json_encode(['status' => 'success', 'total' => number_format($total, 2, ',', '.')]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Produkt nicht im Warenkorb gefunden']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Ungültige Anfrage']);
}
?>
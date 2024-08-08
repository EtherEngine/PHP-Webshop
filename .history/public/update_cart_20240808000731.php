<?php
session_start();
require __DIR__ . '/../config/db_connect.php';

$response = ['success' => false, 'total' => 0];

if (isset($_POST['id']) && isset($_POST['quantity'])) {
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];

    // Update quantity in session cart
    foreach ($_SESSION['cart'] as &$product) {
        if ($product['id'] == $id) {
            $product['quantity'] = $quantity;
            break;
        }
    }

    // Recalculate total
    $response['total'] = 0;
    foreach ($_SESSION['cart'] as $product) {
        $response['total'] += $product['price'] * $product['quantity'];
    }

    $response['success'] = true;
}

echo json_encode($response);
?>
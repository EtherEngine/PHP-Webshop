<?php

// Start the session to manage user sessions and cart
session_start();

// Include the database connection file from the config directory
require __DIR__ . '/../config/db_connect.php';

// Check if the cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $cart_empty = true;
} else {
    $cart_empty = false;
    $cart = $_SESSION['cart'];
}

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warenkorb</title>
    <!-- Übernehme die gleichen Stylesheets und Skripte wie in der index.php -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .btn-custom,
        .btn-cart,
        .btn-success,
        .btn-danger {
            background: linear-gradient(to bottom, #333, #666);
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 1em;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .btn-custom:hover,
        .btn-cart:hover,
        .btn-danger:hover {
            background: linear-gradient(to bottom, #111, #444);
            color: white;
        }

        .btn-success {
            background: linear-gradient(to bottom, #28a745, #218838);
        }

        .btn-success:hover {
            background: linear-gradient(to bottom, #218838, #1e7e34);
        }

        .btn-danger {
            background: linear-gradient(to bottom, #dc3545, #c82333);
        }

        .btn-danger:hover {
            background: linear-gradient(to bottom, #c82333, #bd2130);
        }
    </style>
</head>

<body>
    <?php include '../src/View/templates/header.php'; ?>
    <?php include '../src/View/templates/navigation.php'; ?>

    <div class="container mt-5">
        <h1>Warenkorb</h1>

        <?php if ($cart_empty): ?>
            <p>Ihr Warenkorb ist leer.</p>
            <a href="index.php" class="btn btn-custom">Zurück zum Shop</a>
        <?php else: ?>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Bild</th>
                        <th>Produktname</th>
                        <th>Preis</th>
                        <th>Menge</th>
                        <th>Gesamt</th>
                        <th>Aktion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($cart as $item):
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                        ?>
                        <tr>
                            <td><img src="../assets/images/<?php echo htmlspecialchars($item['image']); ?>"
                                    alt="<?php echo htmlspecialchars($item['name']); ?>" style="height: 60px;"></td>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo number_format($item['price'], 2, ',', '.'); ?> €</td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo number_format($subtotal, 2, ',', '.'); ?> €</td>
                            <td>
                                <a href="remove_from_cart.php?id=<?php echo $item['id']; ?>"
                                    class="btn btn-danger btn-sm">Entfernen</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right">Gesamt:</td>
                        <td><?php echo number_format($total, 2, ',', '.'); ?> €</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            <div class="text-right">
                <a href="index.php" class="btn btn-custom">Weiter einkaufen</a>
                <a href="payment_integration.php" class="btn btn-success">Zur Kasse</a>
            </div>
        <?php endif; ?>
    </div>

    <?php include '../src/View/templates/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
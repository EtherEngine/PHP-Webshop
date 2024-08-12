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
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .btn-primary {
            background: linear-gradient(to bottom, #333, #666);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(to bottom, #111, #444);
            color: white;
        }

        .card-body {
            position: relative;
            padding: 15px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .quantity-popup {
            display: none;
            position: absolute;
            bottom: 45px;
            right: 10px;
            background-color: white;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 2000;
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
        <?php else: ?>
            <table class="table">
                <thead>
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
                                    alt="<?php echo htmlspecialchars($item['name']); ?>" style="height: 50px;"></td>
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
                        <td colspan="4" class="text-right"><strong>Gesamt:</strong></td>
                        <td><?php echo number_format($total, 2, ',', '.'); ?> €</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            <a href="checkout.php" class="btn btn-success">Zur Kasse</a>
        <?php endif; ?>
    </div>

    <?php include '../src/View/templates/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
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
        /* Custom styles to match the index.php */
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 50px;
            max-width: 900px;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 28px;
            margin-bottom: 30px;
            font-weight: 700;
            text-align: center;
            color: #333;
        }

        .table {
            margin-bottom: 30px;
        }

        .table th,
        .table td {
            vertical-align: middle;
            text-align: center;
        }

        .table img {
            height: 60px;
            border-radius: 5px;
        }

        .btn-custom,
        .btn-danger,
        .btn-success {
            background: linear-gradient(to bottom, #333, #666);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            transition: background 0.3s ease;
        }

        .btn-custom:hover,
        .btn-danger:hover,
        .btn-success:hover {
            background: linear-gradient(to bottom, #111, #444);
            color: white;
        }

        .total-row {
            font-weight: bold;
            font-size: 18px;
            color: #333;
        }

        .empty-cart {
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
        }

        .empty-cart img {
            height: 150px;
            margin-bottom: 20px;
        }

        .text-right {
            display: flex;
            justify-content: flex-end;
        }

        .text-right a {
            margin-left: 10px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .table img {
                height: 40px;
            }

            .btn-custom,
            .btn-danger,
            .btn-success {
                padding: 5px 10px;
                font-size: 12px;
            }

            .text-right {
                flex-direction: column;
                align-items: center;
            }

            .text-right a {
                margin: 5px 0;
            }
        }
    </style>
</head>

<body>
    <?php include '../src/View/templates/header.php'; ?>
    <?php include '../src/View/templates/navigation.php'; ?>

    <div class="container">
        <h1>Warenkorb</h1>

        <?php if ($cart_empty): ?>
            <div class="empty-cart">
                <img src="../assets/images/empty_cart.png" alt="Empty Cart">
                <p>Ihr Warenkorb ist leer.</p>
                <a href="index.php" class="btn btn-custom">Zurück zum Shop</a>
            </div>
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
                                    alt="<?php echo htmlspecialchars($item['name']); ?>"></td>
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
                    <tr class="total-row">
                        <td colspan="4" class="text-right">Gesamt:</td>
                        <td><?php echo number_format($total, 2, ',', '.'); ?> €</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            <div class="text-right">
                <a href="index.php" class="btn btn-custom">Weiter einkaufen</a>
                <a href="checkout.php" class="btn btn-success">Zur Kasse</a>
            </div>
        <?php endif; ?>
    </div>

    <?php include '../src/View/templates/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
<?php
// Start the session to manage user sessions and cart
session_start();

// Include the database connection file from the config directory
require __DIR__ . '/../config/db_connect.php';

// Initialisiere den Warenkorb
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Überprüfe, ob der Warenkorb leer ist
$cart_empty = empty($cart);

// Berechne die Gesamtsumme
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warenkorb</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Mengeneingabe-Design */
        .quantity-controls {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quantity-controls .btn {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 0 10px;
            border-radius: 5px;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 38px;
            width: 38px;
            margin: 0 5px;
            transition: background-color 0.3s ease;
        }

        .quantity-controls .btn:hover {
            background-color: #555;
        }

        .quantity-controls .quantity-input {
            width: 60px;
            text-align: center;
            border-radius: 5px;
            border: 1px solid #ccc;
            padding: 5px;
            font-size: 16px;
            margin: 0 5px;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            transition: background-color 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            transition: background-color 0.3s ease;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
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
                    foreach ($cart as $item):
                        $subtotal = $item['price'] * $item['quantity'];
                        ?>
                        <tr>
                            <td><img src="../assets/images/<?php echo htmlspecialchars($item['image']); ?>"
                                    alt="<?php echo htmlspecialchars($item['name']); ?>" style="height: 60px;"></td>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo number_format($item['price'], 2, ',', '.'); ?> €</td>
                            <td class="quantity-controls">
                                <button class="btn decrease-quantity" data-id="<?php echo $item['id']; ?>">-</button>
                                <input type="text" class="form-control quantity-input" value="<?php echo $item['quantity']; ?>"
                                    data-id="<?php echo $item['id']; ?>">
                                <button class="btn increase-quantity" data-id="<?php echo $item['id']; ?>">+</button>
                            </td>
                            <td class="item-total"><?php echo number_format($subtotal, 2, ',', '.'); ?> €</td>
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
                        <td id="cart-total"><?php echo number_format($total, 2, ',', '.'); ?> €</td>
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
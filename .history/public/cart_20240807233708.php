<?php
session_start();
require __DIR__ . '/../config/db_connect.php';

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Produkte aus dem Warenkorb entfernen
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    foreach ($_SESSION['cart'] as $key => $product) {
        if ($product['id'] == $remove_id) {
            unset($_SESSION['cart'][$key]);
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    header('Location: cart.php');
    exit;
}

// Berechnen der Gesamtsumme
$total = 0;
foreach ($_SESSION['cart'] as $product) {
    $total += $product['price'] * $product['quantity'];
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
    <style>
        .container {
            margin-top: 50px;
        }

        .cart-item {
            border-bottom: 1px solid #ddd;
            padding: 20px 0;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item img {
            width: 100px;
        }

        .cart-item h5 {
            margin: 0;
        }

        .cart-item .price {
            font-size: 1.2em;
            color: #333;
        }

        .cart-item .quantity {
            width: 60px;
        }

        .cart-total {
            font-size: 1.5em;
            text-align: right;
        }

        .cart-total .total-price {
            color: #333;
        }

        .btn-remove {
            color: #ff0000;
        }

        .btn-remove:hover {
            color: #cc0000;
        }

        .btn-checkout {
            background: linear-gradient(to bottom, #333, #666);
            border: none;
            color: white;
        }

        .btn-checkout:hover {
            background: linear-gradient(to bottom, #111, #444);
        }

        .btn-back {
            background: linear-gradient(to bottom, #333, #666);
            border: none;
            color: white;
        }

        .btn-back:hover {
            background: linear-gradient(to bottom, #111, #444);
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Warenkorb</h2>
        <?php if (empty($_SESSION['cart'])): ?>
            <p>Ihr Warenkorb ist leer.</p>
        <?php else: ?>
            <div class="cart-items">
                <?php foreach ($_SESSION['cart'] as $product): ?>
                    <div class="row cart-item">
                        <div class="col-md-2">
                            <img src="../assets/images/<?php echo htmlspecialchars($product['image']); ?>"
                                alt="<?php echo htmlspecialchars($product['name']); ?>">
                        </div>
                        <div class="col-md-4">
                            <h5><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="price"><?php echo number_format($product['price'], 2, ',', '.'); ?> €</p>
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control quantity"
                                value="<?php echo htmlspecialchars($product['quantity']); ?>" readonly>
                        </div>
                        <div class="col-md-2">
                            <p class="price"><?php echo number_format($product['price'] * $product['quantity'], 2, ',', '.'); ?>
                                €</p>
                        </div>
                        <div class="col-md-2 text-right">
                            <a href="cart.php?remove=<?php echo $product['id']; ?>"
                                class="btn btn-link btn-remove">Entfernen</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="cart-total">
                Gesamt: <span class="total-price"><?php echo number_format($total, 2, ',', '.'); ?> €</span>
            </div>
            <div class="mt-4">
                <a href="index.php" class="btn btn-back">Zurück zum Shop</a>
                <a href="payment_integration.php" class="btn btn-checkout float-right">Zur Kasse</a>
            </div>
        <?php endif; ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
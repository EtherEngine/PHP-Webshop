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
            display: flex;
            align-items: center;
            transition: background-color 0.3s;
        }

        .cart-item:hover {
            background-color: #f9f9f9;
        }

        .cart-item img {
            width: 100px;
            height: auto;
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
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }

        .cart-total .total-price {
            color: #333;
            font-weight: bold;
        }

        .btn-remove {
            color: #ff0000;
            text-decoration: none;
        }

        .btn-remove:hover {
            color: #cc0000;
        }

        .btn-checkout {
            background: linear-gradient(to bottom, #28a745, #218838);
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 1.2em;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .btn-checkout:hover {
            background: linear-gradient(to bottom, #218838, #1e7e34);
        }

        .btn-back {
            background: linear-gradient(to bottom, #17a2b8, #138496);
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 1.2em;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .btn-back:hover {
            background: linear-gradient(to bottom, #138496, #117a8b);
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
                    <div class="cart-item">
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
            <div class="mt-4 d-flex justify-content-between">
                <a href="index.php" class="btn btn-back">Zurück zum Shop</a>
                <a href="payment_integration.php" class="btn btn-checkout">Zur Kasse</a>
            </div>
        <?php endif; ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
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
function calculateTotal()
{
    $total = 0;
    foreach ($_SESSION['cart'] as $product) {
        $total += $product['price'] * $product['quantity'];
    }
    return $total;
}

$total = calculateTotal();

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

        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .cart-header h2 {
            margin: 0;
        }

        .cart-header img {
            height: 30px;
        }

        .cart-item {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
            display: flex;
            align-items: center;
            transition: background-color 0.3s;
            font-size: 0.9em;
        }

        .cart-item:hover {
            background-color: #f9f9f9;
        }

        .cart-item img {
            width: 80px;
            height: auto;
        }

        .cart-item h5 {
            margin: 0;
        }

        .cart-item .price {
            font-size: 1.1em;
            color: #333;
        }

        .cart-item .quantity-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .cart-item .quantity {
            width: 60px;
            text-align: center;
            padding-right: 20px;
        }

        .cart-item .quantity-buttons {
            display: flex;
            flex-direction: column;
            position: absolute;
            right: 0;
            height: 100%;
            justify-content: center;
        }

        .cart-item .quantity-buttons button {
            background: none;
            border: none;
            font-size: 1.2em;
            cursor: pointer;
            padding: 0;
        }

        .cart-item .quantity-buttons button:focus {
            outline: none;
        }

        .cart-total {
            font-size: 1.3em;
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

        .btn-checkout,
        .btn-back {
            background: linear-gradient(to bottom, #333, #666);
            border: none;
            color: white;
            padding: 8px 16px;
            font-size: 1em;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .btn-checkout:hover,
        .btn-back:hover {
            background: linear-gradient(to bottom, #111, #444);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="cart-header">
            <a href="index.php">
                <img src="../assets/images/Gruppenlogo_rund1.png" alt="Gruppenlogo">
            </a>
            <h2>Warenkorb</h2>
        </div>
        <?php if (empty($_SESSION['cart'])): ?>
            <p>Ihr Warenkorb ist leer.</p>
        <?php else: ?>
            <div class="cart-items">
                <?php foreach ($_SESSION['cart'] as $product): ?>
                    <div class="cart-item" data-id="<?php echo $product['id']; ?>">
                        <div class="col-md-2">
                            <img src="../assets/images/<?php echo htmlspecialchars($product['image']); ?>"
                                alt="<?php echo htmlspecialchars($product['name']); ?>">
                        </div>
                        <div class="col-md-4">
                            <h5><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="price" data-price="<?php echo $product['price']; ?>">
                                <?php echo number_format($product['price'], 2, ',', '.'); ?> €</p>
                        </div>
                        <div class="col-md-2 quantity-wrapper">
                            <input type="number" class="form-control quantity"
                                value="<?php echo htmlspecialchars($product['quantity']); ?>" min="1">
                            <div class="quantity-buttons">
                                <button class="quantity-up">+</button>
                                <button class="quantity-down">-</button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <p class="price item-total">
                                <?php echo number_format($product['price'] * $product['quantity'], 2, ',', '.'); ?> €</p>
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.quantity').on('change', function () {
                updateQuantity($(this));
            });

            $('.quantity-up').on('click', function () {
                var $input = $(this).closest('.quantity-wrapper').find('.quantity');
                $input.val(parseInt($input.val()) + 1);
                updateQuantity($input);
            });

            $('.quantity-down').on('click', function () {
                var $input = $(this).closest('.quantity-wrapper').find('.quantity');
                if (parseInt($input.val()) > 1) {
                    $input.val(parseInt($input.val()) - 1);
                    updateQuantity($input);
                }
            });

            function updateQuantity($input) {
                var $row = $input.closest('.cart-item');
                var id = $row.data('id');
                var quantity = $input.val();

                // Update quantity in the session
                $.ajax({
                    url: 'update_cart.php',
                    method: 'POST',
                    data: {
                        id: id,
                        quantity: quantity
                    },
                    success: function (response) {
                        if (response.success) {
                            var price = parseFloat($row.find('.price').data('price'));
                            var itemTotal = price * quantity;
                            $row.find('.item-total').text(itemTotal.toFixed(2).replace('.', ',') + ' €');
                            $('.total-price').text(response.total.toFixed(2).replace('.', ',') + ' €');
                        } else {
                            alert('Fehler beim Aktualisieren des Warenkorbs');
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>
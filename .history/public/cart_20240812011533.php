<?php
session_start();

require __DIR__ . '/../config/db_connect.php';

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
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
    <style>
        .quantity-btn {
            width: 32px;
            height: 32px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: inline-block;
            text-align: center;
            line-height: 32px;
            font-size: 18px;
            margin: 0 5px;
        }

        .quantity-btn:hover {
            background-color: #555;
        }

        .remove-btn {
            background-color: transparent;
            border: none;
            color: #dc3545;
            cursor: pointer;
            font-size: 18px;
            margin-left: 10px;
        }

        .remove-btn:hover {
            color: #c82333;
        }

        .remove-btn::before {
            content: '✖';
        }

        .btn-checkout {
            background-color: #f4a261;
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 1em;
            border-radius: 5px;
            transition: background 0.3s;
            margin-top: 20px;
            float: right;
        }

        .btn-checkout:hover {
            background-color: #e68a4f;
        }

        .btn-back-to-shop {
            background: linear-gradient(to bottom, #333, #666);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1em;
            transition: background 0.3s;
            margin-top: 20px;
            float: left;
        }

        .btn-back-to-shop:hover {
            background: linear-gradient(to bottom, #111, #444);
            color: white;
        }
    </style>
</head>

<body>
    <?php include '../src/View/templates/header.php'; ?>
    <?php include '../src/View/templates/navigation.php'; ?>

    <div class="container mt-5">
        <h1>Warenkorb</h1>
        <?php if (!empty($cart)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Produkt</th>
                        <th>Preis</th>
                        <th>Menge</th>
                        <th>Gesamt</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="cart-items">
                    <?php foreach ($cart as $product_id => $item): ?>
                        <tr data-id="<?php echo $product_id; ?>" data-price="<?php echo $item['price']; ?>">
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo number_format($item['price'], 2, ',', '.'); ?> €</td>
                            <td>
                                <button class="quantity-btn minus-btn">-</button>
                                <span class="quantity"><?php echo $item['quantity']; ?></span>
                                <button class="quantity-btn plus-btn">+</button>
                            </td>
                            <td class="item-total"><?php echo number_format($item['price'] * $item['quantity'], 2, ',', '.'); ?>
                                €</td>
                            <td><button class="remove-btn"></button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right"><strong>Gesamtsumme:</strong></td>
                        <td colspan="2" id="total"><?php echo number_format($total, 2, ',', '.'); ?> €</td>
                    </tr>
                </tfoot>
            </table>
            <div class="clearfix">
                <a href="index.php" class="btn-back-to-shop">Zurück zum Shop</a>
                <a href="payment_integration.php" class="btn-checkout">Zur Kasse</a>
            </div>
        <?php else: ?>
            <p>Ihr Warenkorb ist leer.</p>
        <?php endif; ?>
    </div>

    <?php include '../src/View/templates/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            function updateCart(product_id, quantity) {
                $.ajax({
                    url: 'update_cart.php',
                    type: 'POST',
                    data: {
                        product_id: product_id,
                        quantity: quantity
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            let row = $('tr[data-id="' + product_id + '"]');
                            row.find('.quantity').text(quantity);
                            let itemTotal = (parseFloat(row.data('price')) * quantity).toFixed(2).replace('.', ',');
                            row.find('.item-total').text(itemTotal + ' €');
                            $('#total').text(response.total + ' €');
                        } else {
                            alert(response.message);
                        }
                    }
                });
            }

            $('.plus-btn').on('click', function () {
                let row = $(this).closest('tr');
                let product_id = row.data('id');
                let quantity = parseInt(row.find('.quantity').text()) + 1;

                updateCart(product_id, quantity);
            });

            $('.minus-btn').on('click', function () {
                let row = $(this).closest('tr');
                let product_id = row.data('id');
                let quantity = parseInt(row.find('.quantity').text()) - 1;

                if (quantity >= 1) {
                    updateCart(product_id, quantity);
                }
            });

            $('.remove-btn').on('click', function () {
                let row = $(this).closest('tr');
                let product_id = row.data('id');

                updateCart(product_id, 0);
                row.remove();
            });
        });
    </script>
</body>

</html>
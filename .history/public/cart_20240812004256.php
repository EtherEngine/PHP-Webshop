<?php
// Start the session to manage user sessions and cart
session_start();

// Include the database connection file from the config directory
require __DIR__ . '/../config/db_connect.php';

// Initialize the cart
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Check if the cart is empty
$cart_empty = empty($cart);

// Function to calculate the total
function calculateTotal($cart)
{
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}

$total = calculateTotal($cart);
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
        /* Styling for quantity controls */
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
            border-radius: 3px;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 30px;
            width: 30px;
            margin: 0 5px;
            transition: background-color 0.3s ease;
        }

        .quantity-controls .btn:hover {
            background-color: #555;
        }

        .quantity-controls .quantity-input {
            width: 50px;
            text-align: center;
            border-radius: 3px;
            border: 1px solid #ccc;
            padding: 5px;
            font-size: 14px;
            margin: 0 5px;
        }

        .btn-danger {
            background-color: transparent;
            border: none;
            color: red;
            font-size: 16px;
            transition: color 0.3s ease;
        }

        .btn-danger:hover {
            color: darkred;
            text-decoration: none;
        }

        .btn-danger::after {
            content: "x";
        }

        .btn-danger:hover::after {
            content: " Entfernen";
            color: darkred;
            font-size: 12px;
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
                                    data-id="<?php echo $item['id']; ?>" readonly>
                                <button class="btn increase-quantity" data-id="<?php echo $item['id']; ?>">+</button>
                            </td>
                            <td class="item-total"><?php echo number_format($subtotal, 2, ',', '.'); ?> €</td>
                            <td>
                                <a href="#" class="btn btn-danger remove-item" data-id="<?php echo $item['id']; ?>"></a>
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
    <script>
        $(document).ready(function () {
            function updateCartQuantity(id, quantity) {
                $.ajax({
                    type: 'POST',
                    url: 'update_cart.php',
                    data: { product_id: id, quantity: quantity },
                    success: function (response) {
                        if (response.status === 'success') {
                            location.reload();
                        }
                    }
                });
            }

            $('.increase-quantity').on('click', function () {
                var id = $(this).data('id');
                var input = $(this).siblings('.quantity-input');
                var newQuantity = parseInt(input.val()) + 1;
                input.val(newQuantity);
                updateCartQuantity(id, newQuantity);
            });

            $('.decrease-quantity').on('click', function () {
                var id = $(this).data('id');
                var input = $(this).siblings('.quantity-input');
                var newQuantity = parseInt(input.val()) - 1;
                if (newQuantity > 0) {
                    input.val(newQuantity);
                    updateCartQuantity(id, newQuantity);
                }
            });

            $('.remove-item').on('click', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                updateCartQuantity(id, 0);
            });
        });
    </script>
</body>

</html>
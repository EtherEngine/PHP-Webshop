<?php
session_start(); // Starts a new session or resumes the existing session.

// Includes the database connection script.
require __DIR__ . '/../config/db_connect.php';

// Retrieves the cart from the session, or initializes it as an empty array if not set.
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0;

// Calculates the total price of all items in the cart.
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8"> <!-- Specifies the character encoding for the HTML document. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Sets the viewport for responsive web design. -->
    <title>Warenkorb</title> <!-- Title of the webpage. -->
    <link rel="stylesheet" href="assets/css/style.css"> <!-- Links to an external stylesheet. -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Links to Bootstrap CSS. -->
    <style>
        /* CSS Variables for button styling */
        :root {
            --btn-bg-color: #888;
            --btn-hover-bg-color: #aaa;
            --btn-color: #fff;
            --btn-border-radius: 3px;
            --btn-width: 24px;
            --btn-height: 24px;
            --btn-font-size: 14px;
            --btn-margin: 0 2px;
        }

        /* Styles for quantity buttons */
        .quantity-btn {
            width: var(--btn-width);
            height: var(--btn-height);
            background-color: var(--btn-bg-color);
            color: var(--btn-color);
            border: none;
            border-radius: var(--btn-border-radius);
            cursor: pointer;
            display: inline-block;
            text-align: center;
            line-height: var(--btn-height);
            font-size: var(--btn-font-size);
            margin: var(--btn-margin);
            box-shadow: none;
            transition: background-color 0.2s;
        }

        /* Hover effect for quantity buttons */
        .quantity-btn:hover {
            background-color: var(--btn-hover-bg-color);
        }

        /* Active state for quantity buttons */
        .quantity-btn:active {
            background-color: var(--btn-hover-bg-color);
            transform: none;
        }

        /* Styles for remove button */
        .remove-btn {
            background-color: transparent;
            border: none;
            color: #dc3545;
            cursor: pointer;
            font-size: 16px;
            margin-left: 10px;
            transition: color 0.3s;
        }

        /* Hover effect for remove button */
        .remove-btn:hover {
            color: #c82333;
        }

        /* Custom content (✖) for remove button */
        .remove-btn::before {
            content: '✖';
        }

        /* Styles for checkout button */
        .btn-checkout {
            background-color: #cd5c5c;
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 1em;
            border-radius: 5px;
            transition: background 0.3s;
            margin-top: 20px;
            float: right;
        }

        /* Hover effect for checkout button */
        .btn-checkout:hover {
            background-color: #e68a4f;
        }

        /* Styles for back to shop button */
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

        /* Hover effect for back to shop button */
        .btn-back-to-shop:hover {
            background: linear-gradient(to bottom, #111, #444);
            color: white;
        }
    </style>
</head>

<body>
    <?php include '../src/View/templates/header.php'; ?> <!-- Includes the header template. -->
    <?php include '../src/View/templates/navigation.php'; ?> <!-- Includes the navigation template. -->

    <div class="container mt-5"> <!-- Container for the cart content with a top margin. -->
        <h1>Warenkorb</h1> <!-- Page title. -->
        <?php if (!empty($cart)): ?> <!-- Checks if the cart is not empty. -->
            <table class="table"> <!-- Begins a table to display cart items. -->
                <thead>
                    <tr>
                        <th>Produkt</th> <!-- Column header for the product name. -->
                        <th>Preis</th> <!-- Column header for the product price. -->
                        <th>Menge</th> <!-- Column header for the product quantity. -->
                        <th>Gesamt</th> <!-- Column header for the total price of the product (price * quantity). -->
                        <th></th> <!-- Empty column header for the remove button. -->
                    </tr>
                </thead>
                <tbody id="cart-items"> <!-- Body of the table containing cart items. -->
                    <?php foreach ($cart as $product_id => $item): ?> <!-- Loop through each item in the cart. -->
                        <tr data-id="<?php echo $product_id; ?>" data-price="<?php echo $item['price']; ?>">
                            <!-- Each row represents a cart item with data attributes. -->
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <!-- Displays the product name with HTML escaping. -->
                            <td><?php echo number_format($item['price'], 2, ',', '.'); ?> €</td>
                            <!-- Displays the product price formatted as a currency. -->
                            <td>
                                <button class="quantity-btn minus-btn">-</button> <!-- Button to decrease the quantity. -->
                                <span class="quantity"><?php echo $item['quantity']; ?></span>
                                <!-- Displays the current quantity. -->
                                <button class="quantity-btn plus-btn">+</button> <!-- Button to increase the quantity. -->
                            </td>
                            <td class="item-total"><?php echo number_format($item['price'] * $item['quantity'], 2, ',', '.'); ?>
                                €</td> <!-- Displays the total price for this item (price * quantity). -->
                            <td><button class="remove-btn"></button></td> <!-- Button to remove the item from the cart. -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot> <!-- Footer of the table displaying the total price of all items in the cart. -->
                    <tr>
                        <td colspan="3" class="text-right"><strong>Gesamtsumme:</strong></td>
                        <!-- Label for the total sum. -->
                        <td colspan="2" id="total"><?php echo number_format($total, 2, ',', '.'); ?> €</td>
                        <!-- Displays the total sum formatted as a currency. -->
                    </tr>
                </tfoot>
            </table>
            <div class="clearfix">
                <a href="index.php" class="btn-back-to-shop">Zurück zum Shop</a> <!-- Button to go back to the shop. -->
                <a href="payment_integration.php" class="btn-checkout">Zur Kasse</a> <!-- Button to proceed to checkout. -->
            </div>
        <?php else: ?> <!-- Case when the cart is empty. -->
            <p>Ihr Warenkorb ist leer.</p> <!-- Message indicating the cart is empty. -->
        <?php endif; ?>
    </div>

    <?php include '../src/View/templates/footer.php'; ?> <!-- Includes the footer template. -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> <!-- Includes jQuery library. -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <!-- Includes Popper.js for Bootstrap tooltips and popovers. -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Includes Bootstrap's JavaScript plugins. -->
    <script>
        $(document).ready(function () {
            // Function to update the cart via an AJAX request.
            function updateCart(product_id, quantity) {
                $.ajax({
                    url: 'update_cart.php', // URL to send the AJAX request.
                    type: 'POST', // HTTP method.
                    data: {
                        product_id: product_id, // Sends the product ID.
                        quantity: quantity // Sends the new quantity.
                    },
                    dataType: 'json', // Expects JSON response.
                    success: function (response) {
                        if (response.status === 'success') {
                            // Updates the quantity and total price for the item in the table.
                            let row = $('tr[data-id="' + product_id + '"]');
                            row.find('.quantity').text(quantity);
                            let itemTotal = (parseFloat(row.data('price')) * quantity).toFixed(2).replace('.', ',');
                            row.find('.item-total').text(itemTotal + ' €');
                            // Updates the overall cart total.
                            $('#total').text(response.total + ' €');
                        } else {
                            // Shows an alert if there is an error.
                            alert(response.message);
                        }
                    }
                });
            }

            // Event handler for the plus button.
            $('.plus-btn').on('click', function () {
                let row = $(this).closest('tr');
                let product_id = row.data('id');
                let quantity = parseInt(row.find('.quantity').text()) + 1;

                updateCart(product_id, quantity); // Calls the updateCart function with incremented quantity.
            });

            // Event handler for the minus button.
            $('.minus-btn').on('click', function () {
                let row = $(this).closest('tr');
                let product_id = row.data('id');
                let quantity = parseInt(row.find('.quantity').text()) - 1;

                if (quantity >= 1) {
                    updateCart(product_id, quantity); // Calls the updateCart function with decremented quantity.
                }
            });

            // Event handler for the remove button.
            $('.remove-btn').on('click', function () {
                let row = $(this).closest('tr');
                let product_id = row.data('id');

                updateCart(product_id, 0); // Calls the updateCart function with quantity 0 (removes item).
                row.remove(); // Removes the row from the table.
            });
        });
    </script>
</body>

</html>
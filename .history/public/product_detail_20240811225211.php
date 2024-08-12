<?php

// Start the session to manage user sessions and cart
session_start();

// Include the database connection file from the config directory
require __DIR__ . '/../config/db_connect.php';

// Check if the 'id' parameter is present in the URL query string
if (isset($_GET['id'])) {
    // Prepare a SQL statement to select the product with the specified ID
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');

    // Execute the SQL statement with the provided 'id' parameter
    $stmt->execute([$_GET['id']]);

    // Fetch the product data as an associative array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // If no product was found with the given ID, terminate the script with an error message
    if (!$product) {
        die('Produkt nicht gefunden');
    }

    // Fetch related products, excluding the current product
    $relatedStmt = $pdo->prepare('SELECT * FROM products WHERE id != ? LIMIT 4');
    $relatedStmt->execute([$product['id']]);
    $relatedProducts = $relatedStmt->fetchAll(PDO::FETCH_ASSOC);

} else {
    // If the 'id' parameter is missing in the URL, terminate the script with an error message
    die('Ungültige Produkt-ID');
}

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - Produktdetails</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .btn-custom,
        .btn-cart,
        .btn-success {
            width: 20px;
            height: 25px;
            font-size: 14px;
        }

        .btn-custom {
            background: linear-gradient(to bottom, #333, #666);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            bottom: 10px;
            left: 10px;
        }

        .btn-custom:hover {
            background: linear-gradient(to bottom, #111, #444);
            color: white;
        }

        .btn-cart {
            background: linear-gradient(to bottom, #333, #666);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            bottom: 10px;
            right: 10px;
        }

        .btn-cart:hover {
            background: linear-gradient(to bottom, #111, #444);
            color: white;
        }

        .btn-success {
            background: linear-gradient(to bottom, #b04e4e, #d57272);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            bottom: 10px;
            right: 10px;
        }

        .card-body {
            position: relative;
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

        .quantity-popup .form-control {
            margin-bottom: 10px;
            width: 80px;
            display: inline-block;
        }

        .quantity-popup .add-quantity-btn {
            background: linear-gradient(to bottom, #333, #666);
            color: white;
            border-radius: 5px;
            border: none;
            padding: 5px 10px;
            font-size: 14px;
        }

        .quantity-popup .add-quantity-btn:hover {
            background: linear-gradient(to bottom, #111, #444);
        }

        .quantity-popup::before {
            content: "";
            position: absolute;
            top: -10px;
            right: 20px;
            border-width: 0 10px 10px 10px;
            border-style: solid;
            border-color: transparent transparent white transparent;
        }

        /* Background image for similar products */
        .card-background {
            background-size: cover;
            background-position: center;
            color: white;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .unavailable {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php
    // Include header and navigation templates
    include '../src/View/templates/header.php';
    include '../src/View/templates/navigation.php';
    ?>

    <!-- Main content area to display product details -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <div id="productImages" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="../assets/images/<?php echo htmlspecialchars($product['image']); ?>"
                                class="d-block w-100" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        </div>
                        <!-- Additional images can be added here -->
                    </div>
                    <a class="carousel-control-prev" href="#productImages" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#productImages" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <p><strong>Preis:</strong> <?php echo number_format($product['price'], 2, ',', '.'); ?> €</p>
                <p><strong>Verfügbarkeit:</strong>
                    <?php if (isset($product['stock']) && $product['stock'] > 0): ?>
                        Auf Lager
                    <?php else: ?>
                        <span class="unavailable">Nicht verfügbar</span>
                    <?php endif; ?>
                </p>

                <div class="btn-group" role="group" aria-label="Basic example">
                    <button class="btn btn-cart add-to-cart" data-id="<?php echo $product['id']; ?>"><i
                            class="fas fa-plus"></i></button>
                </div>

                <div class="quantity-popup">
                    <input type="number" class="form-control quantity-input" value="1" min="1" max="100">
                    <button class="add-quantity-btn">Hinzufügen</button>
                </div>
            </div>
        </div>

        <div class="related-products mt-5">
            <h3>Ähnliche Produkte</h3>
            <div class="row">
                <?php foreach ($relatedProducts as $related): ?>
                    <div class="col-md-3">
                        <div class="card card-background"
                            style="background-image: url('assets/images/<?php echo htmlspecialchars($related['image']); ?>');">
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <h5 class="card-title"><?php echo htmlspecialchars($related['name']); ?></h5>
                            </div>
                            <div class="card-footer text-center">
                                <p class="card-text"><?php echo number_format($related['price'], 2, ',', '.'); ?> €</p>
                                <a href="product_detail.php?id=<?php echo $related['id']; ?>"
                                    class="btn btn-primary">Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php include '../src/View/templates/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script>
        $(document).ready(function () {
            var currentButton;

            // Event handler for the 'Add to Cart' button
            $('.add-to-cart').on('click', function () {
                var button = $(this);
                var popup = button.siblings('.quantity-popup');

                // If the popup is already visible, proceed with adding to cart
                if (popup.is(':visible')) {
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        // Redirect to login if the user is not logged in
                        window.location.href = 'login.php';
                    <?php else: ?>
                        var productId = button.data('id');
                        var quantity = popup.find('.quantity-input').val();

                        // AJAX request to add the product to the cart
                        $.ajax({
                            type: 'POST',
                            url: 'product_detail.php',
                            data: { add_to_cart: productId, quantity: quantity },
                            success: function (response) {
                                var data = JSON.parse(response);
                                if (data.status === 'success') {
                                    // Update the button appearance and show success alert
                                    button.removeClass('btn-cart').addClass('btn-success').html('<i class="fas fa-check"></i>').prop('disabled', true);
                                    $('#alert-placeholder').html('<div class="alert alert-success">' + data.quantity + ' Produkt(e) wurden zum Warenkorb hinzugefügt!</div>');
                                    setTimeout(function () {
                                        $('.alert').fadeOut('slow', function () {
                                            $(this).remove();
                                        });
                                    }, 5000);
                                    popup.fadeOut('slow');
                                }
                            }
                        });
                    <?php endif; ?>
                } else {
                    // If the popup is not visible, show it and hide others
                    $('.quantity-popup').hide();
                    popup.show();
                    currentButton = button;
                }
            });

            // Event handler for the 'Add Quantity' button in the popup
            $('.add-quantity-btn').on('click', function () {
                var button = $(this).closest('.card-body').find('.add-to-cart');
                button.click();
            });

            // Hide the popup if the user clicks outside of it
            $(document).on('click', function (event) {
                if (!$(event.target).closest('.card-body').length) {
                    $('.quantity-popup').hide();
                }
            });
        });
    </script>
</body>

</html>
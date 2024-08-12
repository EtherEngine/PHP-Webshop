<?php

// Start the session to manage user sessions and cart
session_start();

// Include the database connection file from the config directory
require __DIR__ . '/../config/db_connect.php';

// Check if the 'id' parameter is present in the URL query string
if (isset($_GET['id'])) {
    // Prepare a SQL statement to select the product with the specified ID
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        die('Produkt nicht gefunden');
    }

    // Fetch related products, excluding the current product
    $relatedStmt = $pdo->prepare('SELECT * FROM products WHERE id != ? LIMIT 4');
    $relatedStmt->execute([$product['id']]);
    $relatedProducts = $relatedStmt->fetchAll(PDO::FETCH_ASSOC);

} else {
    die('Ungültige Produkt-ID');
}

// Handle adding to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }

    $product_id = $_POST['add_to_cart'];
    $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 1;

    // Fetch the product details
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

        if (isset($cart[$product_id])) {
            $cart[$product_id]['quantity'] += $quantity;
        } else {
            $cart[$product_id] = [
                'id' => $product_id,
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity,
                'image' => $product['image']
            ];
        }

        $_SESSION['cart'] = $cart;
        echo json_encode(['status' => 'success', 'quantity' => $quantity]);
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - Produktdetails</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .btn-custom,
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
        <div class="row">
            <div class="col-md-6">
                <div id="productImages" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="../assets/images/<?php echo htmlspecialchars($product['image']); ?>"
                                class="d-block w-100" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        </div>
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

                <!-- + Button entfernt -->

                <div class="quantity-popup">
                    <input type="number" class="form-control quantity-input" value="1" min="1" max="100">
                    <button class="add-quantity-btn">Hinzufügen</button>
                </div>
            </div>
        </div>
    </div>

    <?php include '../src/View/templates/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../assets/js/scripts.js"></script>
</body>

</html>
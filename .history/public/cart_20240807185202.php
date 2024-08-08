<?php
session_start();
require __DIR__ . '/../config/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Produkt aus dem Warenkorb entfernen
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    if (isset($cart[$remove_id])) {
        unset($cart[$remove_id]);
        $_SESSION['cart'] = $cart;
        header('Location: cart.php');
        exit;
    }
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
        .btn-custom {
            background: linear-gradient(to bottom, #333, #666);
            color: white;
            border-radius: 50%;
            width: 30px;
            /* vorher 40px */
            height: 30px;
            /* vorher 40px */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            /* vorher 18px */
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
            width: 30px;
            /* vorher 40px */
            height: 30px;
            /* vorher 40px */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            /* vorher 18px */
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
            width: 30px;
            /* vorher 40px */
            height: 30px;
            /* vorher 40px */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            /* vorher 18px */
            position: absolute;
            bottom: 10px;
            right: 10px;
        }

        .navbar .fa-shopping-cart.glow {
            animation: glow 1s infinite alternate;
        }

        @keyframes glow {
            from {
                text-shadow: 0 0 10px #28a745, 0 0 20px #28a745, 0 0 30px #28a745, 0 0 40px #28a745, 0 0 50px #28a745, 0 0 60px #28a745, 0 0 70px #28a745;
            }

            to {
                text-shadow: 0 0 20px #218838, 0 0 30px #218838, 0 0 40px #218838, 0 0 50px #218838, 0 0 60px #218838, 0 0 70px #218838, 0 0 80px #218838;
            }
        }

        .card-body {
            position: relative;
        }

        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
    </style>

</head>

<body>
    <?php include '../src/View/templates/header.php'; ?>
    <div class="container mt-5">
        <h2>Ihr Warenkorb</h2>
        <?php if (empty($cart)): ?>
            <p>Ihr Warenkorb ist leer.</p>
        <?php else: ?>
            <ul class="list-group">
                <?php foreach ($cart as $item): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo htmlspecialchars($item['name']); ?> - <?php echo htmlspecialchars($item['price']); ?> €
                        <a href="cart.php?remove=<?php echo $item['id']; ?>" class="btn btn-remove"><i
                                class="fas fa-times"></i></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <a href="index.php" class="btn btn-custom mt-3">Zurück zum Shop</a>
        <a href="checkout.php" class="btn btn-custom mt-3">Zur Kasse</a>
    </div>
    <?php include '../src/View/templates/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
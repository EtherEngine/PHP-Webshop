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

// Berechne die Gesamtsumme
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'];
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
        .btn-remove {
            background: linear-gradient(to bottom, #333, #666);
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            margin-left: 10px;
        }

        .btn-remove:hover {
            background: linear-gradient(to bottom, #111, #444);
            color: white;
        }

        .btn-custom {
            background: linear-gradient(to bottom, #333, #666);
            color: white;
            border-radius: 25px;
            padding: 10px 20px;
            margin-top: 10px;
            display: inline-block;
            text-decoration: none;
        }

        .btn-custom:hover {
            background: linear-gradient(to bottom, #111, #444);
            color: white;
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
            <ul class="list-group mb-3">
                <?php foreach ($cart as $item): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo htmlspecialchars($item['name']); ?> - <?php echo htmlspecialchars($item['price']); ?> €
                        <a href="cart.php?remove=<?php echo $item['id']; ?>" class="btn btn-remove"><i
                                class="fas fa-times"></i></a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>Gesamtsumme: <?php echo number_format($total, 2, ',', '.'); ?> €</h5>
            </div>
        <?php endif; ?>
        <a href="index.php" class="btn btn-custom">Zurück zum Shop</a>
        <a href="payment_integration.php" class="btn btn-custom">Zur Kasse</a>
    </div>
    <?php include '../src/View/templates/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
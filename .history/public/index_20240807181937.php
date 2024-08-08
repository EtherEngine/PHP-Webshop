<?php
session_start();
require __DIR__ . '/../config/db_connect.php';

if (isset($_GET['add_to_cart']) && isset($_SESSION['user_id'])) {
    $product_id = $_GET['add_to_cart'];
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        $cart[$product_id] = $product;
        $_SESSION['cart'] = $cart;
        $_SESSION['cart_glow'] = true; // Setze die Variable, um das Warenkorb-Icon zum Glühen zu bringen
        header('Location: index.php?added=true');
        exit;
    }
}

$query = isset($_GET['query']) ? $_GET['query'] : '';
if ($query) {
    $stmt = $pdo->prepare('SELECT * FROM products WHERE name LIKE ? OR description LIKE ?');
    $stmt->execute(["%$query%", "%$query%"]);
} else {
    $stmt = $pdo->query('SELECT * FROM products');
}
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$added_to_cart = isset($_GET['added']) ? true : false;
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop - Startseite</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .btn-custom {
            background-color: #0062E6;
            color: white;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-top: 10px;
        }

        .btn-custom:hover {
            background-color: #004bb5;
            color: white;
        }

        .btn-cart {
            background-color: #28a745;
            color: white;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-top: 10px;
        }

        .btn-cart:hover {
            background-color: #218838;
            color: white;
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
    </style>
</head>

<body>
    <?php
    include '../src/View/templates/header.php';
    include '../src/View/templates/navigation.php';
    ?>
    <div class="container mt-5">
        <?php if ($added_to_cart): ?>
            <div class="alert alert-success">
                Produkt wurde zum Warenkorb hinzugefügt!
            </div>
        <?php endif; ?>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="../assets/images/<?php echo htmlspecialchars($product['image']); ?>" class="card-img-top"
                            alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <div class="card-body text-center">
                            <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                            <p class="card-text"><strong><?php echo htmlspecialchars($product['price']); ?> €</strong></p>
                            <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="btn btn-custom"><i
                                    class="fas fa-ellipsis-h"></i></a>
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <?php if (isset($_SESSION['cart'][$product['id']])): ?>
                                    <button class="btn btn-success mt-2" disabled>Zum Warenkorb hinzugefügt</button>
                                <?php else: ?>
                                    <a href="index.php?add_to_cart=<?php echo $product['id']; ?>" class="btn btn-cart mt-2"><i
                                            class="fas fa-plus"></i></a>
                                <?php endif; ?>
                            <?php else: ?>
                                <a href="login.php" class="btn btn-custom mt-2"><i class="fas fa-shopping-cart"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php include '../src/View/templates/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>

</html>
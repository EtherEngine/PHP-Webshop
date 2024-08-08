<?php
session_start();
require __DIR__ . '/../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart']) && isset($_SESSION['user_id'])) {
    $product_id = $_POST['add_to_cart'];
    $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 1;
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
        echo json_encode(['status' => 'success']);
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
    <?php
    include '../src/View/templates/header.php';
    include '../src/View/templates/navigation.php';
    ?>
    <div class="container mt-5">
        <div id="alert-placeholder"></div>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="../assets/images/<?php echo htmlspecialchars($product['image']); ?>" class="card-img-top"
                            alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <div class="card-body">
                            <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                            <p class="card-text"><strong><?php echo htmlspecialchars($product['price']); ?> €</strong></p>
                            <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="btn btn-custom"><i
                                    class="fas fa-ellipsis-h"></i></a>
                            <form class="add-to-cart-form" method="POST" action="index.php">
                                <input type="hidden" name="add_to_cart" value="<?php echo $product['id']; ?>">
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" name="quantity" value="1" min="1" max="100">
                                    <div class="input-group-append">
                                        <button class="btn btn-cart" type="submit"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                            </form>
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <?php if (isset($_SESSION['cart'][$product['id']])): ?>
                                    <button class="btn btn-success" disabled><i class="fas fa-check"></i></button>
                                <?php else: ?>
                                    <button class="btn btn-cart add-to-cart" data-id="<?php echo $product['id']; ?>"><i
                                            class="fas fa-plus"></i></button>
                                <?php endif; ?>
                            <?php else: ?>
                                <a href="login.php" class="btn btn-cart"><i class="fas fa-shopping-cart"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php include '../src/View/templates/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script>
        $(document).ready(function () {
            $('.add-to-cart-form').on('submit', function (event) {
                event.preventDefault();
                var form = $(this);
                var productId = form.find('input[name="add_to_cart"]').val();
                var quantity = form.find('input[name="quantity"]').val();

                $.ajax({
                    type: 'POST',
                    url: 'index.php',
                    data: { add_to_cart: productId, quantity: quantity },
                    success: function (response) {
                        var data = JSON.parse(response);
                        if (data.status === 'success') {
                            form.find('button[type="submit"]').removeClass('btn-cart').addClass('btn-success').html('<i class="fas fa-check"></i>').prop('disabled', true);
                            $('#alert-placeholder').html('<div class="alert alert-success">Produkt wurde zum Warenkorb hinzugefügt!</div>');
                            setTimeout(function () {
                                $('.alert').fadeOut('slow', function () {
                                    $(this).remove();
                                });
                            }, 5000);
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
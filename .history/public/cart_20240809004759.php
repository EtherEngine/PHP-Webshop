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
        echo json_encode(['status' => 'success', 'quantity' => $quantity]);
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

        .search-bar {
            max-width: 325px;
            margin: 5px auto;
            padding: 2px;
            border-radius: 30px;
            box-shadow: 0 px 0px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .search-bar .input-group {
            border-radius: 30px;
        }

        .search-bar .input-group .form-control {
            border-right: 0;
            border-radius: 30px 0 0 30px;
        }

        .search-bar .input-group .input-group-append .btn {
            border-left: 0;
            border-radius: 0 30px 30px 0;
        }

        .search-bar .form-control:focus {
            box-shadow: none;
        }
    </style>
</head>

<body>
    <?php
    include '../src/View/templates/header.php';
    include '../src/View/templates/navigation.php';
    ?>

    <div class="search-bar">
        <form class="form-inline" action="index.php" method="GET">
            <div class="input-group input-group-lg">
                <input class="form-control" type="search" placeholder="Suchen" aria-label="Suchen" name="query">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="container mt-5">
        <div id="alert-placeholder"></div>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <a href="product_detail.php?id=<?php echo $product['id']; ?>">
                            <img src="../assets/images/<?php echo htmlspecialchars($product['image']); ?>"
                                class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        </a>
                        <div class="card-body">
                            <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                            <p class="card-text"><strong><?php echo htmlspecialchars($product['price']); ?> €</strong></p>
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
            height: 40px;
            width: 40px;
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
            display: flex;
            align-items: center;
        }

        .cart-item .quantity {
            width: 60px;
            text-align: center;
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
            padding: 6px 16px;
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
            <a href="index.php" class="btn btn-back">Zurück zum Shop</a>
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
                                <?php echo number_format($product['price'], 2, ',', '.'); ?> €
                            </p>
                        </div>
                        <div class="col-md-2 quantity-wrapper">
                            <input type="number" class="form-control quantity"
                                value="<?php echo htmlspecialchars($product['quantity']); ?>" min="1">
                        </div>
                        <div class="col-md-2">
                            <p class="price item-total">
                                <?php echo number_format($product['price'] * $product['quantity'], 2, ',', '.'); ?> €
                            </p>
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
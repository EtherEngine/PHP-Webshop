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
    $stmt = $pdo->prepare('SELECT * FROM products WHERE name LIKE ? OR description LIKE ? OR tags LIKE ?');
    $stmt->execute(["%$query%", "%$query%", "%$query%"]);
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
        /* Deine bestehenden CSS-Stile */
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
                            <div class="quantity-popup">
                                <input type="number" class="form-control quantity-input" value="1" min="1" max="100">
                                <button class="add-quantity-btn">Hinzufügen</button>
                            </div>
                            <button class="btn btn-cart add-to-cart" data-id="<?php echo $product['id']; ?>"><i
                                    class="fas fa-plus"></i></button>
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
            var currentButton;

            $('.add-to-cart').on('click', function () {
                var button = $(this);
                var popup = button.siblings('.quantity-popup');

                if (popup.is(':visible')) {
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        window.location.href = 'login.php';
                    <?php else: ?>
                        var productId = button.data('id');
                        var quantity = popup.find('.quantity-input').val();

                        $.ajax({
                            type: 'POST',
                            url: 'index.php',
                            data: { add_to_cart: productId, quantity: quantity },
                            success: function (response) {
                                var data = JSON.parse(response);
                                if (data.status === 'success') {
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
                    $('.quantity-popup').hide();
                    popup.show();
                    currentButton = button;
                }
            });

            $('.add-quantity-btn').on('click', function () {
                var button = $(this).closest('.card-body').find('.add-to-cart');
                button.click();
            });

            $(document).on('click', function (event) {
                if (!$(event.target).closest('.card-body').length) {
                    $('.quantity-popup').hide();
                }
            });
        });
    </script>
</body>

</html>
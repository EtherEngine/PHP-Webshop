<?php
// Start the session to manage user sessions and cart
session_start();

// Include the database connection file from the config directory
require __DIR__ . '/../config/db_connect.php';

// Initialisiere den Warenkorb
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Überprüfe, ob der Warenkorb leer ist
$cart_empty = empty($cart);

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
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
                    $total = 0;
                    foreach ($cart as $item):
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                        ?>
                        <tr>
                            <td><img src="../assets/images/<?php echo htmlspecialchars($item['image']); ?>"
                                    alt="<?php echo htmlspecialchars($item['name']); ?>" style="height: 60px;"></td>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo number_format($item['price'], 2, ',', '.'); ?> €</td>
                            <td class="quantity-controls">
                                <button class="btn btn-cart btn-sm decrease-quantity"
                                    data-id="<?php echo $item['id']; ?>">-</button>
                                <input type="text" class="form-control quantity-input" value="<?php echo $item['quantity']; ?>"
                                    data-id="<?php echo $item['id']; ?>">
                                <button class="btn btn-cart btn-sm increase-quantity"
                                    data-id="<?php echo $item['id']; ?>">+</button>
                            </td>
                            <td class="item-total"><?php echo number_format($subtotal, 2, ',', '.'); ?> €</td>
                            <td>
                                <a href="remove_from_cart.php?id=<?php echo $item['id']; ?>"
                                    class="btn btn-danger btn-sm">Entfernen</a>
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
</body>

</html>
<?php
session_start();

// Verbindung zur Datenbank herstellen
require __DIR__ . '/../config/db_connect.php';

// Warenkorb-Daten abrufen
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0;

foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Benutzerdaten prüfen, wenn vorhanden
$user_data = [];
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM user_profile WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestellübersicht</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <?php include '../src/View/templates/header.php'; ?>
    <?php include '../src/View/templates/navigation.php'; ?>

    <div class="container mt-5">
        <h1>Bestellübersicht</h1>
        <?php if (!empty($cart)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Produkt</th>
                        <th>Preis</th>
                        <th>Menge</th>
                        <th>Gesamt</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo number_format($item['price'], 2, ',', '.'); ?> €</td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo number_format($item['price'] * $item['quantity'], 2, ',', '.'); ?> €</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right"><strong>Gesamtsumme:</strong></td>
                        <td><?php echo number_format($total, 2, ',', '.'); ?> €</td>
                    </tr>
                </tfoot>
            </table>

            <!-- Bestellformular -->
            <form action="process_order.php" method="post">
                <h2>Versand- und Zahlungsinformationen</h2>
                <div class="form-group">
                    <label for="shipping_address">Versandadresse</label>
                    <textarea class="form-control" id="shipping_address" name="shipping_address"
                        required><?php echo htmlspecialchars($user_data['address'] ?? ''); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="payment_method">Zahlungsmethode</label>
                    <select class="form-control" id="payment_method" name="payment_method" required>
                        <option value="credit_card">Kreditkarte</option>
                        <option value="paypal">PayPal</option>
                        <option value="bank_transfer">Banküberweisung</option>
                    </select>
                </div>

                <!-- Hier können zusätzliche Felder für z.B. die Telefonnummer, E-Mail usw. eingefügt werden -->

                <button type="submit" class="btn btn-primary">Bestellung abschließen</button>
            </form>
        <?php else: ?>
            <p>Ihr Warenkorb ist leer.</p>
        <?php endif; ?>
    </div>

    <?php include '../src/View/templates/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
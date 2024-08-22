order_detail.php:
<?php
session_start();

// Verbindung zur Datenbank herstellen
require __DIR__ . '/../config/db_connect.php';

// Initialisiere Variablen für die Benutzerdaten
$user_data = [
    'firstname' => '',
    'lastname' => '',
    'street' => '',
    'housenumber' => '',
    'city' => '',
    'zipcode' => '',
    'country' => ''
];

// Prüfen, ob der Benutzer eingeloggt ist und ob seine Daten vorhanden sind
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT firstname, lastname, street, housenumber, city, zipcode, country FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Warenkorb-Daten abrufen
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0;

foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
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
                    <label for="firstname">Vorname</label>
                    <input type="text" class="form-control" id="firstname" name="firstname"
                        value="<?php echo htmlspecialchars($user_data['firstname']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="lastname">Nachname</label>
                    <input type="text" class="form-control" id="lastname" name="lastname"
                        value="<?php echo htmlspecialchars($user_data['lastname']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="street">Straße</label>
                    <input type="text" class="form-control" id="street" name="street"
                        value="<?php echo htmlspecialchars($user_data['street']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="housenumber">Hausnummer</label>
                    <input type="text" class="form-control" id="housenumber" name="housenumber"
                        value="<?php echo htmlspecialchars($user_data['housenumber']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="zipcode">Postleitzahl</label>
                    <input type="text" class="form-control" id="zipcode" name="zipcode"
                        value="<?php echo htmlspecialchars($user_data['zipcode']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="city">Stadt</label>
                    <input type="text" class="form-control" id="city" name="city"
                        value="<?php echo htmlspecialchars($user_data['city']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="country">Land</label>
                    <input type="text" class="form-control" id="country" name="country"
                        value="<?php echo htmlspecialchars($user_data['country']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="payment_method">Zahlungsmethode</label>
                    <select class="form-control" id="payment_method" name="payment_method" required>
                        <option value="credit_card">Kreditkarte</option>
                        <option value="paypal">PayPal</option>
                        <option value="bank_transfer">Banküberweisung</option>
                    </select>
                </div>

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
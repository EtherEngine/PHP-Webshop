<?php
session_start();
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
$cart = $_SESSION['cart'] ?? [];
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
    <!-- Beibehalten des ursprünglichen Layouts und Stils -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Bestellübersicht</h1>
        <div class="user-details">
            <h2>Benutzerdaten</h2>
            <p><strong>Name:</strong> <?= htmlspecialchars($user_data['firstname'] . ' ' . $user_data['lastname']) ?>
            </p>
            <p><strong>Adresse:</strong>
                <?= htmlspecialchars($user_data['street'] . ' ' . $user_data['housenumber'] . ', ' . $user_data['city'] . ', ' . $user_data['zipcode'] . ', ' . $user_data['country']) ?>
            </p>
        </div>

        <div class="cart-details">
            <h2>Warenkorb</h2>
            <?php if (!empty($cart)): ?>
                <ul>
                    <?php foreach ($cart as $item): ?>
                        <li><?= htmlspecialchars($item['name']) ?> - <?= htmlspecialchars($item['quantity']) ?> x
                            <?= number_format($item['price'], 2) ?> €</li>
                    <?php endforeach; ?>
                </ul>
                <p><strong>Gesamtpreis: <?= number_format($total, 2) ?> €</strong></p>
            <?php else: ?>
                <p>Ihr Warenkorb ist leer.</p>
            <?php endif; ?>
        </div>

        <div class="actions">
            <a href="checkout.php" class="btn">Zur Kasse</a>
            <a href="shop.php" class="btn">Weiter einkaufen</a>
        </div>
    </div>
</body>

</html>
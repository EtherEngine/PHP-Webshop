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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #007bff;
            color: white;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Bestellübersicht</h1>
        <div class="card">
            <div class="card-header">
                <h4>Benutzerdaten</h4>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong>
                    <?= htmlspecialchars($user_data['firstname'] . ' ' . $user_data['lastname']) ?></p>
                <p><strong>Adresse:</strong>
                    <?= htmlspecialchars($user_data['street'] . ' ' . $user_data['housenumber'] . ', ' . $user_data['city'] . ', ' . $user_data['zipcode'] . ', ' . $user_data['country']) ?>
                </p>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h4>Warenkorb</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($cart)): ?>
                    <ul class="list-group">
                        <?php foreach ($cart as $item): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= htmlspecialchars($item['name']) ?>
                                <span><?= htmlspecialchars($item['quantity']) ?> x <?= number_format($item['price'], 2) ?>
                                    €</span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <p class="mt-3 text-right"><strong>Gesamtpreis: <?= number_format($total, 2) ?> €</strong></p>
                <?php else: ?>
                    <p>Ihr Warenkorb ist leer.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="mt-4 text-center">
            <a href="checkout.php" class="btn btn-primary">Zur Kasse</a>
            <a href="shop.php" class="btn btn-secondary">Weiter einkaufen</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
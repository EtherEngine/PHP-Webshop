<?php
session_start();

// Verbindung zur Datenbank herstellen
require __DIR__ . '/../config/db_connect.php';

// Prüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Benutzer-ID aus der Session
$user_id = $_SESSION['user_id'];

// Bestellungen des Benutzers abrufen
$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meine Bestellungen</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Standardmäßige Entfernung von Abständen und Polsterungen */
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
        }

        /* Anpassung des Header- und Navigationsbereichs */
        .navbar {
            margin-bottom: 0;
            background-color: #343a40;
        }

        .navbar .navbar-brand img {
            height: 40px;
        }

        /* Stil der Buttons */
        .btn-primary {
            background: linear-gradient(to bottom, #b04e4e, #d57272);
            color: white;
            border-radius: 50px;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
        }

        .btn-primary:hover {
            background: linear-gradient(to bottom, #922e2e, #c55d5d);
            color: white;
        }

        /* Kartenstil für Bestellungen */
        .card {
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            font-weight: bold;
        }

        .card-body {
            padding: 15px;
        }

        /* Stile für die Tabelle */
        .table th,
        .table td {
            vertical-align: middle;
        }

        /* Styling für die Druckfunktion */
        @media print {
            .no-print {
                display: none;
            }
        }

        /* Suchleiste */
        .search-bar {
            max-width: 325px;
            margin: 5px auto;
            padding: 2px;
            border-radius: 30px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
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
    <!-- Header und Navigation -->
    <?php include '../src/View/templates/header.php'; ?>
    <?php include '../src/View/templates/navigation.php'; ?>

    <div class="container mt-5">
        <h1>Meine Bestellungen</h1>

        <div class="no-print text-right mb-3">
            <button class="btn btn-primary" onclick="window.print()">Bestellung drucken</button>
        </div>

        <?php if ($orders): ?>
            <?php foreach ($orders as $order): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        Bestellnummer: <?php echo $order['id']; ?><br>
                        Bestelldatum: <?php echo date('d.m.Y H:i', strtotime($order['order_date'])); ?><br>
                        Status: <?php echo ucfirst($order['status']); ?>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Versandadresse</h5>
                        <p class="card-text">
                            <?php echo htmlspecialchars($order['firstname']) . ' ' . htmlspecialchars($order['lastname']); ?><br>
                            <?php echo htmlspecialchars($order['street']) . ' ' . htmlspecialchars($order['housenumber']); ?><br>
                            <?php echo htmlspecialchars($order['zipcode']) . ' ' . htmlspecialchars($order['city']); ?><br>
                            <?php echo htmlspecialchars($order['country']); ?>
                        </p>

                        <h5 class="card-title">Bestellübersicht</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Produkt</th>
                                    <th>Menge</th>
                                    <th>Preis</th>
                                    <th>Gesamt</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Bestellposten für die jeweilige Bestellung abrufen
                                $stmt_items = $pdo->prepare("
                                    SELECT oi.quantity, oi.price, p.name AS product_name
                                    FROM order_items oi
                                    JOIN products p ON oi.product_id = p.id
                                    WHERE oi.order_id = ?
                                ");
                                $stmt_items->execute([$order['id']]);
                                $items = $stmt_items->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($items as $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                        <td><?php echo $item['quantity']; ?></td>
                                        <td><?php echo number_format($item['price'], 2, ',', '.'); ?> €</td>
                                        <td><?php echo number_format($item['price'] * $item['quantity'], 2, ',', '.'); ?> €</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Gesamtsumme (Netto):</strong></td>
                                    <td><?php echo number_format($order['total_price'], 2, ',', '.'); ?> €</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Sie haben noch keine Bestellungen aufgegeben.</p>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <?php include '../src/View/templates/footer.php'; ?>

    <!-- Scripte -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
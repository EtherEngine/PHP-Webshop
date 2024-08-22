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
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Zusätzliche Stile für Druck und PDF */
        @media print {
            .no-print {
                display: none;
            }
        }

        /* Entfernt den Zoom-Effekt beim Hover */
        .card:hover {
            transform: none;
            transition: none;
        }

        /* Entfernt den weißen Balken zwischen Header und Navigation */
        body {
            margin: 0;
            padding: 0;
        }

        header,
        .navbar {
            margin-bottom: 0;
        }

        /* Übernahme der Abstände aus der index.php */
        .container {
            margin-top: 50px;
        }

        .card-body {
            position: relative;
        }

        .no-print {
            margin-bottom: 20px;
        }

        .card {
            margin-bottom: 20px;
        }

        /* Farbschema für Buttons aus index.php */
        .btn-primary {
            background: linear-gradient(to bottom, #b04e4e, #d57272);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 25px;
            font-size: 14px;
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(to bottom, #922e2e, #c55d5d);
            color: white;
        }

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
    </style>
</head>

<body>
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
                        <strong>Bestellnummer:</strong> <?php echo $order['id']; ?><br>
                        <strong>Bestelldatum:</strong> <?php echo date('d.m.Y H:i', strtotime($order['order_date'])); ?><br>
                        <strong>Status:</strong> <?php echo ucfirst($order['status']); ?>
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

    <?php include '../src/View/templates/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
<?php
session_start();
require 'C:/xampp/htdocs/Klausurprojekt/config/db_connect.php';



// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Überprüfen, ob die Bestell-ID übergeben wurde
if (!isset($_GET['order_id'])) {
    die('Ungültige Bestell-ID');
}

$order_id = $_GET['order_id'];

// Abrufen der Bestellinformationen aus der Datenbank
$stmt = $pdo->prepare('SELECT * FROM orders WHERE id = ? AND user_id = ?');
$stmt->execute([$order_id, $_SESSION['user_id']]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

// Überprüfen, ob die Bestellung gefunden wurde
if (!$order) {
    die('Bestellung nicht gefunden');
}

// Abrufen der Produktinformationen zu dieser Bestellung
$stmtProducts = $pdo->prepare('
    SELECT op.*, p.name, p.image 
    FROM order_products op 
    JOIN products p ON op.product_id = p.id 
    WHERE op.order_id = ?
');
$stmtProducts->execute([$order_id]);
$products = $stmtProducts->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestelldetails</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .order-container {
            margin-top: 30px;
        }

        .order-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .order-header h2 {
            font-size: 2.5em;
            color: #333;
            font-family: 'Arial', sans-serif;
            margin-bottom: 20px;
        }

        .order-details {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .order-details h3 {
            font-size: 1.5em;
            margin-bottom: 20px;
            color: #333;
        }

        .order-details p {
            font-size: 1.2em;
            margin-bottom: 5px;
        }

        .order-products {
            margin-top: 30px;
        }

        .order-products table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-products th,
        .order-products td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .order-products th {
            background-color: #333;
            color: white;
            font-weight: bold;
        }

        .order-status {
            margin-top: 30px;
            text-align: center;
        }

        .order-status .status-indicator {
            font-size: 1.5em;
            padding: 10px;
            border-radius: 5px;
            color: white;
        }

        .order-status .confirmed {
            background-color: #007bff;
        }

        .order-status .processing {
            background-color: #ffc107;
        }

        .order-status .shipped {
            background-color: #28a745;
        }

        .order-status .delivered {
            background-color: #17a2b8;
        }

        .order-total {
            font-size: 1.5em;
            text-align: right;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }

        .order-total .total-price {
            color: #333;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php include '../src/View/templates/header.php'; ?>
    <?php include '../src/View/templates/navigation.php'; ?>

    <div class="container order-container">
        <div class="order-header">
            <h2>Bestelldetails</h2>
        </div>

        <div class="order-details">
            <h3>Bestellnummer: <?php echo htmlspecialchars($order['id']); ?></h3>
            <p><strong>Bestelldatum:</strong> <?php echo date('d.m.Y', strtotime($order['order_date'])); ?></p>
            <p><strong>Versandadresse:</strong> <?php echo htmlspecialchars($order['shipping_address']); ?></p>
            <p><strong>Gesamtbetrag:</strong> <?php echo number_format($order['total_price'], 2, ',', '.'); ?> €</p>
        </div>

        <div class="order-products">
            <h3>Bestellte Produkte</h3>
            <table>
                <thead>
                    <tr>
                        <th>Produkt</th>
                        <th>Menge</th>
                        <th>Preis</th>
                        <th>Zwischensumme</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td>
                                <img src="../assets/images/<?php echo htmlspecialchars($product['image']); ?>"
                                    alt="<?php echo htmlspecialchars($product['name']); ?>" style="height: 50px;">
                                <?php echo htmlspecialchars($product['name']); ?>
                            </td>
                            <td><?php echo $product['quantity']; ?></td>
                            <td><?php echo number_format($product['price'], 2, ',', '.'); ?> €</td>
                            <td><?php echo number_format($product['price'] * $product['quantity'], 2, ',', '.'); ?> €</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="order-status">
            <h3>Bestellstatus</h3>
            <div class="status-indicator <?php echo strtolower($order['status']); ?>">
                <?php echo ucfirst($order['status']); ?>
            </div>
        </div>

        <div class="order-total">
            Gesamt: <span class="total-price"><?php echo number_format($order['total_price'], 2, ',', '.'); ?> €</span>
        </div>
    </div>

    <?php include '../src/View/templates/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
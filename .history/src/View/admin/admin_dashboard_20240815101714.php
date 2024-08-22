<?php
session_start();
require __DIR__ . '/../config/db_connect.php';

// Sicherheitsüberprüfung - sicherstellen, dass nur Admins Zugriff haben
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: index.php');
    exit;
}

// Abfrage, um Benutzer und ihre Bestellungen zu verknüpfen
$sql = "
    SELECT 
        users.firstname, 
        users.lastname, 
        users.email, 
        products.name AS product_name, 
        order_items.quantity, 
        order_items.price,
        orders.order_date
    FROM 
        users
    JOIN 
        orders ON users.id = orders.user_id
    JOIN 
        order_items ON orders.id = order_items.order_id
    JOIN 
        products ON order_items.product_id = products.id
    ORDER BY 
        orders.order_date DESC;
";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Admin Dashboard</h1>

        <!-- Übersicht der Bestellungen -->
        <h2>Bestellungen</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Vorname</th>
                    <th>Nachname</th>
                    <th>Email</th>
                    <th>Produkt</th>
                    <th>Menge</th>
                    <th>Preis</th>
                    <th>Bestelldatum</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['firstname']); ?></td>
                        <td><?php echo htmlspecialchars($order['lastname']); ?></td>
                        <td><?php echo htmlspecialchars($order['email']); ?></td>
                        <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                        <td><?php echo number_format($order['price'], 2, ',', '.'); ?> €</td>
                        <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Weitere nützliche Informationen für das Admin-Dashboard -->
        <h2>Statistiken</h2>
        <ul>
            <li><strong>Gesamtanzahl der Bestellungen:</strong> <?php echo count($orders); ?></li>
            <!-- Weitere Statistiken können hier hinzugefügt werden -->
        </ul>

        <!-- Beispielsweise könnten Links zu anderen Admin-Funktionen hinzugefügt werden -->
        <a href="manage_products.php" class="btn btn-primary">Produkte verwalten</a>
        <a href="manage_users.php" class="btn btn-secondary">Benutzer verwalten</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
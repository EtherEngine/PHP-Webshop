<?php
session_start();
require __DIR__ . '/../config/db_connect.php';

// Überprüfen, ob der Benutzer eingeloggt ist und Adminrechte hat
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Beispiel: Abrufen der Anzahl der Benutzer, Produkte und Bestellungen
$stmtUsers = $pdo->query('SELECT COUNT(*) AS total_users FROM users');
$totalUsers = $stmtUsers->fetch(PDO::FETCH_ASSOC)['total_users'];

$stmtProducts = $pdo->query('SELECT COUNT(*) AS total_products FROM products');
$totalProducts = $stmtProducts->fetch(PDO::FETCH_ASSOC)['total_products'];

$stmtOrders = $pdo->query('SELECT COUNT(*) AS total_orders FROM orders');
$totalOrders = $stmtOrders->fetch(PDO::FETCH_ASSOC)['total_orders'];

// Weitere Queries für detaillierte Statistiken
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .dashboard-container {
            margin-top: 30px;
        }

        .dashboard-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .dashboard-header h2 {
            font-size: 2.5em;
            color: #333;
            font-family: 'Arial', sans-serif;
        }

        .dashboard-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-around;
        }

        .dashboard-card {
            background: linear-gradient(to bottom, #444, #666);
            color: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            width: 30%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .dashboard-card:hover {
            transform: scale(1.05);
        }

        .dashboard-card h3 {
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        .dashboard-card p {
            font-size: 1.2em;
            margin: 0;
        }

        .dashboard-actions {
            margin-top: 40px;
            text-align: center;
        }

        .dashboard-actions a {
            background: linear-gradient(to bottom, #555, #777);
            color: white;
            padding: 10px 20px;
            margin: 10px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1.1em;
            transition: background 0.3s ease;
        }

        .dashboard-actions a:hover {
            background: linear-gradient(to bottom, #222, #444);
        }

        .dashboard-section {
            margin-bottom: 50px;
        }

        .dashboard-section h4 {
            font-size: 1.8em;
            margin-bottom: 20px;
            color: #333;
        }
    </style>
</head>

<body>
    <?php include '../src/View/templates/header.php'; ?>
    <?php include '../src/View/templates/navigation.php'; ?>

    <div class="container dashboard-container">
        <div class="dashboard-header">
            <h2>Admin Dashboard</h2>
        </div>

        <div class="dashboard-cards">
            <div class="dashboard-card">
                <h3>Benutzer</h3>
                <p><?php echo $totalUsers; ?></p>
            </div>
            <div class="dashboard-card">
                <h3>Produkte</h3>
                <p><?php echo $totalProducts; ?></p>
            </div>
            <div class="dashboard-card">
                <h3>Bestellungen</h3>
                <p><?php echo $totalOrders; ?></p>
            </div>
        </div>

        <div class="dashboard-section">
            <h4>Verwaltungsaktionen</h4>
            <div class="dashboard-actions">
                <a href="manage_users.php">Benutzer verwalten</a>
                <a href="manage_products.php">Produkte verwalten</a>
                <a href="manage_orders.php">Bestellungen verwalten</a>
                <a href="sales_report.php">Verkaufsberichte</a>
            </div>
        </div>
    </div>

    <?php include '../src/View/templates/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
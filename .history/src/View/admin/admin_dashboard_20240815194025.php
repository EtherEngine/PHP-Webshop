<?php
// Session starten, wenn noch keine aktiv ist
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verbindung zur Datenbank herstellen
require __DIR__ . '/../../../config/db_connect.php';

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

// Metriken berechnen
$totalRevenue = 0;
$totalQuantity = 0;
$orderValues = [];
$productSales = [];
$monthlyRevenue = [];

foreach ($orders as $order) {
    $orderValue = $order['price'] * $order['quantity'];
    $totalRevenue += $orderValue;
    $totalQuantity += $order['quantity'];
    $orderValues[] = $orderValue;

    // Am meisten verkaufte Produkte
    if (!isset($productSales[$order['product_name']])) {
        $productSales[$order['product_name']] = 0;
    }
    $productSales[$order['product_name']] += $order['quantity'];

    // Einnahmen pro Monat
    $month = date('Y-m', strtotime($order['order_date']));
    if (!isset($monthlyRevenue[$month])) {
        $monthlyRevenue[$month] = 0;
    }
    $monthlyRevenue[$month] += $orderValue;
}

// Durchschnittlichen Bestellwert berechnen
$averageOrderValue = count($orderValues) > 0 ? array_sum($orderValues) / count($orderValues) : 0;

// Median des Bestellwerts berechnen
sort($orderValues);
$middle = floor((count($orderValues) - 1) / 2);
if (count($orderValues) % 2) {
    $medianOrderValue = $orderValues[$middle];
} else {
    $medianOrderValue = ($orderValues[$middle] + $orderValues[$middle + 1]) / 2;
}

// Am meisten verkaufte Produkte sortieren
arsort($productSales);
$topProducts = array_slice($productSales, 0, 5, true);

// Funktion zum Exportieren der Bestellungen als CSV
function exportCsv($orders)
{
    $filename = "orders_" . date('Ymd') . ".csv";
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=$filename");

    $output = fopen("php://output", "w");
    fputcsv($output, array('Vorname', 'Nachname', 'Email', 'Produkt', 'Menge', 'Preis', 'Bestelldatum'));

    foreach ($orders as $order) {
        fputcsv($output, $order);
    }

    fclose($output);
    exit;
}

// CSV-Export ausführen, wenn der Button geklickt wird
if (isset($_POST['export_csv'])) {
    exportCsv($orders);
}

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .stat-card {
            padding: 20px;
            margin-bottom: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .chart-container {
            margin-top: 30px;
        }

        @media (max-width: 768px) {
            .stat-card {
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Admin Dashboard</h1>

        <!-- Filter- und Suchfunktion -->
        <form method="GET" class="form-inline mb-4">
            <input type="text" name="search" class="form-control mr-2" placeholder="Suche nach Produkt, Benutzer, etc."
                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <input type="date" name="date_from" class="form-control mr-2" placeholder="Von Datum">
            <input type="date" name="date_to" class="form-control mr-2" placeholder="Bis Datum">
            <button type="submit" class="btn btn-primary">Filtern</button>
            <button type="submit" name="export_csv" class="btn btn-secondary ml-2">Exportieren als CSV</button>
        </form>

        <div class="row">
            <div class="col-md-4">
                <div class="stat-card">
                    <h3>Gesamtanzahl der Bestellungen</h3>
                    <p><?php echo count($orders); ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <h3>Gesamtumsatz</h3>
                    <p><?php echo number_format($totalRevenue, 2, ',', '.'); ?> €</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <h3>Durchschnittlicher Bestellwert</h3>
                    <p><?php echo number_format($averageOrderValue, 2, ',', '.'); ?> €</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <h3>Median des Bestellwerts</h3>
                    <p><?php echo number_format($medianOrderValue, 2, ',', '.'); ?> €</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <h3>Gesamtmenge der verkauften Produkte</h3>
                    <p><?php echo $totalQuantity; ?></p>
                </div>
            </div>
        </div>

        <h2>Am meisten verkaufte Produkte</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Produkt</th>
                    <th>Menge</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($topProducts as $product => $quantity): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product); ?></td>
                        <td><?php echo $quantity; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="chart-container">
            <h2>Einnahmen pro Monat</h2>
            <canvas id="monthlyRevenueChart"></canvas>
        </div>

        <!-- Links zu anderen Admin-Funktionen -->
        <a href="manage_products.php" class="btn btn-primary mt-4">Produkte verwalten</a>
        <a href="manage_users.php" class="btn btn-secondary mt-4">Benutzer verwalten</a>
    </div>

    <script>
        // Daten für das Umsatzdiagramm
        var ctx = document.getElementById('monthlyRevenueChart').getContext('2d');
        var monthlyRevenueChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_keys($monthlyRevenue)); ?>,
                datasets: [{
                    label: 'Einnahmen (€)',
                    data: <?php echo json_encode(array_values($monthlyRevenue)); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
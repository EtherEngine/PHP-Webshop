<?php
// Session starten, wenn noch keine aktiv ist
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verbindung zur Datenbank herstellen
require __DIR__ . '/../../../config/db_connect.php';

// Datenbankabfragen für Bestellungen und Produkte
$sqlOrders = "
    SELECT 
        orders.id AS order_id,
        users.firstname, 
        users.lastname, 
        users.email, 
        orders.status,
        products.name AS product_name, 
        order_items.quantity, 
        order_items.price,
        orders.order_date,
        users.region
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

$stmt = $pdo->prepare($sqlOrders);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Produkte für die Verwaltung laden
$sqlProducts = "SELECT * FROM products ORDER BY name ASC";
$stmt = $pdo->prepare($sqlProducts);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Daten für Umsatztrend
$sqlRevenueTrend = "SELECT DATE(order_date) AS date, SUM(price * quantity) AS total FROM orders JOIN order_items ON orders.id = order_items.order_id GROUP BY DATE(order_date)";
$stmt = $pdo->prepare($sqlRevenueTrend);
$stmt->execute();
$revenueTrendData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Daten für meistverkaufte Produkte
$sqlTopProducts = "SELECT products.name, SUM(order_items.quantity) AS total_sold FROM products JOIN order_items ON products.id = order_items.product_id GROUP BY products.name ORDER BY total_sold DESC LIMIT 10";
$stmt = $pdo->prepare($sqlTopProducts);
$stmt->execute();
$topProductsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Daten für Bestellstatus-Verteilung
$sqlOrderStatus = "SELECT status, COUNT(*) AS total FROM orders GROUP BY status";
$stmt = $pdo->prepare($sqlOrderStatus);
$stmt->execute();
$orderStatusData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Daten für Heatmap (Bestellaktivitäten nach Uhrzeit)
$sqlOrderHeatmap = "SELECT HOUR(order_date) AS hour, COUNT(*) AS total FROM orders GROUP BY HOUR(order_date)";
$stmt = $pdo->prepare($sqlOrderHeatmap);
$stmt->execute();
$orderHeatmapData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Daten für Verkäufe nach Region
$sqlSalesByRegion = "SELECT region, SUM(price * quantity) AS total_sales FROM users JOIN orders ON users.id = orders.user_id JOIN order_items ON orders.id = order_items.order_id GROUP BY region";
$stmt = $pdo->prepare($sqlSalesByRegion);
$stmt->execute();
$salesByRegionData = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Bestellungsverwaltung</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet"></script>
    <script src="https://cdn.jsdelivr.net/npm/heatmapjs"></script>
    <script src="https://cdn.jsdelivr.net/npm/gridstack@1.2.0/dist/gridstack.all.js"></script>
    <style>
        .order-management {
            margin-bottom: 50px;
            padding: 30px;
            background-color: #f1f1f1;
            border-radius: 8px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        }

        .order-management h2 {
            color: #007bff;
        }

        .order-actions button {
            margin-right: 10px;
        }

        .product-management {
            margin-top: 50px;
        }

        .product-actions button {
            margin-right: 10px;
        }

        .modal-header {
            background-color: #007bff;
            color: white;
        }

        .order-column {
            min-height: 400px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .order-item {
            padding: 10px;
            margin-bottom: 10px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: move;
        }

        .chart-container {
            margin-top: 50px;
        }

        .grid-stack-item-content {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        #mapid {
            height: 400px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Admin Dashboard - Bestellungsverwaltung</h1>

        <!-- Dashboard-Übersicht -->
        <div class="chart-container">
            <h2>Übersicht</h2>
            <div class="grid-stack">
                <div class="grid-stack-item" data-gs-width="6" data-gs-height="3">
                    <div class="grid-stack-item-content">
                        <h3>Umsatztrend</h3>
                        <canvas id="revenueTrendChart"></canvas>
                    </div>
                </div>
                <div class="grid-stack-item" data-gs-width="6" data-gs-height="3">
                    <div class="grid-stack-item-content">
                        <h3>Meistverkaufte Produkte</h3>
                        <canvas id="topProductsChart"></canvas>
                    </div>
                </div>
                <div class="grid-stack-item" data-gs-width="4" data-gs-height="3">
                    <div class="grid-stack-item-content">
                        <h3>Bestellstatus-Verteilung</h3>
                        <canvas id="orderStatusChart"></canvas>
                    </div>
                </div>
                <div class="grid-stack-item" data-gs-width="6" data-gs-height="3">
                    <div class="grid-stack-item-content">
                        <h3>Bestellaktivitäten (Heatmap)</h3>
                        <canvas id="orderHeatmap"></canvas>
                    </div>
                </div>
                <div class="grid-stack-item" data-gs-width="6" data-gs-height="3">
                    <div class="grid-stack-item-content">
                        <h3>Verkäufe nach Region</h3>
                        <div id="mapid"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bestellungsverwaltung -->
        <div class="order-management">
            <h2>Bestellungen verwalten</h2>
            <form method="GET" class="form-inline mb-4">
                <input type="text" name="search_order" class="form-control mr-2" placeholder="Bestellung suchen..."
                    value="<?php echo isset($_GET['search_order']) ? htmlspecialchars($_GET['search_order']) : ''; ?>">
                <button type="submit" class="btn btn-primary">Suchen</button>
            </form>

            <!-- Drag-and-Drop für Statusänderung -->
            <div class="row">
                <div class="col-md-4">
                    <h4>Ausstehend</h4>
                    <div class="order-column" id="pending">
                        <?php foreach ($orders as $order): ?>
                            <?php if ($order['status'] == 'pending'): ?>
                                <div class="order-item" data-order-id="<?php echo $order['order_id']; ?>">
                                    <strong><?php echo htmlspecialchars($order['product_name']); ?></strong>
                                    <br><?php echo htmlspecialchars($order['firstname'] . ' ' . $order['lastname']); ?>
                                    <br><?php echo number_format($order['price'], 2, ',', '.'); ?> €
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <h4>In Bearbeitung</h4>
                    <div class="order-column" id="processing">
                        <?php foreach ($orders as $order): ?>
                            <?php if ($order['status'] == 'processing'): ?>
                                <div class="order-item" data-order-id="<?php echo $order['order_id']; ?>">
                                    <strong><?php echo htmlspecialchars($order['product_name']); ?></strong>
                                    <br><?php echo htmlspecialchars($order['firstname'] . ' ' . $order['lastname']); ?>
                                    <br><?php echo number_format($order['price'], 2, ',', '.'); ?> €
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <h4>Abgeschlossen</h4>
                    <div class="order-column" id="completed">
                        <?php foreach ($orders as $order): ?>
                            <?php if ($order['status'] == 'completed'): ?>
                                <div class="order-item" data-order-id="<?php echo $order['order_id']; ?>">
                                    <strong><?php echo htmlspecialchars($order['product_name']); ?></strong>
                                    <br><?php echo htmlspecialchars($order['firstname'] . ' ' . $order['lastname']); ?>
                                    <br><?php echo number_format($order['price'], 2, ',', '.'); ?> €
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button id="applyMassAction" class="btn btn-secondary">Massenaktion anwenden</button>
                <button id="addNote" class="btn btn-info">Notiz hinzufügen</button>
            </div>
        </div>

        <!-- Produktverwaltung -->
        <div class="product-management">
            <h2>Produkte verwalten</h2>
            <button class="btn btn-success mb-4" data-toggle="modal" data-target="#addProductModal">Neues Produkt
                hinzufügen</button>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Produkt-ID</th>
                        <th>Name</th>
                        <th>Preis</th>
                        <th>Bestand</th>
                        <th>Aktionen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['id']); ?></td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo number_format($product['price'], 2, ',', '.'); ?> €</td>
                            <td><?php echo htmlspecialchars($product['stock']); ?></td>
                            <td class="product-actions">
                                <button class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#editProductModal-<?php echo $product['id']; ?>">Bearbeiten</button>
                                <button class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#deleteProductModal-<?php echo $product['id']; ?>">Löschen</button>
                            </td>
                        </tr>

                        <!-- Modal für Produkt bearbeiten -->
                        <div class="modal fade" id="editProductModal-<?php echo $product['id']; ?>" tabindex="-1"
                            role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editProductModalLabel">Produkt bearbeiten (ID:
                                            <?php echo $product['id']; ?>)
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Schließen">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Bearbeitungsformular -->
                                        <form action="update_product.php" method="POST">
                                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="<?php echo htmlspecialchars($product['name']); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="price">Preis</label>
                                                <input type="text" class="form-control" id="price" name="price"
                                                    value="<?php echo htmlspecialchars($product['price']); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="stock">Bestand</label>
                                                <input type="text" class="form-control" id="stock" name="stock"
                                                    value="<?php echo htmlspecialchars($product['stock']); ?>">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Speichern</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal für Produkt löschen -->
                        <div class="modal fade" id="deleteProductModal-<?php echo $product['id']; ?>" tabindex="-1"
                            role="dialog" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteProductModalLabel">Produkt löschen (ID:
                                            <?php echo $product['id']; ?>)
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Schließen">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Möchten Sie dieses Produkt wirklich löschen?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="delete_product.php" method="POST">
                                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                            <button type="submit" class="btn btn-danger">Löschen</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Abbrechen</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Modal für neues Produkt hinzufügen -->
        <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">Neues Produkt hinzufügen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Schließen">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Formular für neues Produkt -->
                        <form action="add_product.php" method="POST">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="form-group">
                                <label for="price">Preis</label>
                                <input type="text" class="form-control" id="price" name="price">
                            </div>
                            <div class="form-group">
                                <label for="stock">Bestand</label>
                                <input type="text" class="form-control" id="stock" name="stock">
                            </div>
                            <button type="submit" class="btn btn-primary">Speichern</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        $(function () {
            $(".order-column").sortable({
                connectWith: ".order-column",
                receive: function (event, ui) {
                    var orderId = ui.item.data("order-id");
                    var newStatus = $(this).attr("id");
                    $.post("update_order_status.php", { order_id: orderId, status: newStatus }, function (response) {
                        console.log(response);
                    });
                }
            }).disableSelection();
        });

        $("#applyMassAction").click(function () {
            // Massenaktionen Logik hinzufügen
            alert("Massenaktion wird ausgeführt.");
        });

        $("#addNote").click(function () {
            // Notiz Logik hinzufügen
            alert("Notiz hinzufügen.");
        });

        // Umsatztrend-Diagramm
        var ctx = document.getElementById('revenueTrendChart').getContext('2d');
        var revenueTrendChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_column($revenueTrendData, 'date')); ?>,
                datasets: [{
                    label: 'Umsatz',
                    data: <?php echo json_encode(array_column($revenueTrendData, 'total')); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Meistverkaufte Produkte
        var ctx2 = document.getElementById('topProductsChart').getContext('2d');
        var topProductsChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($topProductsData, 'name')); ?>,
                datasets: [{
                    label: 'Verkaufte Menge',
                    data: <?php echo json_encode(array_column($topProductsData, 'total_sold')); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Bestellstatus-Verteilung
        var ctx3 = document.getElementById('orderStatusChart').getContext('2d');
        var orderStatusChart = new Chart(ctx3, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode(array_column($orderStatusData, 'status')); ?>,
                datasets: [{
                    label: 'Bestellstatus',
                    data: <?php echo json_encode(array_column($orderStatusData, 'total')); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });

        // Bestellaktivitäten Heatmap
        var ctx4 = document.getElementById('orderHeatmap').getContext('2d');
        var orderHeatmap = new Chart(ctx4, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(range(0, 23)); ?>,
                datasets: [{
                    label: 'Bestellungen',
                    data: <?php echo json_encode(array_column($orderHeatmapData, 'total')); ?>,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Verkäufe nach Region (Leaflet Karte)
        var map = L.map('mapid').setView([51.505, -0.09], 2);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        <?php foreach ($salesByRegionData as $region): ?>
            var marker = L.marker([<?php echo $region['latitude']; ?>, <?php echo $region['longitude']; ?>]).addTo(map);
            marker.bindPopup("<b><?php echo htmlspecialchars($region['region']); ?></b><br>Umsatz: <?php echo number_format($region['total_sales'], 2, ',', '.'); ?> €");
        <?php endforeach; ?>

        // Gridstack initialisieren
        $(function () {
            $('.grid-stack').gridstack();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
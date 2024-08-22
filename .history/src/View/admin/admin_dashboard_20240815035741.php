<?php
include '../templates/header.php';
include '../templates/navigation.php';

require_once __DIR__ . '/../Controller/AdminController.php';

$admin = new AdminController();

// Statistiken abrufen
$totalUsers = $admin->getTotalUsers();
$totalOrders = $admin->getTotalOrders();
$totalSales = $admin->getTotalSales();
$recentOrders = $admin->getRecentOrders();
?>

<div class="container mt-5">
    <h1 class="mb-4">Admin Dashboard</h1>

    <!-- Übersichtliche Statistiken -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Benutzer</h5>
                    <p class="card-text"><?php echo $totalUsers; ?> registrierte Benutzer</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Bestellungen</h5>
                    <p class="card-text"><?php echo $totalOrders; ?> Gesamtbestellungen</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Verkäufe</h5>
                    <p class="card-text"><?php echo number_format($totalSales, 2, ',', '.'); ?> € Gesamtumsatz</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Benutzerverwaltung -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Benutzerverwaltung</h5>
        </div>
        <div class="card-body">
            <a href="manage_users.php" class="btn btn-primary">Benutzer verwalten</a>
        </div>
    </div>

    <!-- Produktverwaltung -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Produktverwaltung</h5>
        </div>
        <div class="card-body">
            <a href="manage_products.php" class="btn btn-primary">Produkte verwalten</a>
        </div>
    </div>

    <!-- Letzte Bestellungen -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Letzte Bestellungen</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kunde</th>
                        <th>Gesamtbetrag</th>
                        <th>Status</th>
                        <th>Datum</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentOrders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['id']); ?></td>
                            <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                            <td><?php echo htmlspecialchars($order['total']); ?> €</td>
                            <td><?php echo htmlspecialchars($order['status']); ?></td>
                            <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="manage_orders.php" class="btn btn-primary">Alle Bestellungen anzeigen</a>
        </div>
    </div>

    <!-- Verkaufsberichte -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Verkaufsberichte</h5>
        </div>
        <div class="card-body">
            <a href="sales_report.php" class="btn btn-primary">Berichte anzeigen</a>
        </div>
    </div>
</div>

<?php include '../templates/footer.php'; ?>
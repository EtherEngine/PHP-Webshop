<?php include '../templates/header.php'; ?>
<?php include '../templates/navigation.php'; ?>

<div class="container mt-5">
    <h1>Admin-Dashboard</h1>
    <div class="row">
        <div class="col-md-4">
            <a href="manage_users.php" class="btn btn-primary btn-block">Benutzer verwalten</a>
        </div>
        <div class="col-md-4">
            <a href="manage_products.php" class="btn btn-primary btn-block">Produkte verwalten</a>
        </div>
        <div class="col-md-4">
            <a href="manage_orders.php" class="btn btn-primary btn-block">Bestellungen einsehen</a>
        </div>
        <div class="col-md-4 mt-4">
            <a href="sales_report.php" class="btn btn-primary btn-block">Verkaufsberichte anzeigen</a>
        </div>
    </div>
</div>

<?php include '../templates/footer.php'; ?>
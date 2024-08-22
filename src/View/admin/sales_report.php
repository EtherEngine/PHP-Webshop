<?php
include '../templates/header.php';
include '../templates/navigation.php';

require_once __DIR__ . '/../Controller/AdminController.php';

$admin = new AdminController();
$salesReport = $admin->viewSalesReport();

?>

<div class="container mt-5">
    <h1>Verkaufsberichte</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Produkt-ID</th>
                <th>Verkaufte Menge</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($salesReport as $report): ?>
                <tr>
                    <td><?php echo htmlspecialchars($report['product_id']); ?></td>
                    <td><?php echo htmlspecialchars($report['total_sold']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../templates/footer.php'; ?>
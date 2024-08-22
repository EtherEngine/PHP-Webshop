<?php
include '../templates/header.php';
include '../templates/navigation.php';

require_once __DIR__ . '/../Controller/AdminController.php';

$admin = new AdminController();
$orders = $admin->viewOrders();

?>

<div class="container mt-5">
    <h1>Bestellungen verwalten</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Kunde</th>
                <th>Gesamtbetrag</th>
                <th>Status</th>
                <th>Aktionen</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['id']); ?></td>
                    <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                    <td><?php echo htmlspecialchars($order['total']); ?> €</td>
                    <td><?php echo htmlspecialchars($order['status']); ?></td>
                    <td>
                        <a href="view_order.php?id=<?php echo $order['id']; ?>" class="btn btn-primary">Details</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../templates/footer.php'; ?>
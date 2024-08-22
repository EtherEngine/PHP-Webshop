<?php
include '../templates/header.php';
include '../templates/navigation.php';

require_once __DIR__ . '/../Controller/AdminController.php';

$admin = new AdminController();
$products = $admin->viewProducts();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    $admin->deleteProduct($_POST['product_id']);
    header("Location: manage_products.php");
    exit();
}

?>

<div class="container mt-5">
    <h1>Produktverwaltung</h1>
    <a href="add_product.php" class="btn btn-success mb-3">Neues Produkt hinzufügen</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Produktname</th>
                <th>Preis</th>
                <th>Aktionen</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['id']); ?></td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td><?php echo htmlspecialchars($product['price']); ?> €</td>
                    <td>
                        <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">Bearbeiten</a>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <button type="submit" name="delete_product" class="btn btn-danger">Löschen</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../templates/footer.php'; ?>
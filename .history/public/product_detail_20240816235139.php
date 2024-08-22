<?php
session_start();
require __DIR__ . '/../config/db_connect.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        die('Produkt nicht gefunden');
    }

    // Ähnliche Produkte basierend auf tags abrufen
    $tags = explode(',', $product['tags']);
    $tagsLike = '%' . implode('%', $tags) . '%';
    $similarStmt = $pdo->prepare('SELECT * FROM products WHERE tags LIKE ? AND id != ? LIMIT 4');
    $similarStmt->execute([$tagsLike, $id]);
    $similarProducts = $similarStmt->fetchAll(PDO::FETCH_ASSOC);

} else {
    die('Ungültige Produkt-ID');
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - Produktdetails</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .custom-btn {
            background: linear-gradient(to bottom, #333, #666);
            color: white;
            border-radius: 5px;
            border: none;
            padding: 5px 10px;
            font-size: 14px;
        }

        .card-deck .card {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <?php include '../src/View/templates/header.php'; ?>
    <?php include '../src/View/templates/navigation.php'; ?>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="../assets/images/<?php echo htmlspecialchars($product['image'] ?? 'default.png'); ?>"
                    class="img-fluid" alt="<?php echo htmlspecialchars($product['name']); ?>">
            </div>
            <div class="col-md-6">
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <p><strong><?php echo htmlspecialchars($product['price']); ?> €</strong></p>
                <a href="javascript:history.back()" class="btn btn-primary custom-btn">Zurück</a>
            </div>
        </div>
        <hr>
        <h3>Ähnliche Produkte</h3>
        <div class="card-deck">
            <?php foreach ($similarProducts as $similarProduct): ?>
                <div class="card">
                    <img src="../assets/images/<?php echo htmlspecialchars($similarProduct['image'] ?? 'default.png'); ?>"
                        class="card-img-top" alt="<?php echo htmlspecialchars($similarProduct['name']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($similarProduct['name']); ?></h5>
                        <p class="card-text"><strong><?php echo htmlspecialchars($similarProduct['price']); ?> €</strong>
                        </p>
                        <a href="product_detail.php?id=<?php echo $similarProduct['id']; ?>"
                            class="btn btn-primary custom-btn">Ansehen</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php include '../src/View/templates/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
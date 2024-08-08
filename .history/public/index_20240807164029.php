<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop - Startseite</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <?php
    include '../src/View/templates/header.php';
    include '../src/View/templates/navigation.php';
    require __DIR__ . '/../config/db_connect.php';

    // Filterprodukte basierend auf der Suchanfrage
    $query = isset($_GET['query']) ? $_GET['query'] : '';
    if ($query) {
        $stmt = $pdo->prepare('SELECT * FROM products WHERE name LIKE ? OR description LIKE ?');
        $stmt->execute(["%$query%", "%$query%"]);
    } else {
        $stmt = $pdo->query('SELECT * FROM products');
    }
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <header class="hero-header">
        <div class="container text-center mt-5">
            <h1 class="display-4">Visionary Minds</h1>
            <p class="lead">Ihr Experte für KI-Innovationen – Entdecken Sie smarte Lösungen für alle Lebensbereiche!</p>
        </div>
    </header>
    <div class="container mt-5">
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="../assets/images/<?php echo htmlspecialchars($product['image']); ?>" class="card-img-top"
                            alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <div class="card-body">
                            <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                            <p class="card-text"><strong><?php echo htmlspecialchars($product['price']); ?> €</strong></p>
                            <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">Mehr
                                erfahren</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php include '../src/View/templates/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>

</html>
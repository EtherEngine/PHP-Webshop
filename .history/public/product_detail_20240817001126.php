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

    // Ähnliche Produkte basierend auf tags, name oder preis abrufen und zufällig sortieren
    $tags = explode(',', $product['tags']);
    $tagsLike = '%' . implode('%', $tags) . '%';
    $priceRange = [$product['price'] - 50, $product['price'] + 50]; // Preisbereich von +/- 50€
    $similarStmt = $pdo->prepare(
        'SELECT * FROM products WHERE (tags LIKE ? OR name LIKE ? OR (price BETWEEN ? AND ?)) AND id != ? ORDER BY RAND() LIMIT 8'
    );
    $similarStmt->execute([$tagsLike, '%' . $product['name'] . '%', ...$priceRange, $id]);
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
        body {
            background-color: #fff;
            color: #333;
        }

        .custom-btn {
            background: linear-gradient(to bottom, #333, #666);
            color: white;
            border-radius: 5px;
            border: none;
            padding: 8px 15px;
            font-size: 14px;
            margin-top: 15px;
        }

        .custom-btn:hover {
            background: linear-gradient(to bottom, #555, #888);
            color: #fff;
        }

        .card-deck .card {
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            color: #333;
            text-decoration: none;
            /* Entfernt die Unterstreichung von Links */
        }

        .card-deck .card:hover {
            background-color: #f8f9fa;
            /* Leicht hellerer Hintergrund bei Hover */
        }

        .card-title {
            font-size: 16px;
            font-weight: bold;
            height: 40px;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #333;
        }

        .rating {
            color: #f39c12;
        }

        .tooltip-inner {
            max-width: 300px;
            padding: 5px 10px;
            color: #fff;
            text-align: center;
            background-color: #444;
            border-radius: .25rem;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            filter: invert(100%);
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 5%;
            /* Verringert die Breite der Steuerelemente */
            z-index: 1000;
            /* Stellt sicher, dass sie nicht über den Karten liegen */
        }

        .carousel-indicators li {
            background-color: #555;
        }

        .carousel-indicators .active {
            background-color: #fff;
        }

        .container {
            padding-top: 20px;
            padding-bottom: 40px;
        }

        .row {
            margin-bottom: 30px;
        }

        .card-body {
            padding: 20px;
        }

        h1 {
            margin-bottom: 20px;
        }

        h3 {
            margin-top: 40px;
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
        <div id="similarProductsCarousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php foreach (array_chunk($similarProducts, 4) as $index => $productChunk): ?>
                    <li data-target="#similarProductsCarousel" data-slide-to="<?php echo $index; ?>"
                        class="<?php echo $index === 0 ? 'active' : ''; ?>"></li>
                <?php endforeach; ?>
            </ol>
            <div class="carousel-inner">
                <?php foreach (array_chunk($similarProducts, 4) as $index => $productChunk): ?>
                    <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                        <div class="card-deck">
                            <?php foreach ($productChunk as $similarProduct): ?>
                                <a href="product_detail.php?id=<?php echo $similarProduct['id']; ?>" class="card"
                                    data-toggle="tooltip" data-placement="top"
                                    title="<?php echo htmlspecialchars($similarProduct['name']); ?>">
                                    <img src="../assets/images/<?php echo htmlspecialchars($similarProduct['image'] ?? 'default.png'); ?>"
                                        class="card-img-top" alt="<?php echo htmlspecialchars($similarProduct['name']); ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($similarProduct['name']); ?></h5>
                                        <p class="card-text"><strong><?php echo htmlspecialchars($similarProduct['price']); ?>
                                                €</strong></p>
                                        <p class="card-text">
                                            <?php if ($similarProduct['stock'] > 0): ?>
                                                <span class="text-success">Auf Lager</span>
                                            <?php else: ?>
                                                <span class="text-danger">Nicht verfügbar</span>
                                            <?php endif; ?>
                                        </p>
                                        <p class="card-text rating">
                                            <?php
                                            $rating = 4; // Beispielhaft für festgelegte Bewertung
                                            for ($i = 0; $i < 5; $i++) {
                                                if ($i < $rating) {
                                                    echo '★';
                                                } else {
                                                    echo '☆';
                                                }
                                            }
                                            ?>
                                        </p>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <a class="carousel-control-prev" href="#similarProductsCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Zurück</span>
            </a>
            <a class="carousel-control-next" href="#similarProductsCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Weiter</span>
            </a>
        </div>
    </div>

    <?php include '../src/View/templates/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</body>

</html>
<?php

// Include the database connection file from the config directory
require __DIR__ . '/../config/db_connect.php';

// Check if the 'id' parameter is present in the URL query string
if (isset($_GET['id'])) {
    // Prepare a SQL statement to select the product with the specified ID
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');

    // Execute the SQL statement with the provided 'id' parameter
    $stmt->execute([$_GET['id']]);

    // Fetch the product data as an associative array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // If no product was found with the given ID, terminate the script with an error message
    if (!$product) {
        die('Produkt nicht gefunden');
    }

    // Fetch related products based on a different criteria, like excluding the current product
    $relatedStmt = $pdo->prepare('SELECT * FROM products WHERE id != ? LIMIT 4');
    $relatedStmt->execute([$product['id']]);
    $relatedProducts = $relatedStmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch product reviews
    $reviewsStmt = $pdo->prepare('SELECT * FROM reviews WHERE product_id = ?');
    $reviewsStmt->execute([$product['id']]);
    $reviews = $reviewsStmt->fetchAll(PDO::FETCH_ASSOC);

} else {
    // If the 'id' parameter is missing in the URL, terminate the script with an error message
    die('Ungültige Produkt-ID');
}

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <!-- Set character encoding for the HTML document -->
    <meta charset="UTF-8">

    <!-- Set viewport settings for responsive design -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Dynamically set the page title using the product's name, ensuring it's properly escaped to avoid XSS attacks -->
    <title><?php echo htmlspecialchars($product['name']); ?> - Produktdetails</title>

    <!-- Link to the custom stylesheet for additional styling -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Link to the Bootstrap CSS for responsive design and pre-built styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Startseite</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($product['name']); ?>
                </li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-6">
                <!-- Display product images -->
                <div id="productImages" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="assets/images/<?php echo htmlspecialchars($product['image']); ?>"
                                class="d-block w-100" alt="...">
                        </div>
                        <!-- Additional images can be added here -->
                    </div>
                    <a class="carousel-control-prev" href="#productImages" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#productImages" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <p><strong>Preis:</strong> <?php echo number_format($product['price'], 2, ',', '.'); ?> €</p>
                <p><strong>Verfügbarkeit:</strong>
                    <?php echo $product['stock'] > 0 ? 'Auf Lager' : 'Nicht verfügbar'; ?></p>

                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-primary">In den Warenkorb</button>
                    <button type="button" class="btn btn-secondary">Zur Wunschliste hinzufügen</button>
                </div>

                <div class="mt-4">
                    <h4>Produktbewertungen</h4>
                    <?php foreach ($reviews as $review): ?>
                        <div class="review">
                            <p><strong><?php echo htmlspecialchars($review['username']); ?>:</strong></p>
                            <p><?php echo htmlspecialchars($review['comment']); ?></p>
                            <p><strong>Bewertung:</strong> <?php echo htmlspecialchars($review['rating']); ?> / 5</p>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="related-products mt-5">
            <h3>Ähnliche Produkte</h3>
            <div class="row">
                <?php foreach ($relatedProducts as $related): ?>
                    <div class="col-md-3">
                        <div class="card">
                            <img src="assets/images/<?php echo htmlspecialchars($related['image']); ?>" class="card-img-top"
                                alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($related['name']); ?></h5>
                                <p class="card-text"><?php echo number_format($related['price'], 2, ',', '.'); ?> €</p>
                                <a href="product_detail.php?id=<?php echo $related['id']; ?>"
                                    class="btn btn-primary">Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>

    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
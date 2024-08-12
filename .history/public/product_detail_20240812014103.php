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

    <!-- Link to the Bootstrap CSS for responsive design and pre-built styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Custom Styles directly in the head section -->
    <style>
        .custom-btn {
            background: linear-gradient(to bottom, #333, #666);
            color: white;
            border-radius: 5px;
            border: none;
            padding: 5px 10px;
            font-size: 14px;

        }
    </style>
</head>

<body>
    <?php include '../src/View/templates/header.php'; ?>
    <?php include '../src/View/templates/navigation.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="../assets/images/<?php echo htmlspecialchars($product['image']); ?>" class="img-fluid"
                    alt="<?php echo htmlspecialchars($product['name']); ?>">
            </div>
            <div class="col-md-6">
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <p><strong><?php echo htmlspecialchars($product['price']); ?> €</strong></p>
                <a href="index.php" class="btn btn-primary custom-btn">Zurück</a>
            </div>
        </div>
    </div>
    <?php include '../src/View/templates/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
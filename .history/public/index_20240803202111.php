<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop - Startseite</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/scripts.js"></script>
</head>

<body>
    <?php include '../src/View/templates/header.php'; ?>
    <?php include '../src/View/templates/navigation.php'; ?>
    <div class="container">
        <h1>Willkommen in unserem Webshop</h1>
        <p>Entdecken Sie unsere Produkte.</p>
        <input type="text" id="search" placeholder="Produkte suchen...">
        <div id="searchList"></div>
    </div>
    <?php include '../src/View/templates/footer.php'; ?>
</body>

</html>
>
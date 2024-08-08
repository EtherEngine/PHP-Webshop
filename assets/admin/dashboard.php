<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>
    <?php include '../src/View/templates/header.php'; ?>
    <?php include '../src/View/templates/navigation.php'; ?>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <div class="admin-nav">
            <a href="products.php">Produkte verwalten</a>
            <a href="users.php">Benutzer verwalten</a>
        </div>
    </div>
    <?php include '../src/View/templates/footer.php'; ?>
</body>

</html>
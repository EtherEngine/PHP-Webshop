<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrierung</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php include '../src/View/templates/header.php'; ?>
    <div class="container">
        <h1>Registrierung</h1>
        <form action="register_user.php" method="POST">
            <label for="username">Benutzername:</label>
            <input type="text" id="username" name="username" required>
            <label for="email">E-Mail:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Passwort:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Registrieren">
        </form>
    </div>
    <?php include '../src/View/templates/footer.php'; ?>
</body>

</html>
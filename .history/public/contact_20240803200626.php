<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php include 'src/View/templates/header.php'; ?>
    <?php include 'src/View/templates/navigation.php'; ?>
    <div class="container">
        <h1>Kontakt</h1>
        <p>Kontaktieren Sie uns.</p>
        <form action="send_contact.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="email">E-Mail:</label>
            <input type="email" id="email" name="email" required>
            <label for="message">Nachricht:</label>
            <textarea id="message" name="message" required></textarea>
            <input type="submit" value="Senden">
        </form>
    </div>
    <?php include 'src/View/templates/footer.php'; ?>
</body>

</html>
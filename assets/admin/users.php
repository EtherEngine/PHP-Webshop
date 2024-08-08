<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzer verwalten</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>
    <?php include '../src/View/templates/header.php'; ?>
    <?php include '../src/View/templates/navigation.php'; ?>
    <div class="container">
        <h1>Benutzer verwalten</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Benutzername</th>
                    <th>E-Mail</th>
                    <th>Erstellt am</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Hier sollten die Benutzer aus der Datenbank abgerufen und angezeigt werden
                ?>
            </tbody>
        </table>
    </div>
    <?php include '../src/View/templates/footer.php'; ?>
</body>

</html>
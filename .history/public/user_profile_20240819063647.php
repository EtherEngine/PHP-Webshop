<?php
// Laden Sie die erforderlichen Dateien und starten Sie die Session
require __DIR__ . '/../config/db_connect.php';
require __DIR__ . '/../classes/Database.php';
require __DIR__ . '/../src/View/templates/header.php';
require __DIR__ . '/../classes/User.php';
require __DIR__ . '/../classes/Session.php';


Session::start();

if (!Session::isLoggedIn()) {
    Session::redirectToLogin();
}

$database = new Database('localhost', 'webshop', 'root', '');
$dbConnection = $database->getConnection();
$user = new User($dbConnection, Session::getUserId());

$profile_image = $user->getProfileImage();

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzerprofil</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container profile-container">
        <h2>Benutzerprofil</h2>
        <div class="text-center">
            <img src="../assets/images/images_user/<?php echo htmlspecialchars($profile_image); ?>" alt="Profilbild"
                class="profile-image">
        </div>
        <div class="profile-details">
            <div>
                <label>Vorname:</label>
                <p><?php echo htmlspecialchars($user->getFirstname()); ?></p>
            </div>
            <div>
                <label>Straße:</label>
                <p><?php echo htmlspecialchars($user->getStreet()); ?></p>
            </div>
            <div>
                <label>Nachname:</label>
                <p><?php echo htmlspecialchars($user->getLastname()); ?></p>
            </div>
            <div>
                <label>Hausnummer:</label>
                <p><?php echo htmlspecialchars($user->getHousenumber()); ?></p>
            </div>
            <div>
                <label>E-Mail:</label>
                <p><?php echo htmlspecialchars($user->getEmail()); ?></p>
            </div>
            <div>
                <label>Stadt:</label>
                <p><?php echo htmlspecialchars($user->getCity()); ?></p>
            </div>
            <div>
                <label>Postleitzahl:</label>
                <p><?php echo htmlspecialchars($user->getZipcode()); ?></p>
            </div>
            <div>
                <label>Land:</label>
                <p><?php echo htmlspecialchars($user->getCountry()); ?></p>
            </div>
        </div>
        <div class="mt-4 d-flex justify-content-between">
            <a href="edit_profile.php" class="btn btn-primary">Persönliche Daten bearbeiten</a>
            <a href="index.php" class="btn btn-back">Zurück zum Shop</a>
        </div>
    </div>
</body>

</html>
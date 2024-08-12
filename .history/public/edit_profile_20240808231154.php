<?php
session_start();
require __DIR__ . '/../config/db_connect.php';

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Benutzerinformationen aus der Datenbank abrufen
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT firstname, lastname, email, street, housenumber, city, zipcode, country, profile_image FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Standardbild, falls kein Profilbild vorhanden ist
$profile_image = !empty($user['profile_image']) ? $user['profile_image'] : 'profil_icon_w.png';

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil bearbeiten</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .profile-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 20px;
            position: relative;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-delete-image {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background-color: #ff0000;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            text-align: center;
            line-height: 25px;
            cursor: pointer;
        }

        .form-group img {
            max-width: 100%;
            height: auto;
        }

        .btn-primary,
        .btn-back {
            background: linear-gradient(to bottom, #333, #666);
            border: none;
            border-radius: 20px;
            color: white;
        }

        .btn-primary:hover,
        .btn-back:hover {
            background: linear-gradient(to bottom, #111, #444);
        }

        .profile-details {
            display: flex;
            flex-wrap: wrap;
        }

        .profile-details div {
            width: 50%;
            padding: 10px;
        }

        .profile-details label {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container profile-container">
        <h2>Profil bearbeiten</h2>
        <form action="update_profile.php" method="post" enctype="multipart/form-data">
            <div class="text-center">
                <img src="../assets/images/images_user/<?php echo htmlspecialchars($profile_image); ?>" alt="Profilbild"
                    class="profile-image">
                <?php if ($profile_image !== 'profil_icon_w.png'): ?>
                    <button type="button" class="btn-delete-image" onclick="confirmDeleteImage()">X</button>
                <?php endif; ?>
            </div>
            <div class="profile-details">
                <div class="form-group">
                    <label for="firstname">Vorname:</label>
                    <input type="text" class="form-control" id="firstname" name="firstname"
                        value="<?php echo htmlspecialchars($user['firstname']); ?>">
                </div>
                <div class="form-group">
                    <label for="street">Straße:</label>
                    <input type="text" class="form-control" id="street" name="street"
                        value="<?php echo htmlspecialchars($user['street']); ?>">
                </div>
                <div class="form-group">
                    <label for="lastname">Nachname:</label>
                    <input type="text" class="form-control" id="lastname" name="lastname"
                        value="<?php echo htmlspecialchars($user['lastname']); ?>">
                </div>
                <div class="form-group">
                    <label for="housenumber">Hausnummer:</label>
                    <input type="text" class="form-control" id="housenumber" name="housenumber"
                        value="<?php echo htmlspecialchars($user['housenumber']); ?>">
                </div>
                <div class="form-group">
                    <label for="email">E-Mail:</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="<?php echo htmlspecialchars($user['email']); ?>">
                </div>
                <div class="form-group">
                    <label for="city">Stadt:</label>
                    <input type="text" class="form-control" id="city" name="city"
                        value="<?php echo htmlspecialchars($user['city']); ?>">
                </div>
                <div class="form-group">
                    <label for="zipcode">Postleitzahl:</label>
                    <input type="text" class="form-control" id="zipcode" name="zipcode"
                        value="<?php echo htmlspecialchars($user['zipcode']); ?>">
                </div>
                <div class="form-group">
                    <label for="country">Land:</label>
                    <input type="text" class="form-control" id="country" name="country"
                        value="<?php echo htmlspecialchars($user['country']); ?>">
                </div>
                <div class="form-group">
                    <label for="profile_image">Profilbild:</label>
                    <input type="file" class="form-control-file" id="profile_image" name="profile_image">
                </div>
            </div>
            <div class="mt-4 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Profil speichern</button>
                <a href="user_profile.php" class="btn btn-back">Zurück zum Profil</a>
            </div>
        </form>
    </div>
    <script>
        function confirmDeleteImage() {
            if (confirm("Profilbild wirklich löschen?")) {
                window.location.href = 'delete_image.php';
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
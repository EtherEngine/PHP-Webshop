<?php
session_start();
require __DIR__ . '/../config/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Bild löschen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_image'])) {
    $stmt = $pdo->prepare('UPDATE users SET profile_image = NULL WHERE id = ?');
    $stmt->execute([$user_id]);

    if (file_exists(__DIR__ . '/../assets/images/images_user/' . $user['profile_image'])) {
        unlink(__DIR__ . '/../assets/images/images_user/' . $user['profile_image']);
    }
    header('Location: edit_profile.php');
    exit();
}

$error_message = '';
$success_message = '';

// Benutzerdaten aktualisieren
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['delete_image'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $street = $_POST['street'];
    $housenumber = $_POST['housenumber'];
    $city = $_POST['city'];
    $zipcode = $_POST['zipcode'];
    $country = $_POST['country'];

    // Überprüfen, ob die E-Mail-Adresse bereits verwendet wird
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? AND id != ?');
    $stmt->execute([$email, $user_id]);
    if ($stmt->rowCount() > 0) {
        $error_message = 'Die E-Mail-Adresse wird bereits verwendet.';
    } else {
        $stmt = $pdo->prepare('UPDATE users SET firstname = ?, lastname = ?, email = ?, street = ?, housenumber = ?, city = ?, zipcode = ?, country = ? WHERE id = ?');
        $stmt->execute([$firstname, $lastname, $email, $street, $housenumber, $city, $zipcode, $country, $user_id]);
        $success_message = 'Profil erfolgreich aktualisiert.';
    }

    // Profilbild hochladen
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['profile_image']['tmp_name'];
        $file_name = $_FILES['profile_image']['name'];
        $file_size = $_FILES['profile_image']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $valid_extensions = ['jpg', 'jpeg', 'png'];

        if (in_array($file_ext, $valid_extensions)) {
            if ($file_size <= 5000000) { // Maximal 5 MB
                $new_file_name = uniqid() . '.' . $file_ext;
                $file_destination = __DIR__ . '/../assets/images/images_user/' . $new_file_name;

                if (move_uploaded_file($file_tmp, $file_destination)) {
                    $stmt = $pdo->prepare('UPDATE users SET profile_image = ? WHERE id = ?');
                    $stmt->execute([$new_file_name, $user_id]);

                    if (!empty($user['profile_image']) && file_exists(__DIR__ . '/../assets/images/images_user/' . $user['profile_image'])) {
                        unlink(__DIR__ . '/../assets/images/images_user/' . $user['profile_image']);
                    }

                    $success_message = 'Profil und Bild erfolgreich aktualisiert.';
                } else {
                    $error_message = 'Fehler beim Hochladen des Bildes.';
                }
            } else {
                $error_message = 'Das Bild darf nicht größer als 5 MB sein.';
            }
        } else {
            $error_message = 'Nur JPG- und PNG-Bilder sind erlaubt.';
        }
    }
}

$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$countries = ['Deutschland', 'Österreich', 'Schweiz', 'Belgien', 'Niederlande', 'Luxemburg', 'Frankreich'];

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
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 20px;
            object-fit: cover;
        }

        .profile-image-container {
            position: relative;
            display: flex;
            justify-content: center;
        }

        .btn-delete-image {
            position: absolute;
            bottom: 0;
            right: 0;
            background: red;
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
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

        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
        }

        .popup {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .alert {
            margin-top: 20px;
        }

        .form-group img {
            display: block;
            margin: 10px auto;
            border-radius: 50%;
            max-width: 100px;
        }
    </style>
</head>

<body>
    <div class="container profile-container">
        <h2>Profil bearbeiten</h2>
        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success_message); ?></div>
        <?php endif; ?>
        <form action="edit_profile.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Profilbild</label>
                <div class="profile-image-container">
                    <img src="../assets/images/images_user/<?php echo !empty($user['profile_image']) ? htmlspecialchars($user['profile_image']) : 'profil_icon_w.png'; ?>"
                        alt="Profilbild" class="profile-image">
                    <?php if (!empty($user['profile_image'])): ?>
                        <button type="button" class="btn-delete-image">&times;</button>
                    <?php endif; ?>
                </div>
                <input type="file" name="profile_image" accept="image/*" class="form-control-file">
            </div>
            <div class="form-group">
                <label>Vorname</label>
                <input type="text" name="firstname" class="form-control"
                    value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
            </div>
            <div class="form-group">
                <label>Nachname</label>
                <input type="text" name="lastname" class="form-control"
                    value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
            </div>
            <div class="form-group">
                <label>E-Mail</label>
                <input type="email" name="email" class="form-control"
                    value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label>Straße</label>
                <input type="text" name="street" class="form-control"
                    value="<?php echo htmlspecialchars($user['street']); ?>" required>
            </div>
            <div class="form-group">
                <label>Hausnummer</label>
                <input type="text" name="housenumber" class="form-control"
                    value="<?php echo htmlspecialchars($user['housenumber']); ?>" required>
            </div>
            <div class="form-group">
                <label>Stadt</label>
                <input type="text" name="city" class="form-control"
                    value="<?php echo htmlspecialchars($user['city']); ?>" required>
            </div>
            <div class="form-group">
                <label>Postleitzahl</label>
                <input type="text" name="zipcode" class="form-control"
                    value="<?php echo htmlspecialchars($user['zipcode']); ?>" required>
            </div>
            <div class="form-group">
                <label>Land</label>
                <select name="country" class="form-control" required>
                    <?php foreach ($countries as $country): ?>
                        <option value="<?php echo htmlspecialchars($country); ?>" <?php echo $user['country'] == $country ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($country); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Speichern</button>
            <a href="user_profile.php" class="btn btn-back">Abbrechen</a>
        </form>
    </div>
    <div class="popup-overlay">
        <div class="popup">
            <p>Profilbild wirklich löschen?</p>
            <form action="edit_profile.php" method="POST">
                <button type="submit" name="delete_image" class="btn btn-danger">Ja</button>
                <button type="button" class="btn btn-secondary btn-cancel">Nein</button>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.btn-delete-image').on('click', function () {
                $('.popup-overlay').fadeIn();
            });

            $('.btn-cancel').on('click', function () {
                $('.popup-overlay').fadeOut();
            });
        });
    </script>
</body>

</html>
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

$profile_image = $user['profile_image'] ? $user['profile_image'] : 'profil_icon_w.png';

$countries = ['Deutschland', 'Österreich', 'Schweiz', 'USA', 'Kanada'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_image']) && $_POST['delete_image'] === 'yes') {
        $stmt = $pdo->prepare('UPDATE users SET profile_image = NULL WHERE id = ?');
        $stmt->execute([$user_id]);
        if ($profile_image !== 'profil_icon_w.png') {
            unlink('../assets/images/images_user/' . $profile_image);
        }
        $profile_image = 'profil_icon_w.png';
    } else {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $street = $_POST['street'];
        $housenumber = $_POST['housenumber'];
        $city = $_POST['city'];
        $zipcode = $_POST['zipcode'];
        $country = $_POST['country'];

        $profile_image_name = $profile_image;

        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $allowed_extensions = ['jpg', 'jpeg', 'png'];
            $file_extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);

            if (in_array($file_extension, $allowed_extensions)) {
                $profile_image_name = uniqid() . '.' . $file_extension;
                move_uploaded_file($_FILES['profile_image']['tmp_name'], '../assets/images/images_user/' . $profile_image_name);

                if ($profile_image !== 'profil_icon_w.png') {
                    unlink('../assets/images/images_user/' . $profile_image);
                }
            } else {
                echo '<script>alert("Format wird nicht unterstützt");</script>';
            }
        }

        $stmt = $pdo->prepare('UPDATE users SET firstname = ?, lastname = ?, email = ?, street = ?, housenumber = ?, city = ?, zipcode = ?, country = ?, profile_image = ? WHERE id = ?');
        $stmt->execute([$firstname, $lastname, $email, $street, $housenumber, $city, $zipcode, $country, $profile_image_name, $user_id]);

        header('Location: user_profile.php');
        exit();
    }
}

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

        .x-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #ff0000;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            cursor: pointer;
        }

        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .popup {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container profile-container">
        <h2>Profil bearbeiten</h2>
        <div class="text-center position-relative">
            <img src="../assets/images/images_user/<?php echo htmlspecialchars($profile_image); ?>" alt="Profilbild"
                class="profile-image">
            <?php if ($profile_image !== 'profil_icon_w.png'): ?>
                <button class="x-button" onclick="showPopup()">X</button>
            <?php endif; ?>
        </div>
        <form action="edit_profile.php" method="POST" enctype="multipart/form-data">
            <div class="profile-details">
                <div class="form-group">
                    <label for="firstname">Vorname</label>
                    <input type="text" class="form-control" id="firstname" name="firstname"
                        value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="street">Straße</label>
                    <input type="text" class="form-control" id="street" name="street"
                        value="<?php echo htmlspecialchars($user['street']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="lastname">Nachname</label>
                    <input type="text" class="form-control" id="lastname" name="lastname"
                        value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="housenumber">Hausnummer</label>
                    <input type="text" class="form-control" id="housenumber" name="housenumber"
                        value="<?php echo htmlspecialchars($user['housenumber']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">E-Mail</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="city">Stadt</label>
                    <input type="text" class="form-control" id="city" name="city"
                        value="<?php echo htmlspecialchars($user['city']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="zipcode">Postleitzahl</label>
                    <input type="text" class="form-control" id="zipcode" name="zipcode"
                        value="<?php echo htmlspecialchars($user['zipcode']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="country">Land</label>
                    <select class="form-control" id="country" name="country" required>
                        <?php foreach ($countries as $country): ?>
                            <option value="<?php echo htmlspecialchars($country); ?>" <?php echo $country === $user['country'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($country); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="profile_image">Profilbild ändern</label>
                    <input type="file" class="form-control-file" id="profile_image" name="profile_image"
                        accept="image/jpeg, image/png">
                </div>
            </div>
            <div class="mt-4 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Speichern</button>
                <a href="user_profile.php" class="btn btn-back">Zurück</a>
            </div>
        </form>
    </div>

    <div class="popup-overlay" id="popup-overlay">
        <div class="popup">
            <p>Profilbild wirklich löschen?</p>
            <form action="edit_profile.php" method="POST">
                <input type="hidden" name="delete_image" value="yes">
                <button type="submit" class="btn btn-danger">Ja</button>
                <button type="button" class="btn btn-secondary" onclick="hidePopup()">Nein</button>
            </form>
        </div>
    </div>

    <script>
        function showPopup() {
            document.getElementById('popup-overlay').style.display = 'flex';
        }

        function hidePopup() {
            document.getElementById('popup-overlay').style.display = 'none';
        }
    </script>
</body>

</html>
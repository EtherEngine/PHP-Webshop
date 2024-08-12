<?php
session_start();
require __DIR__ . '/../config/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT firstname, lastname, email, street, housenumber, city, zipcode, country, profile_image FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$profile_image = !empty($user['profile_image']) ? $user['profile_image'] : 'profil_icon_w.png';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $street = $_POST['street'];
    $housenumber = $_POST['housenumber'];
    $city = $_POST['city'];
    $zipcode = $_POST['zipcode'];
    $country = $_POST['country'];
    $profile_image = $_FILES['profile_image'];

    if ($profile_image && $profile_image['tmp_name']) {
        $allowed_types = ['image/jpeg', 'image/png'];
        if (in_array($profile_image['type'], $allowed_types)) {
            $image_path = __DIR__ . '/../assets/images/images_user/';
            if (!is_dir($image_path)) {
                mkdir($image_path, 0777, true);
            }

            $image_name = uniqid() . '-' . $profile_image['name'];
            move_uploaded_file($profile_image['tmp_name'], $image_path . $image_name);
            $stmt = $pdo->prepare('UPDATE users SET profile_image = ? WHERE id = ?');
            $stmt->execute([$image_name, $user_id]);
        } else {
            $error = "Format wird nicht unterstützt";
        }
    }

    $stmt = $pdo->prepare('UPDATE users SET firstname = ?, lastname = ?, email = ?, street = ?, housenumber = ?, city = ?, zipcode = ?, country = ? WHERE id = ?');
    $stmt->execute([$firstname, $lastname, $email, $street, $housenumber, $city, $zipcode, $country, $user_id]);

    header('Location: user_profile.php');
    exit();
}

if (isset($_POST['delete_image'])) {
    $stmt = $pdo->prepare('UPDATE users SET profile_image = ? WHERE id = ?');
    $stmt->execute(['profil_icon_w.png', $user_id]);
    header('Location: edit_profile.php');
    exit();
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

        .profile-image-container {
            position: relative;
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .profile-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        .btn-delete-image {
            position: absolute;
            bottom: 0;
            right: 0;
            background: red;
            color: white;
            border: none;
            border-radius: 50%;
            padding: 5px;
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

        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container profile-container">
        <h2>Profil bearbeiten</h2>
        <form action="edit_profile.php" method="POST" enctype="multipart/form-data">
            <div class="profile-image-container">
                <img src="../assets/images/images_user/<?php echo htmlspecialchars($profile_image); ?>" alt="Profilbild"
                    class="profile-image">
                <?php if ($profile_image !== 'profil_icon_w.png'): ?>
                    <button type="submit" name="delete_image" class="btn-delete-image">&times;</button>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="firstname">Vorname</label>
                <input type="text" class="form-control" id="firstname" name="firstname"
                    value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
            </div>
            <div class="form-group">
                <label for="lastname">Nachname</label>
                <input type="text" class="form-control" id="lastname" name="lastname"
                    value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">E-Mail</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="street">Straße</label>
                <input type="text" class="form-control" id="street" name="street"
                    value="<?php echo htmlspecialchars($user['street']); ?>" required>
            </div>
            <div class="form-group">
                <label for="housenumber">Hausnummer</label>
                <input type="text" class="form-control" id="housenumber" name="housenumber"
                    value="<?php echo htmlspecialchars($user['housenumber']); ?>" required>
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
                <input type="text" class="form-control" id="country" name="country"
                    value="<?php echo htmlspecialchars($user['country']); ?>" required>
            </div>
            <div class="form-group">
                <label for="profile_image">Profilbild ändern</label>
                <input type="file" class="form-control-file" id="profile_image" name="profile_image"
                    accept=".jpg, .jpeg, .png">
            </div>
            <button type="submit" class="btn btn-primary">Speichern</button>
            <a href="user_profile.php" class="btn btn-back">Zurück</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
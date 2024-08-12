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

$countries = ["Deutschland", "Österreich", "Schweiz", "Belgien", "Niederlande", "Frankreich", "Italien", "Spanien", "Portugal", "Großbritannien", "Irland", "Dänemark", "Schweden", "Norwegen", "Finnland", "Polen", "Tschechien", "Ungarn", "Griechenland", "Türkei"];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $street = htmlspecialchars($_POST['street']);
    $housenumber = htmlspecialchars($_POST['housenumber']);
    $city = htmlspecialchars($_POST['city']);
    $zipcode = htmlspecialchars($_POST['zipcode']);
    $country = htmlspecialchars($_POST['country']);
    $profile_image = $user['profile_image'];

    if (!empty($_FILES['profile_image']['name'])) {
        $allowed_exts = ['jpg', 'jpeg', 'png'];
        $file_ext = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));

        if (in_array($file_ext, $allowed_exts)) {
            $image_name = time() . '_' . $_FILES['profile_image']['name'];
            $image_path = '../assets/images/images_user/' . $image_name;
            move_uploaded_file($_FILES['profile_image']['tmp_name'], $image_path);
            $profile_image = $image_name;
        } else {
            $error_message = 'Nur .jpg und .png Dateien sind erlaubt.';
        }
    }

    $stmt = $pdo->prepare('UPDATE users SET firstname = ?, lastname = ?, email = ?, street = ?, housenumber = ?, city = ?, zipcode = ?, country = ?, profile_image = ? WHERE id = ?');
    $stmt->execute([$firstname, $lastname, $email, $street, $housenumber, $city, $zipcode, $country, $profile_image, $user_id]);

    $_SESSION['success_message'] = 'Profil erfolgreich aktualisiert.';
    header('Location: user_profile.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persönliche Daten bearbeiten</title>
    <link rel="stylesheet" href="assets/css/style.css">
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

        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
    </style>
</head>

<body>
    <?php include '../src/View/templates/header.php'; ?>
    <div class="container profile-container">
        <h2>Persönliche Daten bearbeiten</h2>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form action="edit_profile.php" method="POST" enctype="multipart/form-data">
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
                <select class="form-control" id="country" name="country" required>
                    <?php foreach ($countries as $country): ?>
                        <option value="<?php echo $country; ?>" <?php echo ($user['country'] == $country) ? 'selected' : ''; ?>>
                            <?php echo $country; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="profile_image">Profilbild</label>
                <input type="file" class="form-control-file" id="profile_image" name="profile_image"
                    accept=".jpg, .jpeg, .png">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Speichern</button>
            <a href="user_profile.php" class="btn btn-back btn-block">Zurück</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
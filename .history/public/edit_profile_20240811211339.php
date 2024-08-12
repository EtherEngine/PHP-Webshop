<?php
session_start();  // Starts the session to access session variables.

require __DIR__ . '/../config/db_connect.php';  // Establishes a database connection by including the DB script.

if (!isset($_SESSION['user_id'])) {  // Checks if the user is logged in. If not, redirects to the login page.
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];  // Retrieves the user ID from the session.
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');  // Prepares an SQL statement to fetch user data by user ID.
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);  // Fetches the user data as an associative array.

$countries = ["Deutschland", "Österreich", "Schweiz", "Belgien", "Niederlande", "Frankreich", "Italien", "Spanien", "Portugal", "Großbritannien", "Irland", "Dänemark", "Schweden", "Norwegen", "Finnland", "Polen", "Tschechien", "Ungarn", "Griechenland", "Türkei"]; // Defines a list of countries for the selection in the form.

$profile_image = $user['profile_image'] ? $user['profile_image'] : 'profil_icon_w.png';  // Sets the user's profile image or a default image if none is available.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // Checks if the form was submitted via POST method.
    // Processes form inputs, using htmlspecialchars to prevent XSS attacks and filter_var to validate the email.
    $firstname = isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : $user['firstname'];
    $lastname = isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : $user['lastname'];
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : $user['email'];
    $street = isset($_POST['street']) ? htmlspecialchars($_POST['street']) : $user['street'];
    $housenumber = isset($_POST['housenumber']) ? htmlspecialchars($_POST['housenumber']) : $user['housenumber'];
    $city = isset($_POST['city']) ? htmlspecialchars($_POST['city']) : $user['city'];
    $zipcode = isset($_POST['zipcode']) ? htmlspecialchars($_POST['zipcode']) : $user['zipcode'];
    $country = isset($_POST['country']) ? htmlspecialchars($_POST['country']) : $user['country'];
    $profile_image = $user['profile_image'];

    if (isset($_POST['delete_image']) && $_POST['delete_image'] == 'yes') {  // Checks if the profile image should be deleted.
        $profile_image = 'profil_icon_w.png';  // Sets the profile image to the default image.
        $stmt = $pdo->prepare('UPDATE users SET profile_image = ? WHERE id = ?');
        $stmt->execute([$profile_image, $user_id]);
    } elseif (!empty($_FILES['profile_image']['name'])) {  // Checks if a new image was uploaded.
        $allowed_exts = ['jpg', 'jpeg', 'png'];  // Allowed file formats.
        $file_ext = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));

        if (in_array($file_ext, $allowed_exts)) {  // Checks if the file extension is allowed.
            $image_name = time() . '_' . $_FILES['profile_image']['name'];  // Generates a unique name for the image.
            $image_path = '../assets/images/images_user/' . $image_name;
            move_uploaded_file($_FILES['profile_image']['tmp_name'], $image_path);  // Saves the uploaded image to the appropriate directory.
            $profile_image = $image_name;
        } else {
            $error_message = 'Unsupported format. Only .jpg, .jpeg, and .png are allowed.';  // Sets an error message if the image format is not supported.
        }
    }

    if (!isset($error_message)) {  // If no errors occurred, updates the user data in the database.
        $stmt = $pdo->prepare('UPDATE users SET firstname = ?, lastname = ?, email = ?, street = ?, housenumber = ?, city = ?, zipcode = ?, country = ?, profile_image = ? WHERE id = ?');
        $stmt->execute([$firstname, $lastname, $email, $street, $housenumber, $city, $zipcode, $country, $profile_image, $user_id]);

        $_SESSION['success_message'] = 'Profile updated successfully.';  // Sets a success message in the session.
        header('Location: user_profile.php');  // Redirects the user back to the profile page.
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persönliche Daten bearbeiten</title>
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
            width: 100px;
            height: 100px;
            margin-bottom: 20px;
        }

        .profile-image {
            width: 100%;
            height: 100%;
            border-radius: 50%;
        }

        .delete-icon {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background-color: #fff;
            border: 1px solid #ccc;
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

        .profile-details {
            display: flex;
            flex-wrap: wrap;
        }

        .profile-details .form-group {
            width: 50%;
            padding: 10px;
        }

        .profile-details label {
            font-weight: bold;
        }

        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .form-control-file {
            margin-top: 10px;
        }

        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .popup {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .popup button {
            margin: 10px;
        }
    </style>
</head>

<body>
    <div class="container profile-container">
        <h2>Persönliche Daten bearbeiten</h2>
        <div class="text-center profile-image-container">
            <img src="../assets/images/images_user/<?php echo htmlspecialchars($profile_image); ?>" alt="Profilbild"
                class="profile-image">
            <div class="delete-icon" onclick="showPopup()">x</div>
        </div>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
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
            </div>
            <div class="mt-4 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Speichern</button>
                <a href="user_profile.php" class="btn btn-back">Zurück zum Profil</a>
            </div>
        </form>
    </div>

    <div class="popup-overlay" id="popup-overlay">
        <div class="popup">
            <p>Profilbild wirklich löschen?</p>
            <form action="edit_profile.php" method="POST">
                <input type="hidden" name="delete_image" value="yes">
                <button type="submit" class="btn btn-primary">Ja</button>
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

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
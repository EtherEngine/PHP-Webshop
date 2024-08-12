<?php
session_start();  // Start the session to access session variables.

require __DIR__ . '/../config/db_connect.php';  // Include the database connection script.

if (!isset($_SESSION['user_id'])) {  // Check if the user is logged in. If not, redirect to the login page.
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];  // Retrieve the user ID from the session.
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');  // Prepare an SQL statement to fetch user data by user ID.
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);  // Fetch the user data as an associative array.

$countries = [
    "Afghanistan",
    "Albania",
    "Algeria",
    "Andorra",
    "Angola",
    "Antigua and Barbuda",
    "Argentina",
    "Armenia",
    "Australia",
    "Austria",
    "Azerbaijan",
    "Bahamas",
    "Bahrain",
    "Bangladesh",
    "Barbados",
    "Belarus",
    "Belgium",
    "Belize",
    "Benin",
    "Bhutan",
    "Bolivia",
    "Bosnia and Herzegovina",
    "Botswana",
    "Brazil",
    "Brunei",
    "Bulgaria",
    "Burkina Faso",
    "Burundi",
    "Cabo Verde",
    "Cambodia",
    "Cameroon",
    "Canada",
    "Central African Republic",
    "Chad",
    "Chile",
    "China",
    "Colombia",
    "Comoros",
    "Congo, Democratic Republic of the",
    "Congo, Republic of the",
    "Costa Rica",
    "Croatia",
    "Cuba",
    "Cyprus",
    "Czech Republic",
    "Denmark",
    "Djibouti",
    "Dominica",
    "Dominican Republic",
    "East Timor",
    "Ecuador",
    "Egypt",
    "El Salvador",
    "Equatorial Guinea",
    "Eritrea",
    "Estonia",
    "Eswatini",
    "Ethiopia",
    "Fiji",
    "Finland",
    "France",
    "Gabon",
    "Gambia",
    "Georgia",
    "Germany",
    "Ghana",
    "Greece",
    "Grenada",
    "Guatemala",
    "Guinea",
    "Guinea-Bissau",
    "Guyana",
    "Haiti",
    "Honduras",
    "Hungary",
    "Iceland",
    "India",
    "Indonesia",
    "Iran",
    "Iraq",
    "Ireland",
    "Israel",
    "Italy",
    "Ivory Coast",
    "Jamaica",
    "Japan",
    "Jordan",
    "Kazakhstan",
    "Kenya",
    "Kiribati",
    "Korea, North",
    "Korea, South",
    "Kosovo",
    "Kuwait",
    "Kyrgyzstan",
    "Laos",
    "Latvia",
    "Lebanon",
    "Lesotho",
    "Liberia",
    "Libya",
    "Liechtenstein",
    "Lithuania",
    "Luxembourg",
    "Madagascar",
    "Malawi",
    "Malaysia",
    "Maldives",
    "Mali",
    "Malta",
    "Marshall Islands",
    "Mauritania",
    "Mauritius",
    "Mexico",
    "Micronesia",
    "Moldova",
    "Monaco",
    "Mongolia",
    "Montenegro",
    "Morocco",
    "Mozambique",
    "Myanmar",
    "Namibia",
    "Nauru",
    "Nepal",
    "Netherlands",
    "New Zealand",
    "Nicaragua",
    "Niger",
    "Nigeria",
    "North Macedonia",
    "Norway",
    "Oman",
    "Pakistan",
    "Palau",
    "Panama",
    "Papua New Guinea",
    "Paraguay",
    "Peru",
    "Philippines",
    "Poland",
    "Portugal",
    "Qatar",
    "Romania",
    "Russia",
    "Rwanda",
    "Saint Kitts and Nevis",
    "Saint Lucia",
    "Saint Vincent and the Grenadines",
    "Samoa",
    "San Marino",
    "Sao Tome and Principe",
    "Saudi Arabia",
    "Senegal",
    "Serbia",
    "Seychelles",
    "Sierra Leone",
    "Singapore",
    "Slovakia",
    "Slovenia",
    "Solomon Islands",
    "Somalia",
    "South Africa",
    "South Sudan",
    "Spain",
    "Sri Lanka",
    "Sudan",
    "Suriname",
    "Sweden",
    "Switzerland",
    "Syria",
    "Taiwan",
    "Tajikistan",
    "Tanzania",
    "Thailand",
    "Togo",
    "Tonga",
    "Trinidad and Tobago",
    "Tunisia",
    "Turkey",
    "Turkmenistan",
    "Tuvalu",
    "Uganda",
    "Ukraine",
    "United Arab Emirates",
    "United Kingdom",
    "United States",
    "Uruguay",
    "Uzbekistan",
    "Vanuatu",
    "Vatican City",
    "Venezuela",
    "Vietnam",
    "Yemen",
    "Zambia",
    "Zimbabwe"
];

// Handle form submission.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : $user['firstname'];
    $lastname = isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : $user['lastname'];
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : $user['email'];
    $street = isset($_POST['street']) ? htmlspecialchars($_POST['street']) : $user['street'];
    $housenumber = isset($_POST['housenumber']) ? htmlspecialchars($_POST['housenumber']) : $user['housenumber'];
    $city = isset($_POST['city']) ? htmlspecialchars($_POST['city']) : $user['city'];
    $zipcode = isset($_POST['zipcode']) ? htmlspecialchars($_POST['zipcode']) : $user['zipcode'];
    $country = isset($_POST['country']) ? htmlspecialchars($_POST['country']) : $user['country'];
    $profile_image = $user['profile_image'];

    // Handle profile image deletion.
    if (isset($_POST['delete_image']) && $_POST['delete_image'] == 'yes') {
        $profile_image = 'profil_icon_w.png';
        $stmt = $pdo->prepare('UPDATE users SET profile_image = ? WHERE id = ?');
        $stmt->execute([$profile_image, $user_id]);
    } elseif (!empty($_FILES['profile_image']['name'])) {
        $allowed_exts = ['jpg', 'jpeg', 'png'];
        $file_ext = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));

        if (in_array($file_ext, $allowed_exts)) {
            $image_name = time() . '_' . $_FILES['profile_image']['name'];
            $image_path = '../assets/images/images_user/' . $image_name;
            move_uploaded_file($_FILES['profile_image']['tmp_name'], $image_path);
            $profile_image = $image_name;
        } else {
            $error_message = 'Unsupported format. Only .jpg, .jpeg, and .png are allowed.';
        }
    }

    // Update the user data in the database if there are no errors.
    if (!isset($error_message)) {
        $stmt = $pdo->prepare('UPDATE users SET firstname = ?, lastname = ?, email = ?, street = ?, housenumber = ?, city = ?, zipcode = ?, country = ?, profile_image = ? WHERE id = ?');
        $stmt->execute([$firstname, $lastname, $email, $street, $housenumber, $city, $zipcode, $country, $profile_image, $user_id]);

        $_SESSION['success_message'] = 'Profile updated successfully.';
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
    <title>Persönliche Daten bearbeiten</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Styling for the profile container */
        .profile-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        /* Styling for the profile image container */
        .profile-image-container {
            position: relative;
            width: 100px;
            height: 100px;
            margin-bottom: 20px;
        }

        /* Styling for the profile image */
        .profile-image {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Styling for the delete icon */
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

        /* Styling for buttons */
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

        /* Styling for profile details form */
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

        /* Styling for popup overlay */
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

        /* Styling for the popup */
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
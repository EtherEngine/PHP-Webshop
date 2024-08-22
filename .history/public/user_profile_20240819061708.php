<?php
require __DIR__ . '/../config/db_connect.php';
require __DIR__ . '/../classes/Database.php';
require __DIR__ . '/../classes/User.php';
require __DIR__ . '/../classes/Session.php';

Session::start();

if (!Session::isLoggedIn()) {
    Session::redirectToLogin();
}

$database = new Database('localhost', 'dbname', 'username', 'password');
$dbConnection = $database->getConnection();
$user = new User($dbConnection, Session::getUserId());
$userDetails = $user->getUserProfile();

$profile_image = $userDetails['profile_image'] ? $userDetails['profile_image'] : 'profil_icon_w.png';
?>


<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzerprofil</title>
    <!-- Link to the custom CSS stylesheet -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- Link to the Bootstrap CSS for responsive design and styling -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Style for the profile container */
        .profile-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        /* Style for the profile image */
        .profile-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        /* Style for primary and back buttons */
        .btn-primary,
        .btn-back {
            background: linear-gradient(to bottom, #333, #666);
            border: none;
            border-radius: 20px;
            color: white;
        }

        /* Hover effect for primary and back buttons */
        .btn-primary:hover,
        .btn-back:hover {
            background: linear-gradient(to bottom, #111, #444);
        }

        /* Style for the profile details section */
        .profile-details {
            display: flex;
            flex-wrap: wrap;
        }

        /* Style for each detail in the profile section */
        .profile-details div {
            width: 50%;
            padding: 10px;
        }

        /* Style for the labels in the profile details */
        .profile-details label {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container profile-container">
        <h2>Benutzerprofil</h2>
        <div class="text-center">
            <!-- Display the user's profile image, or a default image if not available -->
            <img src="../assets/images/images_user/<?php echo htmlspecialchars($profile_image); ?>" alt="Profilbild"
                class="profile-image">
        </div>
        <div class="profile-details">
            <!-- Display user's first name -->
            <div>
                <label>Vorname:</label>
                <p><?php echo htmlspecialchars($user['firstname']); ?></p>
            </div>
            <!-- Display user's street -->
            <div>
                <label>Straße:</label>
                <p><?php echo htmlspecialchars($user['street']); ?></p>
            </div>
            <!-- Display user's last name -->
            <div>
                <label>Nachname:</label>
                <p><?php echo htmlspecialchars($user['lastname']); ?></p>
            </div>
            <!-- Display user's house number -->
            <div>
                <label>Hausnummer:</label>
                <p><?php echo htmlspecialchars($user['housenumber']); ?></p>
            </div>
            <!-- Display user's email address -->
            <div>
                <label>E-Mail:</label>
                <p><?php echo htmlspecialchars($user['email']); ?></p>
            </div>
            <!-- Display user's city -->
            <div>
                <label>Stadt:</label>
                <p><?php echo htmlspecialchars($user['city']); ?></p>
            </div>
            <!-- Display user's postal code -->
            <div>
                <label>Postleitzahl:</label>
                <p><?php echo htmlspecialchars($user['zipcode']); ?></p>
            </div>
            <!-- Display user's country -->
            <div>
                <label>Land:</label>
                <p><?php echo htmlspecialchars($user['country']); ?></p>
            </div>
        </div>
        <div class="mt-4 d-flex justify-content-between">
            <!-- Link to the edit profile page -->
            <a href="edit_profile.php" class="btn btn-primary">Persönliche Daten bearbeiten</a>
            <!-- Link to return to the shop -->
            <a href="index.php" class="btn btn-back">Zurück zum Shop</a>
        </div>
    </div>
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Include Popper.js library -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <!-- Include Bootstrap's JavaScript library -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
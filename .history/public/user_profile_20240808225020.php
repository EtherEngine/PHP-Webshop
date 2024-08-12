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
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzerprofil</title>
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
        <h2>Benutzerprofil</h2>
        <div class="text-center">
            <img src="../assets/images/images_user/<?php echo htmlspecialchars($profile_image); ?>" alt="Profilbild"
                class="profile-image">
        </div>
        <div class="profile-details">
            <div>
                <label>Vorname:</label>
                <p><?php echo htmlspecialchars($user['firstname']); ?></p>
            </div>
            <div>
                <label>Straße:</label>
                <p><?php echo htmlspecialchars($user['street']); ?></p>
            </div>
            <div>
                <label>Nachname:</label>
                <p><?php echo htmlspecialchars($user['lastname']); ?></p>
            </div>
            <div>
                <label>Hausnummer:</label>
                <p><?php echo htmlspecialchars($user['housenumber']); ?></p>
            </div>
            <div>
                <label>E-Mail:</label>
                <p><?php echo htmlspecialchars($user['email']); ?></p>
            </div>
            <div>
                <label>Stadt:</label>
                <p><?php echo htmlspecialchars($user['city']); ?></p>
            </div>
            <div>
                <label>Postleitzahl:</label>
                <p><?php echo htmlspecialchars($user['zipcode']); ?></p>
            </div>
            <div>
                <label>Land:</label>
                <p><?php echo htmlspecialchars($user['country']); ?></p>
            </div>
        </div>
        <div class="mt-4 d-flex justify-content-between">
            <a href="edit_profile.php" class="btn btn-primary">Persönliche Daten bearbeiten</a>
            <a href="index.php" class="btn btn-back">Zurück zum Shop</a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
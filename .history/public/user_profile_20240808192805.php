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
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzerprofil</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
    <?php
    include '../src/View/templates/header.php';
    include '../src/View/templates/navigation.php';
    ?>

    <div class="container profile-container">
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success_message'];
                unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>
        <h2>Benutzerprofil</h2>
        <div class="text-center">
            <img src="../assets/images/<?php echo htmlspecialchars($user['profile_image'] ?: 'default_profile.png'); ?>"
                alt="Profilbild" class="profile-image">
        </div>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Vorname:</strong> <?php echo htmlspecialchars($user['firstname']); ?></p>
                <p><strong>Nachname:</strong> <?php echo htmlspecialchars($user['lastname']); ?></p>
                <p><strong>E-Mail:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Straße:</strong> <?php echo htmlspecialchars($user['street']); ?></p>
                <p><strong>Hausnummer:</strong> <?php echo htmlspecialchars($user['housenumber']); ?></p>
                <p><strong>Stadt:</strong> <?php echo htmlspecialchars($user['city']); ?></p>
                <p><strong>Postleitzahl:</strong> <?php echo htmlspecialchars($user['zipcode']); ?></p>
                <p><strong>Land:</strong> <?php echo htmlspecialchars($user['country']); ?></p>
            </div>
        </div>
        <a href="edit_profile.php" class="btn btn-primary btn-block">Persönliche Daten bearbeiten</a>
        <a href="index.php" class="btn btn-back btn-block">Zurück zum Shop</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
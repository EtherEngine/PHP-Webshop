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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $profile_image = $user['profile_image'];

    if (!empty($_FILES['profile_image']['name'])) {
        $image_name = time() . '_' . $_FILES['profile_image']['name'];
        $image_path = '../assets/images/' . $image_name;
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $image_path);
        $profile_image = $image_name;
    }

    $stmt = $pdo->prepare('UPDATE users SET username = ?, email = ?, address = ?, profile_image = ? WHERE id = ?');
    $stmt->execute([$username, $email, $address, $profile_image, $user_id]);

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
    <title>Benutzerprofil</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .profile-container {
            max-width: 600px;
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

        .form-control,
        .btn {
            border-radius: 20px;
        }

        .btn-primary {
            background: linear-gradient(to bottom, #333, #666);
            border: none;
        }

        .btn-primary:hover {
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
        <form action="user_profile.php" method="POST" enctype="multipart/form-data">
            <div class="text-center">
                <img src="../assets/images/<?php echo htmlspecialchars($user['profile_image'] ?: 'default_profile.png'); ?>"
                    alt="Profilbild" class="profile-image">
            </div>
            <div class="form-group">
                <label for="username">Benutzername</label>
                <input type="text" class="form-control" id="username" name="username"
                    value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">E-Mail</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Adresse</label>
                <input type="text" class="form-control" id="address" name="address"
                    value="<?php echo htmlspecialchars($user['address']); ?>">
            </div>
            <div class="form-group">
                <label for="profile_image">Profilbild</label>
                <input type="file" class="form-control-file" id="profile_image" name="profile_image">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Profil aktualisieren</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
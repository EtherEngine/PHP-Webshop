<?php
session_start();
require __DIR__ . '/../config/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Profilbild aus der Datenbank abrufen
$stmt = $pdo->prepare('SELECT profile_image FROM users WHERE id = ?');
stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && $user['profile_image'] !== 'profil_icon_w.png') {
    // Profilbild löschen
    $profile_image_path = __DIR__ . '/../assets/images/images_user/' . $user['profile_image'];
    if (file_exists($profile_image_path)) {
        unlink($profile_image_path);
    }

    // Standardbild in der Datenbank setzen
    $stmt = $pdo->prepare('UPDATE users SET profile_image = "profil_icon_w.png" WHERE id = ?');
    $stmt->execute([$user_id]);
}

header('Location: edit_profile.php');
exit();
?>
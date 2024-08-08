<?php

require __DIR__ . '/../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Überprüfen, ob der Benutzername bereits existiert
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? OR email = ?');
    $stmt->execute([$username, $email]);
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        if ($existingUser['username'] == $username) {
            echo 'Benutzername bereits vergeben. Bitte wählen Sie einen anderen.';
        } elseif ($existingUser['email'] == $email) {
            echo 'E-Mail-Adresse bereits registriert. Bitte verwenden Sie eine andere.';
        }
    } else {
        // Neuen Benutzer erstellen
        $stmt = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
        $stmt->execute([$username, $email, $password]);

        header('Location: login.php');
        exit;
    }
}
?>
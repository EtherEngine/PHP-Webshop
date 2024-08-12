<?php

// Inkludiere die Datei, die die Datenbankverbindung bereitstellt
require __DIR__ . '/../config/db_connect.php';

// Starte eine neue oder bestehende Session
session_start();

// Überprüfe, ob die Anfrage per POST-Methode gesendet wurde
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Hole den Benutzernamen und das Passwort aus dem POST-Array
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Bereite eine SQL-Anweisung vor, um den Benutzer mit dem angegebenen Benutzernamen in der Datenbank zu suchen
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');

    // Führe die vorbereitete Anweisung mit dem angegebenen Benutzernamen aus
    $stmt->execute([$username]);

    // Hole das Ergebnis der Abfrage als assoziatives Array
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Überprüfe, ob ein Benutzer gefunden wurde und ob das Passwort korrekt ist
    if ($user && password_verify($password, $user['password'])) {
        // Setze die Session-Variablen für die Benutzer-ID und den Benutzernamen
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Leite den Benutzer auf die Profilseite weiter
        header('Location: user_profile.php');
        exit; // Beende das Skript, um sicherzustellen, dass keine weiteren Codezeilen ausgeführt werden
    } else {
        // Gib eine Fehlermeldung aus, wenn die Anmeldeinformationen ungültig sind
        echo 'Ungültige Anmeldeinformationen';
    }
}
?>
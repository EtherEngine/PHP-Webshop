<?php

// Lese die Konfigurationswerte aus der config.php Datei
$config = require __DIR__ . '/config.php';

try {
    // Erstelle eine neue PDO-Instanz zur Verbindung mit der Datenbank
    $pdo = new PDO(
        'mysql:host=' . $config['database']['host'] . ';dbname=' . $config['database']['dbname'] . ';charset=' . $config['database']['charset'],
        $config['database']['username'],
        $config['database']['password']
    );
    // Setze den Fehlermodus auf Exception, um Fehler einfacher zu handhaben
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Falls die Verbindung fehlschlägt, beende das Skript und zeige die Fehlermeldung
    die('Datenbankverbindung fehlgeschlagen: ' . $e->getMessage());
}

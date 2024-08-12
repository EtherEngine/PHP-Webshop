<?php

// Datenbankverbindung einbinden
require '../config/db_connect.php';

// Überprüfen, ob eine POST-Anfrage mit dem 'query'-Feld gesendet wurde
if (isset($_POST['query'])) {
    // Speichern der Suchanfrage in der Variablen $query
    $query = $_POST['query'];

    // Vorbereiten der SQL-Anweisung für eine Suche in der 'products'-Tabelle
    // Die Abfrage sucht nach Produktenamen, die das Suchwort enthalten und gibt maximal 5 Ergebnisse zurück
    $stmt = $pdo->prepare('SELECT name FROM products WHERE name LIKE ? LIMIT 5');

    // Ausführen der vorbereiteten SQL-Anweisung mit dem Suchbegriff als Parameter
    // Das Suchwort wird dabei mit Platzhaltern (%) umschlossen, um eine Teilzeichenfolgensuche zu ermöglichen
    $stmt->execute(["%$query%"]);

    // Abrufen aller Ergebnisse als assoziatives Array
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Überprüfen, ob Ergebnisse gefunden wurden
    if ($result) {
        // Wenn Ergebnisse vorhanden sind, werden sie in einer Liste angezeigt
        foreach ($result as $row) {
            echo '<li>' . $row['name'] . '</li>';
        }
    } else {
        // Wenn keine Ergebnisse gefunden wurden, wird eine entsprechende Meldung ausgegeben
        echo '<li>Keine Ergebnisse gefunden</li>';
    }
}
?>
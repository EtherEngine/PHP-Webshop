<?php

require '../config/db_connect.php';

if (isset($_POST['query'])) {
    $query = $_POST['query'];
    $stmt = $pdo->prepare('SELECT name FROM products WHERE name LIKE ? LIMIT 5');
    $stmt->execute(["%$query%"]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        foreach ($result as $row) {
            echo '<li>' . $row['name'] . '</li>';
        }
    } else {
        echo '<li>Keine Ergebnisse gefunden</li>';
    }
}
?>
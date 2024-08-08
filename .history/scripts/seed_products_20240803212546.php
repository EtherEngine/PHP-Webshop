<?php

require __DIR__ . '/../config/db_connect.php';

$products = [
    'Produkt 1',
    'Produkt 2',
    'Produkt 3',
    'Produkt 4',
    'Produkt 5',
    'Produkt 6',
    'Produkt 7',
    'Produkt 8',
    'Produkt 9',
    'Produkt 10',
    'Produkt 11',
    'Produkt 12',
    'Produkt 13',
    'Produkt 14',
    'Produkt 15',
    'Produkt 16',
    'Produkt 17',
    'Produkt 18',
    'Produkt 19',
    'Produkt 20',
    'Produkt 21',
    'Produkt 22',
    'Produkt 23',
    'Produkt 24',
    'Produkt 25',
    'Produkt 26',
    'Produkt 27',
    'Produkt 28',
    'Produkt 29',
    'Produkt 30',
    'Produkt 31',
    'Produkt 32',
    'Produkt 33',
    'Produkt 34',
    'Produkt 35',
    'Produkt 36',
    'Produkt 37',
    'Produkt 38',
    'Produkt 39',
    'Produkt 40',
    'Produkt 41',
    'Produkt 42',
    'Produkt 43',
    'Produkt 44',
    'Produkt 45',
    'Produkt 46',
    'Produkt 47',
    'Produkt 48',
    'Produkt 49',
    'Produkt 50',
];

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare('INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)');

    foreach ($products as $index => $name) {
        $description = 'Beschreibung für ' . $name;
        $price = rand(10, 1000);
        $image = 'placeholder.png'; // Beispielbild, das in der assets/images gespeichert wird
        $stmt->execute([$name, $description, $price, $image]);
    }

    $pdo->commit();
    echo "50 Produkte erfolgreich hinzugefügt.";
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Fehler beim Hinzufügen der Produkte: " . $e->getMessage();
}

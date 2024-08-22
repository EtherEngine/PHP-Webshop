<?php

class Database
{
    private $pdo;

    public function __construct($host, $dbname, $username, $password)
    {
        // Korrigierter DSN-String: 'dbname' statt 'webshop'
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

        try {
            // PDO-Konstruktor: DSN, Benutzername und Passwort
            $this->pdo = new PDO($dsn, $username, $password);
            // Setze PDO auf den Fehler-Modus 'Exception', um Fehler leichter zu finden
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Fehlerbehandlung, falls die Verbindung fehlschlägt
            die('Datenbankverbindung fehlgeschlagen: ' . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}

<?php

class Database
{
    private $pdo;

    public function __construct($host, $dbname, $username)
    {
        // DSN-String: 'dbname' gibt den Namen der Datenbank an
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

        try {
            // Verbindung zur Datenbank ohne Passwort
            $this->pdo = new PDO($dsn, $username, '');
            // Setzt den Fehler-Modus auf Exception, um Fehler leichter zu erkennen
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

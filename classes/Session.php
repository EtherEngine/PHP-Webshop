<?php

class Session
{
    // Startet die Session, falls sie noch nicht gestartet wurde
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Prüft, ob der Benutzer eingeloggt ist (d.h., ob 'user_id' in der Session gesetzt ist)
    public static function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    // Holt die Benutzer-ID aus der Session
    public static function getUserId()
    {
        return $_SESSION['user_id'] ?? null;
    }

    // Setzt die Benutzer-ID in der Session
    public static function setUserId($userId)
    {
        $_SESSION['user_id'] = $userId;
    }

    // Löscht die Benutzer-ID und beendet die Session
    public static function logout()
    {
        session_unset(); // Löscht alle Session-Variablen
        session_destroy(); // Beendet die Session
    }

    // Leitet den Benutzer auf die Login-Seite weiter, falls er nicht eingeloggt ist
    public static function redirectToLogin()
    {
        header('Location: login.php');
        exit(); // Beendet das Skript nach der Weiterleitung
    }
}

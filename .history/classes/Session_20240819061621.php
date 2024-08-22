<?php

class Session
{
    public static function start()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    public static function getUserId()
    {
        return $_SESSION['user_id'];
    }

    public static function redirectToLogin()
    {
        header('Location: login.php');
        exit();
    }
}

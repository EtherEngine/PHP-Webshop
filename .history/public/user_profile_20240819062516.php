<?php
// Laden Sie die erforderlichen Dateien und starten Sie die Session
require __DIR__ . '/../config/db_connect.php';
require __DIR__ . '/../classes/Database.php';
require __DIR__ . '/../classes/User.php';
require __DIR__ . '/../classes/Session.php';

Session::start();

if (!Session::isLoggedIn()) {
    Session::redirectToLogin();
}

$database = new Database('localhost', 'dbname', 'richtiger_username', 'richtiges_passwort');
$dbConnection = $database->getConnection();
$user = new User($dbConnection, Session::getUserId());

$profile_image = $user->getProfileImage();

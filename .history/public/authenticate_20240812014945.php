<?php

// Include the file that provides the database connection
require __DIR__ . '/../config/db_connect.php';

// Start a new session or resume an existing one
session_start();

// Check if the request was made using the POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the username and password from the POST array
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare an SQL statement to find the user with the given username in the database
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');

    // Execute the prepared statement with the provided username
    $stmt->execute([$username]);

    // Fetch the result of the query as an associative array
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if a user was found and if the password is correct
    if ($user && password_verify($password, $user['password'])) {
        // Set session variables for the user ID and username
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Redirect the user to the profile page
        header('Location: user_profile.php');
        exit; // Terminate the script to ensure no further code is executed
    } else {
        // Output an error message if the login credentials are invalid
        echo 'Invalid login credentials';
    }
}
?>
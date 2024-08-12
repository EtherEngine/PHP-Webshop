<?php
// Start the session
session_start();

// Include the database connection file
require __DIR__ . '/../config/db_connect.php';

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Retrieve the logged-in user's ID from the session
$user_id = $_SESSION['user_id'];

// Prepare a SQL statement to fetch the user's data from the database
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
// Execute the SQL statement with the user ID
$stmt->execute([$user_id]);
// Fetch the user's data as an associative array
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// List of countries for the dropdown selection
$countries = ["Deutschland", "Österreich", "Schweiz", "Belgien", "Niederlande", "Frankreich", "Italien", "Spanien", "Portugal", "Großbritannien", "Irland", "Dänemark", "Schweden", "Norwegen", "Finnland", "Polen", "Tschechien", "Ungarn", "Griechenland", "Türkei"];

// Set the profile image, defaulting to a placeholder if none exists
$profile_image = $user['profile_image'] ? $user['profile_image'] : 'profil_icon_w.png';

// Check if the form was submitted via POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form inputs, sanitizing them or using existing user data if not provided
    $firstname = isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : $user['firstname'];
    $lastname = isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : $user['lastname'];
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : $user['email'];
    $street = isset($_POST['street']) ? htmlspecialchars($_POST['street']) : $user['street'];
    $housenumber = isset($_POST['housenumber']) ? htmlspecialchars($_POST['housenumber']) : $user['housenumber'];
    $city = isset($_POST['city']) ? htmlspecialchars($_POST['city']) : $user['city'];
    $zipcode = isset($_POST['zipcode']) ? htmlspecialchars($_POST['zipcode']) : $user['zipcode'];
    $country = isset($_POST['country']) ? htmlspecialchars($_POST['country']) : $user['country'];
    $profile_image = $user['profile_image'];

    // If the user wants to delete the profile image
    if (isset($_POST['delete_image']) && $_POST['delete_image'] == 'yes') {
        // Set the profile image to the default placeholder
        $profile_image = 'profil_icon_w.png';
        // Update the user's profile image in the database
        $stmt = $pdo->prepare('UPDATE users SET profile_image = ? WHERE id = ?');
        $stmt->execute([$profile_image, $user_id]);
    }
    // If the user uploads a new profile image
    elseif (!empty($_FILES['profile_image']['name'])) {
        // Define allowed file extensions for the profile image
        $allowed_exts = ['jpg', 'jpeg', 'png'];
        // Get the file extension of the uploaded image
        $file_ext = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));

        // Check if the file extension is allowed
        if (in_array($file_ext, $allowed_exts)) {
            // Generate a unique name for the image and set the image path
            $image_name = time() . '_' . $_FILES['profile_image']['name'];
            $image_path = '../assets/images/images_user/' . $image_name;
            // Move the uploaded file to the designated directory
            move_uploaded_file($_FILES['profile_image']['tmp_name'], $image_path);
            // Update the profile image with the new image name
            $profile_image = $image_name;
        } else {
            // Set an error message if the file format is not supported
            $error_message = 'Format wird nicht unterstützt. Nur .jpg, .jpeg und .png sind erlaubt.';
        }
    }

    // If there is no error, update the user's profile information in the database
    if (!isset($error_message)) {
        // Prepare the SQL statement to update the user's information
        $stmt = $pdo->prepare('UPDATE users SET firstname = ?, lastname = ?, email = ?, street = ?, housenumber = ?, city = ?, zipcode = ?, country = ?, profile_image = ? WHERE id = ?');
        // Execute the SQL statement with the updated user information
        $stmt->execute([$firstname, $lastname, $email, $street, $housenumber, $city, $zipcode, $country, $profile_image, $user_id]);

        // Set a success message and redirect to the user profile page
        $_SESSION['success_message'] = 'Profil erfolgreich aktualisiert.';
        header('Location: user_profile.php');
        exit();
    }
}
?>
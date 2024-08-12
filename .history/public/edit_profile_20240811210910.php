<?php
// Start the session to manage user login state
session_start();

// Include the database connection script
require __DIR__ . '/../config/db_connect.php';

// If the user is not logged in, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Retrieve the logged-in user's ID from the session
$user_id = $_SESSION['user_id'];

// Prepare a SQL statement to fetch the user's data
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
// Execute the SQL query with the user's ID
$stmt->execute([$user_id]);
// Fetch the user's data as an associative array
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Define a list of countries for the dropdown in the profile form
$countries = ["Deutschland", "Österreich", "Schweiz", "Belgien", "Niederlande", "Frankreich", "Italien", "Spanien", "Portugal", "Großbritannien", "Irland", "Dänemark", "Schweden", "Norwegen", "Finnland", "Polen", "Tschechien", "Ungarn", "Griechenland", "Türkei"];

// Set the profile image or use a default if none is available
$profile_image = $user['profile_image'] ? $user['profile_image'] : 'profil_icon_w.png';

// Check if the form has been submitted via POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate the input fields, falling back to existing user data if not provided
    $firstname = isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : $user['firstname'];
    $lastname = isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : $user['lastname'];
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : $user['email'];
    $street = isset($_POST['street']) ? htmlspecialchars($_POST['street']) : $user['street'];
    $housenumber = isset($_POST['housenumber']) ? htmlspecialchars($_POST['housenumber']) : $user['housenumber'];
    $city = isset($_POST['city']) ? htmlspecialchars($_POST['city']) : $user['city'];
    $zipcode = isset($_POST['zipcode']) ? htmlspecialchars($_POST['zipcode']) : $user['zipcode'];
    $country = isset($_POST['country']) ? htmlspecialchars($_POST['country']) : $user['country'];
    $profile_image = $user['profile_image'];

    // Check if the user wants to delete their profile image
    if (isset($_POST['delete_image']) && $_POST['delete_image'] == 'yes') {
        // Set the profile image to the default placeholder
        $profile_image = 'profil_icon_w.png';
        // Update the profile image in the database
        $stmt = $pdo->prepare('UPDATE users SET profile_image = ? WHERE id = ?');
        $stmt->execute([$profile_image, $user_id]);
    }
    // Handle profile image upload if a new image was provided
    elseif (!empty($_FILES['profile_image']['name'])) {
        // Allowed file extensions for profile image uploads
        $allowed_exts = ['jpg', 'jpeg', 'png'];
        // Get the file extension of the uploaded image
        $file_ext = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));

        // Check if the uploaded file extension is allowed
        if (in_array($file_ext, $allowed_exts)) {
            // Generate a unique name for the uploaded image file
            $image_name = time() . '_' . $_FILES['profile_image']['name'];
            $image_path = '../assets/images/images_user/' . $image_name;
            // Move the uploaded file to the designated directory
            move_uploaded_file($_FILES['profile_image']['tmp_name'], $image_path);
            // Set the profile image to the new image name
            $profile_image = $image_name;
        } else {
            // Set an error message if the file extension is not allowed
            $error_message = 'Format wird nicht unterstützt. Nur .jpg, .jpeg und .png sind erlaubt.';
        }
    }

    // If no error message was set, update the user's profile in the database
    if (!isset($error_message)) {
        // Prepare the SQL statement to update the user's information
        $stmt = $pdo->prepare('UPDATE users SET firstname = ?, lastname = ?, email = ?, street = ?, housenumber = ?, city = ?, zipcode = ?, country = ?, profile_image = ? WHERE id = ?');
        // Execute the SQL statement with the updated user information
        $stmt->execute([$firstname, $lastname, $email, $street, $housenumber, $city, $zipcode, $country, $profile_image, $user_id]);

        // Set a success message in the session and redirect to the user profile page
        $_SESSION['success_message'] = 'Profil erfolgreich aktualisiert.';
        header('Location: user_profile.php');
        exit();
    }
}
?>
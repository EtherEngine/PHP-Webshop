<?php
// Start a new session or resume the existing session
session_start();

// Include the database connection script
require __DIR__ . '/../config/db_connect.php';

// Initialize an empty string to store potential error messages
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize the username and password from the form submission
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Input validation
    if (strlen($username) < 3 || strlen($username) > 50) {
        $error_message = 'Der Benutzername muss zwischen 3 und 50 Zeichen lang sein.';
    } elseif (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
        $error_message = 'Der Benutzername darf nur alphanumerische Zeichen enthalten.';
    } else {
        // Prepare an SQL statement to fetch the user details where the username matches the input
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
        // Execute the SQL statement with the provided username
        $stmt->execute([$username]);
        // Fetch the user data as an associative array
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify if the fetched user exists and the password matches the hashed password in the database
        if ($user && password_verify($password, $user['password'])) {
            // If valid, store the user's ID in the session to log them in
            $_SESSION['user_id'] = $user['id'];
            // Redirect the user to the index page after successful login
            header('Location: index.php');
            exit;
        } else {
            // If login fails, set an error message
            $error_message = 'Ungültiger Benutzername oder Passwort.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Include custom CSS for the page -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- Include Bootstrap CSS for styling -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom styles for the buttons */
        .btn-primary,
        .btn-secondary {
            background: linear-gradient(to bottom, #333, #666);
            border: none;
            color: white;
        }

        .btn-primary:hover,
        .btn-secondary:hover {
            background: linear-gradient(to bottom, #111, #444);
        }

        .btn-primary {
            margin-right: 10px;
        }

        .btn-secondary {
            margin-left: 10px;
        }

        /* Styling for the logo container */
        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 10px;
        }

        .logo-container img {
            height: 40px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2>Login</h2>
                <!-- Display an error message if the login fails -->
                <?php if ($error_message): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php endif; ?>
                <!-- Login form, submits to the same page (login.php) -->
                <form action="login.php" method="POST">
                    <div class="form-group">
                        <label for="username">Benutzername</label>
                        <!-- Input field for the username -->
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Passwort</label>
                        <!-- Input field for the password -->
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <!-- Submit button for the login form -->
                        <button type="submit" class="btn btn-primary">Login</button>
                        <div class="logo-container">
                            <!-- Logo linking to the index page -->
                            <a href="index.php">
                                <img src="../assets/images/Gruppenlogo_rund1.png" alt="Gruppenlogo">
                            </a>
                        </div>
                        <!-- Button linking to the registration page -->
                        <a href="register.php" class="btn btn-secondary">Registrieren</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Include necessary JavaScript libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
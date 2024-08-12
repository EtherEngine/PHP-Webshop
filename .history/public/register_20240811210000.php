<?php
// Start the session to store session variables
session_start();

// Include the database connection file
require __DIR__ . '/../config/db_connect.php';
// Include a file with utility functions for the view
require __DIR__ . '/../src/View/functions.php';

// Initialize variables to store error and welcome messages, and a flag for redirection
$error_message = '';
$welcome_message = '';
$redirect = false;

// Check if the request method is POST (i.e., the form was submitted)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify the CSRF token to protect against CSRF attacks
    if (!verify_csrf_token($_POST['csrf_token'])) {
        die('Ungültiges CSRF-Token'); // Stop execution if the CSRF token is invalid
    }

    // Sanitize and validate the form inputs
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the passwords match
    if ($password !== $confirm_password) {
        $error_message = 'Die Passwörter stimmen nicht überein.'; // Set error message if passwords do not match
    } else {
        // Prepare a SQL statement to check if the username or email already exists in the database
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? OR email = ?');
        $stmt->execute([$username, $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // If a user with the same username or email exists, set an error message
        if ($user) {
            $error_message = 'Der Benutzername oder die E-Mail-Adresse ist bereits vergeben.';
        } else {
            // Hash the password for secure storage in the database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            // Set a default profile image
            $default_profile_image = 'profil_icon_w.png';

            // Prepare a SQL statement to insert the new user into the database
            $stmt = $pdo->prepare('INSERT INTO users (username, email, password, profile_image) VALUES (?, ?, ?, ?)');
            $stmt->execute([$username, $email, $hashed_password, $default_profile_image]);

            // Store the new user's ID in the session and set a welcome message
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $welcome_message = 'Willkommen, ' . htmlspecialchars($username) . '! Du wirst in 5 Sekunden weitergeleitet.';
            $redirect = true; // Set the redirection flag to true
        }
    }
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrieren</title>
    <!-- Link to external CSS and Bootstrap for styling -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom styling for buttons, logo, and animations */
        .btn-primary {
            background: linear-gradient(to bottom, #333, #666);
            border: none;
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(to bottom, #111, #444);
        }

        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 10px;
        }

        .logo-container img {
            height: 40px;
        }

        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .rainbow-text {
            font-weight: bold;
            font-size: 2em;
            background-image: linear-gradient(to right, red, orange, yellow, green, blue, indigo, violet);
            -webkit-background-clip: text;
            color: transparent;
        }

        @keyframes countdown {
            0% {
                content: "5";
            }

            20% {
                content: "4";
            }

            40% {
                content: "3";
            }

            60% {
                content: "2";
            }

            80% {
                content: "1";
            }

            100% {
                content: "0";
            }
        }

        .countdown::before {
            content: "5";
            animation: countdown 5s linear infinite;
            font-size: 3em;
            color: black;
        }
    </style>
</head>

<body>
    <?php
    // Include the header and navigation templates
    include '../src/View/templates/header.php';
    include '../src/View/templates/navigation.php';
    ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2>Registrieren</h2>
                <!-- Display an error message if one exists -->
                <?php if ($error_message): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
                <?php endif; ?>
                <!-- Display a welcome message and initiate a redirection if the registration is successful -->
                <?php if ($welcome_message): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($welcome_message); ?></div>
                    <div class="logo-container">
                        <div class="rainbow-text countdown"></div>
                    </div>
                    <script>
                        // Redirect to the index page after 5 seconds
                        setTimeout(function () {
                            window.location.href = 'index.php';
                        }, 5000);
                    </script>
                    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.4.0/dist/confetti.browser.min.js"></script>
                    <script>
                        // Display a confetti animation during the countdown
                        var end = Date.now() + (5 * 1000);

                        (function frame() {
                            confetti({
                                particleCount: 7,
                                angle: 60,
                                spread: 55,
                                origin: { x: 0 },
                                colors: ['#ff0000', '#ff8000', '#ffff00', '#80ff00', '#00ff80', '#00ffff', '#0080ff', '#8000ff', '#ff00ff']
                            });
                            confetti({
                                particleCount: 7,
                                angle: 120,
                                spread: 55,
                                origin: { x: 1 },
                                colors: ['#ff0000', '#ff8000', '#ffff00', '#80ff00', '#00ff80', '#00ffff', '#0080ff', '#8000ff', '#ff00ff']
                            });

                            if (Date.now() < end) {
                                requestAnimationFrame(frame);
                            }
                        }());
                    </script>
                <?php endif; ?>
                <!-- Display the registration form unless a redirection is in progress -->
                <form action="register.php" method="POST" <?php echo $redirect ? 'style="display:none;"' : ''; ?>>
                    <!-- Include a hidden field with the CSRF token -->
                    <input type="hidden" name="csrf_token"
                        value="<?php echo htmlspecialchars(generate_csrf_token()); ?>">
                    <div class="form-group">
                        <label for="username">Benutzername</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="email">E-Mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Passwort</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Passwort bestätigen</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                            required>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <button type="submit" class="btn btn-primary">Registrieren</button>
                        <div class="logo-container">
                            <a href="index.php">
                                <img src="../assets/images/Gruppenlogo_rund1.png" alt="Gruppenlogo">
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Include external JavaScript libraries for Bootstrap and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
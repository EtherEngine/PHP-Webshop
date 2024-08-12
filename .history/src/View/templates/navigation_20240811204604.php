<!-- Start of the navigation bar (navbar) section -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <!-- Navbar brand logo linking to the homepage -->
        <a class="navbar-brand" href="index.php">
            <!-- Image for the brand logo with specific height and alternative text -->
            <img src="../assets/images/Gruppenlogo_rund.png" alt="Webshop Logo" style="height: 40px;">
        </a>

        <!-- Button for toggling the navigation menu on smaller screens (e.g., mobile devices) -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible section of the navbar containing navigation items -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <!-- PHP block to check if a user is logged in using the session variable 'user_id' -->
                <?php if (isset($_SESSION['user_id'])): 
                    // Prepare a SQL statement to get the user's profile image from the database
                    $stmt = $pdo->prepare('SELECT profile_image FROM users WHERE id = ?');
                    // Execute the SQL query using the user's ID from the session
                    $stmt->execute([$_SESSION['user_id']]);
                    // Fetch the result of the query as an associative array
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    // Determine which profile image to use: the one from the database or a default image
                    $profile_image = $user['profile_image'] ? $user['profile_image'] : 'profil_icon_w.png';
                ?>

                    <!-- Navigation item for the shopping cart -->
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">
                            <!-- Icon for the shopping cart with a conditional 'glow' effect if the cart is not empty -->
                            <i class="fas fa-shopping-cart <?php echo !empty($_SESSION['cart']) ? 'glow' : ''; ?>"></i> 
                            <!-- Label for the cart, visible only on small screens (mobile) -->
                            <span class="d-lg-none">Warenkorb</span>
                        </a>
                    </li>

                    <!-- Navigation item with a dropdown menu for user options -->
                    <li class="nav-item dropdown">
                        <!-- Profile image inside the dropdown toggle, with rounded corners -->
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="../assets/images/images_user/<?php echo $profile_image; ?>" alt="Profil" style="height: 24px; border-radius: 50%;">
                        </a>

                        <!-- Dropdown menu containing various user-related links -->
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="user_profile.php">Profil ansehen</a>
                            <a class="dropdown-item" href="edit_profile.php">Profil bearbeiten</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="impressum.php">Impressum</a>
                            <a class="dropdown-item" href="contact.php">Kontakt</a>
                            <a class="dropdown-item" href="agb.php">AGB</a>
                            <a class="dropdown-item" href="about.php">Über uns</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout.php">Logout</a>
                        </div>
                    </li>
                <?php else: ?>
                    <!-- If the user is not logged in, show the Login and Register links -->
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Registrieren</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Start of the style section -->
<style>
    /* Animation for the 'glow' effect on the shopping cart icon */
    .glow {
        animation: glow 1s infinite alternate;
    }

    /* Keyframes for the 'glow' animation, alternating between two green shades */
    @keyframes glow {
        from {
            text-shadow: 0 0 10px #28a745, 0 0 20px #28a745, 0 0 30px #28a745, 0 0 40px #28a745, 0 0 50px #28a745, 0 0 60px #28a745, 0 0 70px #28a745;
        }
        to {
            text-shadow: 0 0 20px #218838, 0 0 30px #218838, 0 0 40px #218838, 0 0 50px #218838, 0 0 60px #218838, 0 0 70px #218838;
        }
    }

    /* Ensures profile images in the navbar have a consistent size and are circular */
    .navbar-nav .nav-item img {
        height: 24px;
        border-radius: 50%;
    }

    /* Ensures navbar links are white and do not change color unless hovered over */
    .navbar-nav .nav-link {
        color: #fff !important;
    }

    /* Changes the color of navbar links when hovered over */
    .navbar-nav .nav-link:hover {
        color: #ddd !important;
    }

    /* Removes the border from the navbar toggler button */
    .navbar-toggler {
        border: none;
    }

    /* Removes focus and shadow effects on the navbar toggler when clicked */
    .navbar-toggler:focus {
        outline: none;
        box-shadow: none;
    }

    /* Customizes the navbar toggler icon (three horizontal lines) */
    .navbar-dark .navbar-toggler-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba%28255, 255, 255, 1%29' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
    }

    /* Sets padding inside the navbar */
    .navbar {
        padding: 1rem 1rem;
    }

    /* Adds a hover effect to the brand logo, making it slightly larger */
    .navbar-brand img {
        transition: transform 0.3s;
    }

    .navbar-brand img:hover {
        transform: scale(1.1);
    }

    /* Adds margin to the left of each navbar item */
    .nav-item {
        margin-left: 15px;
    }

    /* Ensures the nav-link elements align with their content */
    .nav-item .nav-link {
        display: flex;
        align-items: center;
    }

    /* Adds margin to the right of images inside nav-link elements */
    .nav-item .nav-link img {
        margin-right: 5px;
    }

    /* Aligns the dropdown menu to the right */
    .dropdown-menu-right {
        right: 0;
        left: auto;
    }

    /* Sets the color of dropdown items and changes the hover background color */
    .dropdown-item {
        color: #333;
    }

    .dropdown-item:hover {
        color: #fff;
        background-color: #333;
    }

    /* Removes extra spacing around the dropdown divider */
    .dropdown-divider {
        margin: 0;
    }
</style>

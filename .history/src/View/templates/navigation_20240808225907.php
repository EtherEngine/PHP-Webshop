<?php
// Prüfen, ob die Session bereits gestartet wurde
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Anpassen des Pfades zur Datenbankverbindung
require __DIR__ . '/../../../config/db_connect.php';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="../assets/images/Gruppenlogo_rund.png" alt="Webshop Logo" style="height: 40px;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="about.php">Über uns</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Kontakt</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="impressum.php">Impressum</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="agb.php">AGB</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php if (isset($_SESSION['user_id'])): 
                    $stmt = $pdo->prepare('SELECT profile_image FROM users WHERE id = ?');
                    $stmt->execute([$_SESSION['user_id']]);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    $profile_image = !empty($user['profile_image']) ? $user['profile_image'] : 'profil_icon_w.png';
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">
                            <i class="fas fa-shopping-cart <?php echo !empty($_SESSION['cart']) ? 'glow' : ''; ?>"></i> <span class="d-lg-none">Warenkorb</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="../assets/images/images_user/<?php echo $profile_image; ?>" alt="Profil" style="height: 24px; border-radius: 50%;">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="user_profile.php">Profil ansehen</a>
                            <a class="dropdown-item" href="edit_profile.php">Profil bearbeiten</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout.php">Logout</a>
                        </div>
                    </li>
                <?php else: ?>
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

<style>
    .glow {
        animation: glow 1s infinite alternate;
    }

    @keyframes glow {
        from {
            text-shadow: 0 0 10px #28a745, 0 0 20px #28a745, 0 0 30px #28a745, 0 0 40px #28a745, 0 0 50px #28a745, 0 0 60px #28a745, 0 0 70px #28a745;
        }
        to {
            text-shadow: 0 0 20px #218838, 0 0 30px #218838, 0 0 40px #218838, 0 0 50px #218838, 0 0 60px #218838, 0 0 70px #218838, 0 0 80px #218838;
        }
    }

    .navbar-nav .nav-item img {
        height: 24px;
    }

    .navbar-nav .nav-link {
        color: #fff !important;
    }

    .navbar-nav .nav-link:hover {
        color: #ddd !important;
    }

    .navbar-toggler {
        border: none;
    }

    .navbar-toggler:focus {
        outline: none;
        box-shadow: none;
    }

    .navbar-dark .navbar-toggler-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba%28255, 255, 255, 1%29' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
    }

    .navbar {
        padding: 1rem 1rem;
    }

    .navbar-brand img {
        transition: transform 0.3s;
    }

    .navbar-brand img:hover {
        transform: scale(1.1);
    }

    .nav-item {
        margin-left: 15px;
    }

    .nav-item .nav-link {
        display: flex;
        align-items: center;
    }

    .nav-item .nav-link img {
        margin-right: 5px;
        border-radius: 50%;
    }

    .dropdown-menu-right {
        right: 0;
        left: auto;
    }

    .dropdown-item {
        color: #333;
    }

    .dropdown-item:hover {
        color: #fff;
        background-color: #333;
    }

    .dropdown-divider {
        margin: 0;
    }
</style>

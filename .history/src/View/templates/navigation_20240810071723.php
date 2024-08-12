<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../config/db_connect.php';
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
            <ul class="navbar-nav ml-auto">
                <?php if (isset($_SESSION['user_id'])): 
                    $stmt = $pdo->prepare('SELECT profile_image FROM users WHERE id = ?');
                    $stmt->execute([$_SESSION['user_id']]);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    $profile_image = $user['profile_image'] ? $user['profile_image'] : 'profil_icon_w.png';
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
                            <a class="dropdown-item" href="impressum.php">Impressum</a>
                            <a class="dropdown-item" href="contact.php">Kontakt</a>
                            <a class="dropdown-item" href="agb.php">AGB</a>
                            <a class="dropdown-item" href="about.php">Über uns</a>
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


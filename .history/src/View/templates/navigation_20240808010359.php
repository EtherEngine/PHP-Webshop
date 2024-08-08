<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="../assets/images/Gruppenlogo_rund.png" alt="Webshop Logo" style="height: 40px;">
        </a>
        <form class="form-inline ml-3" action="index.php" method="GET">
            <div class="input-group">
                <input class="form-control" type="search" placeholder="Suchen" aria-label="Suchen" name="query">
                <div class="input-group-append">
                    <button class="btn btn-outline-light" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="products.php">Produkte</a>
                </li>
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
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="user_profile.php">
                            <img src="../assets/images/profil_icon_w.png" alt="Profil" style="height: 24px;">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">
                            <i class="fas fa-shopping-cart <?php echo !empty($_SESSION['cart']) ? 'glow' : ''; ?>"></i> Warenkorb
                        </a>
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
</style>

<!-- Header.php -->
<header class="main-header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-brain"></i> Visionary Minds
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Über uns</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Kontakt</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="hero-section d-flex align-items-center justify-content-center position-relative">
        <div class="color-splashes"></div>
        <div class="parallax-bg"></div>
        <div class="container text-center">
            <h1 class="display-3 text-white animated-letters">Visionary Minds Webshop</h1>
            <pre class="ascii-art text-white mt-3">
  _    _      _                              _          __  __ _           _     
 | |  | |    | |                            | |        |  \/  (_)         | |    
 | |  | | ___| | ___ ___  _ __ ___   ___    | |_ ___   | \  / |_ _ __   __| |___ 
 | |/\| |/ _ \ |/ __/ _ \| '_ ` _ \ / _ \   | __/ _ \  | |\/| | | '_ \ / _` / __|
 \  /\  /  __/ | (_| (_) | | | | | |  __/   | || (_) | | |  | | | | | | (_| \__ \
  \/  \/ \___|_|\___\___/|_| |_| |_|\___|    \__\___/  |_|  |_|_|_| |_|\__,_|___/

   ____       _                     _   _                     _                       
  / __ \     (_)                   | | | |                   | |                      
 | |  | |_ __ _ _ __  _ __   __ _  | |_| |__   ___  _ __   __| | ___ _ __ ___  _ __   
 | |  | | '__| | '_ \| '_ \ / _` | | __| '_ \ / _ \| '_ \ / _` |/ _ \ '_ ` _ \| '_ \  
 | |__| | |  | | |_) | | | | (_| | | |_| | | | (_) | | | | (_| |  __/ | | | | | |_) | 
  \____/|_|  |_| .__/|_| |_|\__,_|  \__|_| |_|\___/|_| |_|\__,_|\___|_| |_| |_| .__/  
               | |                                                            | |     
               |_|                                                            |_|     
            </pre>
            <p class="lead text-white-50 animated fadeInUp delay-1s">Ihr Experte für KI-Innovationen – Entdecken Sie smarte Lösungen für alle Lebensbereiche!</p>
            <a href="#shop-now" class="btn btn-primary btn-lg mt-4 animated fadeInUp delay-2s">
                <i class="fas fa-shopping-cart"></i> Jetzt Entdecken
            </a>
        </div>
    </div>
</header>

<!-- Styles and Libraries -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&family=Poppins:wght@600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        background-color: #1a1a1a;
        color: #f5f5f5;
    }

    .navbar {
        padding: 1rem 0;
        background: #212529;
    }

    .navbar-brand {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 1.5rem;
        letter-spacing: 1px;
    }

    .navbar-brand i {
        margin-right: 10px;
        color: #007bff;
    }

    .navbar-nav .nav-link {
        font-size: 1rem;
        font-weight: 400;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: color 0.3s;
    }

    .navbar-nav .nav-link:hover {
        color: #007bff;
    }

    .hero-section {
        height: 100vh;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: linear-gradient(135deg, #232526, #414345);
        color: #f5f5f5;
    }

    .parallax-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('https://source.unsplash.com/1600x900/?technology,artificial-intelligence') center center / cover no-repeat;
        z-index: 0;
        opacity: 0.1;
        transform: translateZ(0);
        will-change: transform;
        animation: parallaxScroll 30s linear infinite;
    }

    @keyframes parallaxScroll {
        0% { transform: translateY(0); }
        50% { transform: translateY(-20%); }
        100% { transform: translateY(0); }
    }

    .color-splashes {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        background-image: url('https://www.transparenttextures.com/patterns/asfalt-dark.png'), 
                          radial-gradient(circle at 30% 30%, rgba(255, 0, 150, 0.5), transparent),
                          radial-gradient(circle at 70% 70%, rgba(0, 150, 255, 0.5), transparent),
                          radial-gradient(circle at 50% 50%, rgba(255, 255, 0, 0.5), transparent);
        background-blend-mode: screen;
        opacity: 0.7;
    }

    .hero-section .container {
        position: relative;
        z-index: 2;
    }

    .animated-letters {
        font-family: 'Poppins', sans-serif;
        font-size: 4rem;
        font-weight: 600;
        text-shadow: 2px 4px 6px rgba(0, 0, 0, 0.6);
        letter-spacing: 2px;
        overflow: hidden;
        display: inline-block;
        color: #f5f5f5;
    }

    .animated-letters span {
        display: inline-block;
        opacity: 0;
        animation: fadeInLetter 0.1s forwards;
    }

    @keyframes fadeInLetter {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .ascii-art {
        font-family: 'Courier New', Courier, monospace;
        font-size: 0.8rem;
        line-height: 1.2;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        opacity: 0.8;
        margin-top: 20px;
    }

    .hero-section p {
        font-size: 1.5rem;
        margin-top: 15px;
        text-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
        color: #dcdcdc;
    }

    .hero-section .btn {
        font-size: 1.25rem;
        padding: 10px 30px;
        text-transform: uppercase;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
        background-color: #007bff;
        border: none;
    }

    .hero-section .btn:hover {
        background-color: #0056b3;
        color: #fff;
        box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.4);
        transform: translateY(-3px);
    }

    @media (max-width: 768px) {
        .animated-letters {
            font-size: 3rem;
        }

        .hero-section p {
            font-size: 1.2rem;
        }

        .hero-section .btn {
            font-size: 1rem;
            padding: 8px 20px;
        }

        .ascii-art {
            font-size: 0.6rem;
        }
    }
</style>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const text = document.querySelector('.animated-letters');
        text.innerHTML = text.textContent.replace(/./g, "<span>$&</span>");

        const letters = document.querySelectorAll('.animated-letters span');
        letters.forEach((letter, index) => {
            letter.style.animationDelay = `${index * 0.1}s`;
        });
    });
</script>


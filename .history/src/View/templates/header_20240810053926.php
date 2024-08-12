<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visionary Minds Webshop</title>

    <!-- Importing Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- AOS (Animate on Scroll) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- GLightbox -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <!-- Particle.js -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

    <style>
        header.main-header, header.main-header * {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            color: #f0f0f0;
            background-color: #1c1c1c;
            overflow-x: hidden;
        }

        header.main-header {
            position: relative;
            background: linear-gradient(135deg, #333, #444);
            padding: 100px 0;
            overflow: hidden;
            text-align: center;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        /* Particle.js Canvas */
        header.main-header #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
        }

        header.main-header h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            animation: fadeInDown 1s ease-in-out;
        }

        header.main-header p {
            font-size: 1.5rem;
            font-weight: 300;
            margin-bottom: 40px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7);
            animation: fadeInUp 1s ease-in-out;
            max-width: 600px;
            text-align: center;
        }

        /* Mandala SVG */
        header.main-header .mandala {
            position: absolute;
            bottom: -50px;
            left: 50%;
            transform: translateX(-50%);
            width: 150px;
            height: 150px;
            z-index: 1;
            opacity: 0.2;
            filter: blur(10px);
            animation: pulse 4s infinite;
        }

        /* Glass effect */
        header.main-header .glass {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            padding: 20px;
            margin-top: 30px;
            display: inline-block;
            animation: bounceIn 1.5s;
        }

        @keyframes pulse {
            0% { transform: scale(1) translateX(-50%); }
            50% { transform: scale(1.1) translateX(-50%); }
            100% { transform: scale(1) translateX(-50%); }
        }

        @media (max-width: 768px) {
            header.main-header h1 {
                font-size: 2.5rem;
            }

            header.main-header p {
                font-size: 1.2rem;
            }

            header.main-header .mandala {
                width: 100px;
                height: 100px;
            }
        }
    </style>
</head>
<body>

<header class="main-header" data-aos="fade-in">
    <div id="particles-js"></div>
    <h1 class="display-4">Visionary Minds Webshop</h1>
    <p class="lead glass">Ihr Experte für KI-Innovationen – Entdecken Sie smarte Lösungen für alle Lebensbereiche!</p>
    <svg class="mandala" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M12 2l1.176 3.618h3.799l-2.974 2.168 1.176 3.618L12 12.236l-2.976 2.168 1.176-3.618-2.974-2.168h3.798z"></path>
    </svg>
</header>

<!-- Scroll Reveal Script -->
<script src="https://cdn.jsdelivr.net/scrollreveal.js/4.0.0/scrollreveal.min.js"></script>
<!-- GSAP -->
<script src="https://cdn.jsdelivr.net/gsap/3.10.4/gsap.min.js"></script>
<!-- AOS Script -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<!-- GLightbox Script -->
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

<script>
    // Initialize AOS
    AOS.init();

    // Particle.js configuration
    particlesJS("particles-js", {
        "particles": {
            "number": {
                "value": 80,
                "density": {
                    "enable": true,
                    "value_area": 800
                }
            },
            "color": {
                "value": ["#ffffff", "#aaa", "#555"]
            },
            "shape": {
                "type": "circle",
                "stroke": {
                    "width": 0,
                    "color": "#000000"
                }
            },
            "opacity": {
                "value": 0.5,
                "random": true,
                "anim": {
                    "enable": false,
                    "speed": 1,
                    "opacity_min": 0.1,
                    "sync": false
                }
            },
            "size": {
                "value": 3,
                "random": true,
                "anim": {
                    "enable": false,
                    "speed": 40,
                    "size_min": 0.1,
                    "sync": false
                }
            },
            "line_linked": {
                "enable": true,
                "distance": 150,
                "color": "#ffffff",
                "opacity": 0.4,
                "width": 1
            },
            "move": {
                "enable": true,
                "speed": 2,
                "direction": "none",
                "random": false,
                "straight": false,
                "out_mode": "out",
                "attract": {
                    "enable": false,
                    "rotateX": 600,
                    "rotateY": 1200
                }
            }
        }
    });

    // Initialize ScrollReveal
    ScrollReveal().reveal('header.main-header h1', {
        origin: 'top',
        distance: '50px',
        duration: 1000,
        delay: 200
    });

    ScrollReveal().reveal('header.main-header p', {
        origin: 'bottom',
        distance: '50px',
        duration: 1000,
        delay: 400
    });

    // Initialize GLightbox
    const lightbox = GLightbox();
</script>

</body>
</html>



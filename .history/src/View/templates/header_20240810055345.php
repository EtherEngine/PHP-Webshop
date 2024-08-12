<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visionary Minds Webshop</title>

    <!-- Importing Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Particle.js -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Roboto', sans-serif;
            background-color: #1c1c1c;
            color: #f0f0f0;
            overflow: hidden;
        }

        header.main-header {
            position: relative;
            height: 100vh;
            background: radial-gradient(circle, rgba(34,34,34,1) 0%, rgba(0,0,0,1) 100%);
            background-image: url('https://www.transparenttextures.com/patterns/cubes.png'); /* Optional background texture */
            text-align: center;
            overflow: hidden;
        }

        /* Particle.js Canvas */
        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
        }

        .content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.9);
        }

        .content h1 {
            font-size: 4rem;
            font-weight: 700;
            background: linear-gradient(135deg, #e0e0e0, #5a5a5a);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientAnimation 15s ease infinite;
        }

        .content p {
            font-size: 1.5rem;
            font-weight: 300;
            background: linear-gradient(135deg, #e0e0e0, #5a5a5a);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientAnimation 15s ease infinite;
        }

        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
    </style>
</head>
<body>

<header class="main-header">
    <div id="particles-js"></div>
    <div class="content">
        <h1 class="display-4">Visionary Minds Webshop</h1>
        <p class="lead">Ihr Experte für KI-Innovationen – Entdecken Sie smarte Lösungen für alle Lebensbereiche!</p>
    </div>
</header>

<script>
    // Particle.js configuration
    particlesJS("particles-js", {
        "particles": {
            "number": {
                "value": 100,
                "density": {
                    "enable": true,
                    "value_area": 800
                }
            },
            "color": {
                "value": ["#f0f0f0", "#aaaaaa", "#555555"]
            },
            "shape": {
                "type": "circle",
                "stroke": {
                    "width": 0,
                    "color": "#000000"
                }
            },
            "opacity": {
                "value": 0.6,
                "random": true,
                "anim": {
                    "enable": false,
                    "speed": 1,
                    "opacity_min": 0.1,
                    "sync": false
                }
            },
            "size": {
                "value": 4,
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
                "color": "#f0f0f0",
                "opacity": 0.4,
                "width": 1
            },
            "move": {
                "enable": true,
                "speed": 3,
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
</script>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>







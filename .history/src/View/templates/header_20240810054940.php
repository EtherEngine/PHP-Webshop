<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visionary Minds Webshop</title>

    <!-- Importing Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
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
            height: 100%;
            background: linear-gradient(135deg, #333, #444);
            text-align: center;
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
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }

        .content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .content p {
            font-size: 1.5rem;
            font-weight: 300;
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
</script>

</body>
</html>







<!-- header.php -->
<header class="main-header">
    <div id="particles-js"></div>
    <div class="container text-center header-text">
        <h1 class="display-4">Visionary Minds Webshop</h1>
        <p class="lead">Ihr Experte für KI-Innovationen – Entdecken Sie smarte Lösungen für alle Lebensbereiche!</p>
    </div>
</header>

<!-- Particle.js Script -->
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
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
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "repulse"
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    }
                },
                "modes": {
                    "repulse": {
                        "distance": 100,
                        "duration": 0.4
                    },
                    "push": {
                        "particles_nb": 4
                    }
                }
            }
        });
    });
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap');

    .main-header {
        position: relative;
        background: linear-gradient(to bottom, #343a40, #444);
        color: #f0f0f0;
        padding: 40px 0;
        overflow: hidden; /* Verhindert Überlauf */
    }

    .main-header .container {
        height: 130px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 1; /* Stellt sicher, dass der Text über den Partikeln liegt */
    }

    .main-header h1 {
        font-family: 'Roboto', sans-serif;
        font-size: 3.5rem;
        margin-bottom: 10px;
        text-shadow: 2px 2px 4px #000;
    }

    .main-header p {
        font-family: 'Roboto', sans-serif;
        font-size: 1.5rem;
        font-weight: 300;
        text-shadow: 1px 1px 3px #000;
    }

    /* Media Query to hide text at specific screen width */
    @media (max-width: 768px) {
        .header-text {
            display: none;
        }
    }

    /* Particle.js Canvas */
    #particles-js {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 0; /* Hintergrundebene */
    }
</style>










<!-- header.php -->
<header class="main-header">
    <!-- Container for the Particle.js background animation -->
    <div id="particles-js"></div>
    
    <!-- Central container for the header content (title and subtitle) -->
    <div class="container text-center">
        <!-- Main title of the website, styled as a large, unselectable heading -->
        <h1 class="display-4 unselectable">Visionary Minds Webshop</h1>
        
        <!-- Subtitle providing a brief description, also unselectable -->
        <p class="lead unselectable">Ihr Experte für KI-Innovationen – Entdecken Sie smarte Lösungen für alle Lebensbereiche!</p>
    </div>
</header>

<!-- Particle.js Script -->
<!-- Importing the Particle.js library from a CDN -->
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script>
    // Execute this function when the DOM is fully loaded
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize Particle.js on the element with id 'particles-js'
        particlesJS("particles-js", {
            "particles": {
                "number": {
                    "value": 100, // Number of particles to be generated
                    "density": {
                        "enable": true, // Enable particle density control
                        "value_area": 800 // Area for particle density calculation
                    }
                },
                "color": {
                    "value": ["#f0f0f0", "#aaaaaa", "#555555"] // Colors for the particles
                },
                "shape": {
                    "type": "circle", // Shape of the particles
                    "stroke": {
                        "width": 0, // No stroke around particles
                        "color": "#000000" // Stroke color (not used due to zero width)
                    }
                },
                "opacity": {
                    "value": 0.6, // Base opacity of particles
                    "random": true, // Randomize the opacity of each particle
                    "anim": {
                        "enable": false, // Disable opacity animation
                        "speed": 1,
                        "opacity_min": 0.1,
                        "sync": false
                    }
                },
                "size": {
                    "value": 4, // Base size of particles
                    "random": true, // Randomize the size of each particle
                    "anim": {
                        "enable": false, // Disable size animation
                        "speed": 40,
                        "size_min": 0.1,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true, // Enable linking particles with lines
                    "distance": 150, // Distance between particles for linking
                    "color": "#f0f0f0", // Color of the linking lines
                    "opacity": 0.4, // Opacity of the linking lines
                    "width": 1 // Width of the linking lines
                },
                "move": {
                    "enable": true, // Enable movement of particles
                    "speed": 3, // Speed of particle movement
                    "direction": "none", // Random direction for particle movement
                    "random": false, 
                    "straight": false, // Particles do not move in a straight line
                    "out_mode": "out", // Particles move out of the canvas bounds and disappear
                    "attract": {
                        "enable": false, // Disable attraction between particles
                        "rotateX": 600,
                        "rotateY": 1200
                    }
                }
            }
        });
    });
</script>

<style>
    /* Importing the Roboto font from Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap');

    /* Styling for the main header */
    .main-header {
        position: relative; /* Allows positioning of child elements */
        background: linear-gradient(to bottom, #343a40, #444); /* Background gradient from dark gray to lighter gray */
        color: #f0f0f0; /* Text color in the header */
        padding: 40px 0; /* Padding at the top and bottom */
        overflow: hidden; /* Ensures the content does not overflow the header */
    }

    /* Container inside the main header, centered content */
    .main-header .container {
        height: 130px; /* Fixed height of the container */
        display: flex; /* Flexbox for layout */
        flex-direction: column; /* Stack children vertically */
        align-items: center; /* Center children horizontally */
        justify-content: center; /* Center children vertically */
        position: relative; /* Allows z-index manipulation */
        z-index: 1; /* Ensures content is above the particles background */
    }

    /* Styling for the main title (h1) */
    .main-header h1 {
        font-family: 'Roboto', sans-serif; /* Roboto font for the title */
        font-size: 3.5rem; /* Large font size */
        margin-bottom: 10px; /* Space below the title */
        text-shadow: 2px 2px 4px #000; /* Slight shadow effect for better readability */
    }

    /* Styling for the subtitle (p) */
    .main-header p {
        font-family: 'Roboto', sans-serif; /* Roboto font for the subtitle */
        font-size: 1.5rem; /* Slightly smaller font size */
        font-weight: 300; /* Light font weight */
        text-shadow: 1px 1px 3px #000; /* Subtle shadow effect */
    }

    /* Preventing text selection for the title and subtitle */
    .unselectable {
        user-select: none; /* Standard text selection prevention */
        -webkit-user-select: none; /* For WebKit-based browsers */
        -moz-user-select: none; /* For Firefox */
        -ms-user-select: none; /* For Internet Explorer/Edge */
    }

    /* Styling for the Particle.js canvas */
    #particles-js {
        position: absolute; /* Positioning the canvas absolutely inside the header */
        width: 100%; /* Full width of the header */
        height: 100%; /* Full height of the header */
        top: 0; /* Aligns the top of the canvas with the top of the header */
        left: 0; /* Aligns the left of the canvas with the left of the header */
        z-index: 0; /* Ensures the particles are behind the header content */
    }
</style>

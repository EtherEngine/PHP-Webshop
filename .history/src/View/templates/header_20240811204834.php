<!-- Start of the header section -->
<header class="main-header">
    <!-- Div element to hold the Particle.js animation background -->
    <div id="particles-js"></div>

    <!-- Container for the header content, centered text -->
    <div class="container text-center">
        <!-- Main heading of the webpage with a large font size -->
        <h1 class="display-4 unselectable">Visionary Minds Webshop</h1>
        <!-- Subheading or tagline of the webpage with a smaller font size -->
        <p class="lead unselectable">Ihr Experte für KI-Innovationen – Entdecken Sie smarte Lösungen für alle Lebensbereiche!</p>
    </div>
</header>

<!-- Linking to the Particle.js library from a CDN -->
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

<!-- JavaScript to initialize and configure the Particle.js animation -->
<script>
    // Event listener to ensure the DOM is fully loaded before running the script
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize Particle.js on the 'particles-js' div with custom settings
        particlesJS("particles-js", {
            "particles": {
                "number": {
                    "value": 100,  // Number of particles
                    "density": {
                        "enable": true,  // Enable density-based distribution
                        "value_area": 800  // Area over which particles are distributed
                    }
                },
                "color": {
                    "value": ["#f0f0f0", "#aaaaaa", "#555555"]  // Colors of the particles
                },
                "shape": {
                    "type": "circle",  // Shape of particles
                    "stroke": {
                        "width": 0,  // No border around particles
                        "color": "#000000"
                    }
                },
                "opacity": {
                    "value": 0.6,  // Base opacity of particles
                    "random": true,  // Randomize opacity of each particle
                    "anim": {
                        "enable": false,  // Disable opacity animation
                        "speed": 1,
                        "opacity_min": 0.1,
                        "sync": false
                    }
                },
                "size": {
                    "value": 4,  // Base size of particles
                    "random": true,  // Randomize size of each particle
                    "anim": {
                        "enable": false,  // Disable size animation
                        "speed": 40,
                        "size_min": 0.1,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,  // Enable lines connecting particles
                    "distance": 150,  // Maximum distance for lines to connect
                    "color": "#f0f0f0",  // Color of the connecting lines
                    "opacity": 0.4,  // Opacity of the lines
                    "width": 1  // Width of the lines
                },
                "move": {
                    "enable": true,  // Enable particle movement
                    "speed": 3,  // Speed of particle movement
                    "direction": "none",  // Particles move in random directions
                    "random": false,  // Movement is not random
                    "straight": false,  // Particles do not move in straight lines
                    "out_mode": "out",  // Particles will disappear when they move out of bounds
                    "attract": {
                        "enable": false,  // Disable attraction between particles
                        "rotateX": 600,
                        "rotateY": 1200
                    }
                }
            }
        });
    });
</script>

<!-- Start of the CSS styles -->
<style>
    /* Importing a custom font from Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap');

    /* Styles for the main header section */
    .main-header {
        position: relative;  // Allows for positioning of child elements
        background: linear-gradient(to bottom, #343a40, #444);  // Background gradient color
        color: #f0f0f0;  // Text color
        padding: 40px 0;  // Padding at the top and bottom
        overflow: hidden;  // Ensures child elements don't overflow the header
    }

    /* Styles for the container inside the header */
    .main-header .container {
        height: 130px;  // Fixed height for the container
        display: flex;  // Flexbox layout for centering content
        flex-direction: column;  // Arrange items in a column
        align-items: center;  // Horizontally center items
        justify-content: center;  // Vertically center items
        position: relative;  // Position relative to the header
        z-index: 1;  // Ensure content is above the Particle.js background
    }

    /* Styles for the main heading (h1) */
    .main-header h1 {
        font-family: 'Roboto', sans-serif;  // Font family for the heading
        font-size: 3.5rem;  // Large font size
        margin-bottom: 10px;  // Margin below the heading
        text-shadow: 2px 2px 4px #000;  // Shadow effect on the text
    }

    /* Styles for the subheading (paragraph) */
    .main-header p {
        font-family: 'Roboto', sans-serif;  // Font family for the paragraph
        font-size: 1.5rem;  // Medium font size
        font-weight: 300;  // Light font weight
        text-shadow: 1px 1px 3px #000;  // Shadow effect on the text
    }

    /* Make text elements unselectable to prevent accidental selection */
    .unselectable {
        user-select: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }

    /* Styles for the Particle.js canvas */
    #particles-js {
        position: absolute;  // Position it absolutely within the header
        width: 100%;  // Full width
        height: 100%;  // Full height
        top: 0;  // Align to the top of the header
        left: 0;  // Align to the left side
        z-index: 0;  // Ensure it is behind other content
    }
</style>

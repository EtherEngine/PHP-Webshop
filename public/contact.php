<?php
// Start a new session or resume the existing session
session_start();

// Include the database connection file from the config directory
require __DIR__ . '/../config/db_connect.php';
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <!-- Set the character encoding for the document -->
    <meta charset="UTF-8">
    <!-- Set the viewport to ensure the page is responsive on all devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Set the title of the page -->
    <title>Kontakt</title>
    <!-- Link to the external stylesheet for custom styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Link to the Bootstrap CSS for responsive design and additional styling -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Styling for the body, container, headers, and buttons to make the page visually appealing */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .contact-container {
            max-width: 700px;
            margin: 30px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        .contact-container h1 {
            font-size: 2.5em;
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .contact-container p {
            font-size: 1.1em;
            text-align: center;
            margin-bottom: 30px;
            color: #555;
        }

        .ai-service-container h3 {
            font-size: 1.8em;
            margin-bottom: 15px;
            color: #444;
            text-align: center;
        }

        .ai-service-container p {
            font-size: 1.2em;
            text-align: center;
            margin-bottom: 15px;
            color: #666;
        }

        .contact-form h2 {
            margin-bottom: 20px;
            font-size: 1.5em;
            color: #444;
            text-align: center;
        }

        .contact-form .form-group label {
            font-weight: bold;
            color: #555;
        }

        .contact-form .btn-primary {
            background: linear-gradient(to bottom, #444, #666);
            border: none;
            color: white;
            width: 100%;
            border-radius: 20px;
            margin-top: 15px;
            padding: 10px;
            font-size: 1.1em;
        }

        .contact-form .btn-primary:hover {
            background: linear-gradient(to bottom, #222, #555);
        }

        .ai-service-container .btn-secondary {
            background: linear-gradient(to bottom, #444, #666);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 1.1em;
            transition: background 0.3s;
            margin: 0 auto;
            display: block;
        }

        .ai-service-container .btn-secondary:hover {
            background: linear-gradient(to bottom, #222, #555);
        }
    </style>
</head>

<body>
    <!-- Include the header template -->
    <?php include '../src/View/templates/header.php'; ?>
    <!-- Include the navigation template -->
    <?php include '../src/View/templates/navigation.php'; ?>

    <!-- Main container for the contact page content -->
    <div class="container contact-container">
        <!-- Title of the contact page -->
        <h1>Kontakt</h1>
        <!-- Brief introduction to the AI customer service and the contact form -->
        <p>Nutzen Sie unseren AI-Kundenservice für schnelle Antworten oder
            kontaktieren Sie uns direkt über das Formular unten.</p>

        <!-- AI service section with a button to start a live chat -->
        <div class="ai-service-container">
            <h3>AI-Kundenservice</h3>
            <p>Für schnelle Antworten auf Ihre Fragen klicken sie auf den Button.</p>
            <button id="coze-chat-button" class="btn btn-secondary">Live Chat starten</button>
        </div>

        <!-- Contact form for users to send a message -->
        <div class="contact-form mt-4">
            <h2></h2>
            <p>Wenn Sie uns direkt kontaktieren möchten, nutzen Sie bitte das folgende Formular. Wir werden uns
                innerhalb von 12 Stunden bei Ihnen melden.</p>
            <form action="contact.php" method="POST">
                <!-- Form group for the user's name -->
                <div class="form-group">
                    <label for="name">Ihr Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <!-- Form group for the user's email -->
                <div class="form-group">
                    <label for="email">Ihre E-Mail</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <!-- Form group for the user's message -->
                <div class="form-group">
                    <label for="message">Ihre Nachricht</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>
                <!-- Submit button to send the message -->
                <button type="submit" class="btn btn-primary">Nachricht senden</button>
            </form>
        </div>
    </div>

    <!-- Include the footer template -->
    <?php include '../src/View/templates/footer.php'; ?>

    <!-- Load JavaScript libraries from external sources for functionality and interactivity -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Initialize the live chat feature using the Coze Web SDK -->
    <script
        src="https://sf-cdn.coze.com/obj/unpkg-va/flow-platform/chat-app-sdk/0.1.0-beta.4/libs/oversea/index.js"></script>
    <script>
        // Event listener for the live chat button to open the chat window when clicked
        document.getElementById('coze-chat-button').addEventListener('click', function () {
            new CozeWebSDK.WebChatClient({
                config: {
                    bot_id: '7401260508328394758',
                },
                componentProps: {
                    title: 'Coze',
                },
            }).open();
        });
    </script>
</body>

</html>
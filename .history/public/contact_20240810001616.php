<?php
session_start();
require __DIR__ . '/../config/db_connect.php';
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .contact-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .contact-container h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 5px;
        }

        .btn-primary {
            background: linear-gradient(to bottom, #333, #666);
            border: none;
            color: white;
            border-radius: 20px;
            padding: 10px 20px;
        }

        .btn-primary:hover {
            background: linear-gradient(to bottom, #111, #444);
        }

        .ai-service-container {
            text-align: center;
            margin-top: 30px;
        }

        .ai-service-container h3 {
            margin-bottom: 10px;
        }

        .coze-chatbot-container .coze-button {
            display: inline-block;
            padding: 10px 20px;
            background: #007bff;
            color: #fff;
            border-radius: 20px;
            text-decoration: none;
            transition: background 0.3s;
        }

        .coze-chatbot-container .coze-button:hover {
            background: #0056b3;
        }

        .contact-container textarea {
            resize: none;
        }
    </style>
</head>

<body>
    <?php
    include '../src/View/templates/header.php';
    include '../src/View/templates/navigation.php';
    ?>

    <div class="container contact-container">
        <h2>Kontakt</h2>
        <form action="contact.php" method="POST">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">E-Mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Nachricht</label>
                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Absenden</button>
        </form>

        <div class="ai-service-container">
            <h3>Fragen? Unser AI-Kundenservice ist für Sie da!</h3>
            <p>Klicken Sie auf den Button unten, um unseren AI-Kundenservice zu starten. Wir helfen Ihnen gerne bei
                allen Fragen rund um unseren Webshop und unsere Produkte.</p>
            <div class="coze-chatbot-container">
                <a href="#" class="coze-button">Live Chat starten</a>
            </div>
        </div>
    </div>

    <?php
    include '../src/View/templates/footer.php';
    ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
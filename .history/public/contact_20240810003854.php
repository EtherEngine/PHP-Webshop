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
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
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
    <?php include '../src/View/templates/header.php'; ?>
    <?php include '../src/View/templates/navigation.php'; ?>

    <div class="container contact-container">
        <h1>Kontakt</h1>
        <p>Wir sind hier, um Ihnen zu helfen! Nutzen Sie unseren AI-Kundenservice für schnelle Antworten oder
            kontaktieren Sie uns direkt über das Formular unten.</p>

        <div class="ai-service-container">
            <h3>AI-Kundenservice</h3>
            <p>Für schnelle Antworten auf Ihre Fragen können Sie unseren AI-Kundenservice nutzen.</p>
            <button id="coze-chat-button" class="btn btn-secondary">Live Chat starten</button>
        </div>

        <div class="contact-form mt-4">
            <h2>Direkter Kontakt</h2>
            <p>Wenn Sie uns direkt erreichen möchten, nutzen Sie bitte das folgende Formular:</p>
            <form action="contact.php" method="POST">
                <div class="form-group">
                    <label for="name">Ihr Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Ihre E-Mail</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="message">Ihre Nachricht</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Nachricht senden</button>
            </form>
        </div>
    </div>

    <?php include '../src/View/templates/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script
        src="https://sf-cdn.coze.com/obj/unpkg-va/flow-platform/chat-app-sdk/0.1.0-beta.4/libs/oversea/index.js"></script>
    <script>
        document.getElementById('coze-chat-button').addEventListener('click', function () {
            new CozeWebSDK.WebChatClient({
                config: {
                    bot_id: '7388298896462266374',
                },
                componentProps: {
                    title: 'Coze',
                },
            }).open();
        });
    </script>
</body>

</html>
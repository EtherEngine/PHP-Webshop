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
        .contact-form {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .contact-form h1 {
            margin-bottom: 20px;
            font-size: 2em;
            text-align: center;
        }

        .contact-form .form-group label {
            font-weight: bold;
        }

        .contact-form .btn-primary {
            background: linear-gradient(to bottom, #333, #666);
            border: none;
            color: white;
            width: 100%;
            border-radius: 20px;
            margin-top: 15px;
        }

        .contact-form .btn-primary:hover {
            background: linear-gradient(to bottom, #111, #444);
        }

        .ai-service-container {
            text-align: center;
            margin-top: 30px;
        }

        .ai-service-container h3 {
            margin-bottom: 15px;
        }

        .ai-service-container .btn-secondary {
            background: linear-gradient(to bottom, #333, #666);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            transition: background 0.3s;
        }

        .ai-service-container .btn-secondary:hover {
            background: linear-gradient(to bottom, #111, #444);
        }
    </style>
</head>

<body>
    <?php include '../src/View/templates/header.php'; ?>
    <?php include '../src/View/templates/navigation.php'; ?>

    <div class="container">
        <div class="contact-form">
            <h1>Kontakt</h1>
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
        </div>

        <div class="ai-service-container">
            <h3>Fragen? Unser AI-Kundenservice ist für Sie da!</h3>
            <p>Klicken Sie auf den Button unten, um unseren AI-Kundenservice zu starten. Wir helfen Ihnen gerne bei
                allen Fragen rund um unseren Webshop und unsere Produkte.</p>
            <button id="coze-chat-button" class="btn btn-secondary">Live Chat starten</button>
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
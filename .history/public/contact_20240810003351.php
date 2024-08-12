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
        .contact-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .contact-container h1 {
            font-size: 2.5em;
            text-align: center;
            margin-bottom: 20px;
        }

        .contact-container p {
            font-size: 1.1em;
            text-align: center;
            margin-bottom: 30px;
        }

        .contact-form h2 {
            margin-bottom: 20px;
            font-size: 1.5em;
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

    <div class="container contact-container">
        <h1>Kontakt</h1>
        <p>Unser AI-Kundenservice steht Ihnen jederzeit zur Verfügung, um alle Fragen rund um unseren Webshop und unsere
            Produkte zu beantworten. Klicken Sie einfach auf den untenstehenden Button, um den Chat zu starten.</p>

        <div class="ai-service-container">
            <h3>Fragen? Unser AI-Kundenservice ist für Sie da!</h3>
            <p>Klicken Sie auf den Button, um direkt mit unserem AI-Kundenservice zu sprechen. Wenn Sie eine persönliche
                Anfrage haben, können Sie gerne das Kontaktformular unten ausfüllen.</p>
            <button id="coze-chat-button" class="btn btn-secondary">Live Chat starten</button>
        </div>

        <div class="contact-form">
            <h2>Persönlicher Kontakt</h2>
            <p>Wenn Sie weitere Unterstützung benötigen oder uns direkt kontaktieren möchten, füllen Sie bitte das
                untenstehende Formular aus. Unser Support-Team wird sich so schnell wie möglich bei Ihnen melden.</p>
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
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
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .contact-container h2 {
            margin-bottom: 20px;
            font-family: 'Roboto', sans-serif;
            color: #333;
        }

        .form-group label {
            font-weight: bold;
            color: #555;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .btn-primary {
            background: linear-gradient(to bottom, #333, #666);
            border: none;
            color: white;
            border-radius: 20px;
            transition: background 0.3s;
        }

        .btn-primary:hover {
            background: linear-gradient(to bottom, #111, #444);
        }

        .alert {
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .ai-service-container {
            margin-top: 30px;
            padding: 20px;
            border-radius: 10px;
            background-color: #f8f9fa;
            text-align: center;
        }

        .ai-service-container h3 {
            font-family: 'Roboto', sans-serif;
            color: #333;
            margin-bottom: 10px;
        }

        .ai-service-container p {
            font-family: 'Roboto', sans-serif;
            color: #555;
            margin-bottom: 20px;
        }

        .coze-chatbot-container {
            text-align: center;
        }

        .coze-button {
            background: linear-gradient(to bottom, #333, #666);
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            text-decoration: none;
            font-family: 'Roboto', sans-serif;
        }

        .coze-button:hover {
            background: linear-gradient(to bottom, #111, #444);
            text-decoration: none;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container contact-container">
        <h2>Kontaktieren Sie uns</h2>
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
            <button type="submit" class="btn btn-primary">Nachricht senden</button>
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

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script
        src="https://sf-cdn.coze.com/obj/unpkg-va/flow-platform/chat-app-sdk/0.1.0-beta.4/libs/oversea/index.js"></script>
    <script>
        function startCozeChatbot() {
            new CozeWebSDK.WebChatClient({
                config: {
                    bot_id: '7388298896462266374',
                },
                componentProps: {
                    title: 'Coze',
                },
            });
        }

        document.querySelector('.coze-button').addEventListener('click', function (event) {
            event.preventDefault();
            startCozeChatbot();
        });
    </script>
</body>

</html>
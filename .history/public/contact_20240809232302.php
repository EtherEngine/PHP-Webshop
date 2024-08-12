<?php
// Session starten
session_start();

// Einbindung der Datenbankverbindung
require __DIR__ . '/../config/db_connect.php';

// Handhabung des Kontaktformulars
$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');

    if (!$name || !$email || !$message) {
        $error_message = 'Bitte alle Felder ausfüllen.';
    } else {
        // Hier würdest du die Nachricht in der Datenbank speichern oder per E-Mail versenden
        // ...

        $success_message = 'Vielen Dank für Ihre Nachricht. Wir werden uns so schnell wie möglich bei Ihnen melden.';
    }
}
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
    </style>
</head>

<body>
    <?php
    include '../src/View/templates/header.php';
    include '../src/View/templates/navigation.php';
    ?>

    <div class="container contact-container">
        <h2>Kontaktieren Sie uns</h2>
        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success_message); ?></div>
        <?php endif; ?>
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
    </div>

    <?php
    include '../src/View/templates/footer.php';
    ?>

    <!-- Cozy Chatbot Script -->
    <script
        src="https://sf-cdn.coze.com/obj/unpkg-va/flow-platform/chat-app-sdk/0.1.0-beta.4/libs/oversea/index.js"></script>
    <script>
        new CozeWebSDK.WebChatClient({
            config: {
                bot_id: '7388298896462266374',
            },
            componentProps: {
                title: 'Coze',
            },
        });
    </script>
</body>

</html>
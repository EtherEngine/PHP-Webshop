<?php
session_start();
require __DIR__ . '/../config/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banküberweisung</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5f5;
        }

        .container {
            margin-top: 50px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        .payment-header {
            margin-bottom: 30px;
        }

        .payment-header h2 {
            margin: 0;
            font-size: 1.8em;
            color: #333;
        }

        .btn-primary {
            background: linear-gradient(to bottom, #333, #666);
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 1em;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .btn-primary:hover {
            background: linear-gradient(to bottom, #111, #444);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="payment-header">
            <h2>Banküberweisung</h2>
        </div>
        <p>Vielen Dank für Ihre Bestellung. Eine E-Mail mit den Zahlungsinformationen wurde an Ihre E-Mail-Adresse
            gesendet.</p>
        <div class="mt-4">
            <a href="index.php" class="btn btn-primary">Zurück zum Shop</a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
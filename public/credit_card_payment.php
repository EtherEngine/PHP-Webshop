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
    <title>Kreditkartenzahlung</title>
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
        }

        .payment-header {
            text-align: center;
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

        .form-group label {
            font-weight: bold;
            color: #555;
        }

        .form-control {
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="payment-header">
            <h2>Kreditkartenzahlung</h2>
        </div>
        <div class="mt-4">
            <form action="process_credit_card.php" method="POST">
                <div class="form-group">
                    <label for="card-number">Kreditkartennummer</label>
                    <input type="text" class="form-control" id="card-number" name="card_number" required>
                </div>
                <div class="form-group">
                    <label for="card-expiry">Ablaufdatum</label>
                    <input type="text" class="form-control" id="card-expiry" name="card_expiry" required>
                </div>
                <div class="form-group">
                    <label for="card-cvc">CVC</label>
                    <input type="text" class="form-control" id="card-cvc" name="card_cvc" required>
                </div>
                <button type="submit" class="btn btn-primary">Bezahlen</button>
            </form>
        </div>
        <div class="back-to-shop">
            <a href="index.php">Zurück zum Shop</a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
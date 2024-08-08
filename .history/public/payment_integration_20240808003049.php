<?php
session_start();
require __DIR__ . '/../config/db_connect.php';

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Berechnen der Gesamtsumme
function calculateTotal()
{
    $total = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $product) {
            $total += $product['price'] * $product['quantity'];
        }
    }
    return $total;
}

$total = calculateTotal();
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zahlung</title>
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

        .payment-total {
            font-size: 1.5em;
            text-align: right;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }

        .payment-total .total-price {
            color: #333;
            font-weight: bold;
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

        .back-to-shop {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .back-to-shop a {
            color: #666;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .back-to-shop a:hover {
            color: #333;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="payment-header">
            <h2>Zahlung</h2>
        </div>
        <div class="payment-total">
            Gesamt: <span class="total-price"><?php echo number_format($total, 2, ',', '.'); ?> €</span>
        </div>
        <div class="mt-4">
            <form action="process_payment.php" method="POST">
                <div class="form-group">
                    <label for="payment-method">Zahlungsmethode</label>
                    <select class="form-control" id="payment-method" name="payment_method" required>
                        <option value="paypal">PayPal</option>
                        <option value="credit_card">Kreditkarte</option>
                        <option value="bank_transfer">Banküberweisung</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Weiter</button>
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
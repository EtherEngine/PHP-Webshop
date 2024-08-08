<?php
session_start();
require __DIR__ . '/../config/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simuliere eine Zahlung
    $payment_method = $_POST['payment_method'];
    if ($payment_method) {
        // Hier würden Sie die Zahlung verarbeiten
        // Nach der erfolgreichen Zahlung:
        unset($_SESSION['cart']);
        header('Location: success.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zahlungsabwicklung</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .payment-method {
            margin-bottom: 20px;
        }

        .btn-custom {
            background: linear-gradient(to bottom, #333, #666);
            color: white;
            border-radius: 25px;
            padding: 10px 20px;
            margin-top: 10px;
            display: inline-block;
            text-decoration: none;
        }

        .btn-custom:hover {
            background: linear-gradient(to bottom, #111, #444);
            color: white;
        }
    </style>
</head>

<body>
    <?php include '../src/View/templates/header.php'; ?>
    <div class="container mt-5">
        <h2>Zahlungsabwicklung</h2>
        <p>Gesamtsumme: <?php echo number_format($total, 2, ',', '.'); ?> €</p>
        <form action="payment_integration.php" method="POST">
            <div class="payment-method">
                <h4>Kreditkarte</h4>
                <div class="form-group">
                    <label for="card_number">Kartennummer</label>
                    <input type="text" class="form-control" id="card_number" name="card_number" required>
                </div>
                <div class="form-group">
                    <label for="card_expiry">Ablaufdatum</label>
                    <input type="text" class="form-control" id="card_expiry" name="card_expiry" required>
                </div>
                <div class="form-group">
                    <label for="card_cvc">CVC</label>
                    <input type="text" class="form-control" id="card_cvc" name="card_cvc" required>
                </div>
                <button type="submit" class="btn btn-custom" name="payment_method" value="credit_card">Mit Kreditkarte
                    zahlen</button>
            </div>

            <div class="payment-method">
                <h4>PayPal</h4>
                <p>Sie werden zu PayPal weitergeleitet, um die Zahlung abzuschließen.</p>
                <button type="submit" class="btn btn-custom" name="payment_method" value="paypal">Mit PayPal
                    zahlen</button>
            </div>

            <div class="payment-method">
                <h4>Banküberweisung</h4>
                <p>Bitte überweisen Sie den Betrag auf folgendes Konto:</p>
                <p>
                    Bank: Musterbank<br>
                    IBAN: DE12345678901234567890<br>
                    BIC: MUSZDEFFXXX<br>
                    Verwendungszweck: Bestellung #<?php echo rand(1000, 9999); ?>
                </p>
                <button type="submit" class="btn btn-custom" name="payment_method" value="bank_transfer">Zahlung per
                    Banküberweisung abschließen</button>
            </div>
        </form>
    </div>
    <?php include '../src/View/templates/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
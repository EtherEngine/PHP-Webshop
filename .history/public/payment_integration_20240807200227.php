<?php
session_start();
require __DIR__ . '/../config/db_connect.php';
require __DIR__ . '/../config/paypal_config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'];
}

$payment_url = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_method = $_POST['payment_method'];
    if ($payment_method) {
        $shop_account = "DE12345678901234567890"; // Beispielkonto
        $total_amount = number_format($total, 2, '.', '');

        switch ($payment_method) {
            case 'credit_card':
                // Hier würde die Kreditkarten-API-Integration erfolgen
                $payment_url = "https://www.kreditkartenanbieter.de/payment?amount=$total_amount&account=$shop_account";
                break;
            case 'paypal':
                // PayPal-Integration
                $payment_url = createPayPalPayment($total_amount);
                break;
            case 'bank_transfer':
                // Hier würde die Banküberweisungs-Logik erfolgen
                $payment_url = "https://www.bankwebsite.com/transfer?amount=$total_amount&account=$shop_account";
                break;
            default:
                // Standardaktion
                break;
        }

        if ($payment_url) {
            header("Location: $payment_url");
            exit;
        }
    }
}

function createPayPalPayment($amount)
{
    $url = PAYPAL_BASE_URL . '/v1/oauth2/token';
    $headers = [
        'Accept: application/json',
        'Accept-Language: en_US'
    ];
    $postFields = 'grant_type=client_credentials';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_USERPWD, PAYPAL_CLIENT_ID . ':' . PAYPAL_SECRET);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($response);
    $access_token = $json->access_token;

    $url = PAYPAL_BASE_URL . '/v2/checkout/orders';
    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $access_token
    ];
    $postFields = json_encode([
        'intent' => 'CAPTURE',
        'purchase_units' => [
            [
                'amount' => [
                    'currency_code' => 'EUR',
                    'value' => $amount
                ]
            ]
        ],
        'application_context' => [
            'return_url' => 'http://localhost/Klausurprojekt/public/success.php',
            'cancel_url' => 'http://localhost/Klausurprojekt/public/cancel.php'
        ]
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($response);
    return $json->links[1]->href; // Link zur Zahlungsseite
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
            <div class="form-group">
                <label for="payment_method">Zahlungsmethode auswählen:</label>
                <select class="form-control" id="payment_method" name="payment_method" required>
                    <option value="credit_card">Kreditkarte</option>
                    <option value="paypal">PayPal</option>
                    <option value="bank_transfer">Banküberweisung</option>
                </select>
            </div>
            <div id="credit_card_info" class="payment-method">
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
            </div>

            <div id="paypal_info" class="payment-method" style="display: none;">
                <h4>PayPal</h4>
                <p>Sie werden zu PayPal weitergeleitet, um die Zahlung abzuschließen.</p>
            </div>

            <div id="bank_transfer_info" class="payment-method" style="display: none;">
                <h4>Banküberweisung</h4>
                <p>Bitte überweisen Sie den Betrag auf folgendes Konto:</p>
                <p>
                    Bank: Musterbank<br>
                    IBAN: DE12345678901234567890<br>
                    BIC: MUSZDEFFXXX<br>
                    Verwendungszweck: Bestellung #<?php echo rand(1000, 9999); ?>
                </p>
            </div>

            <button type="submit" class="btn btn-custom">Zahlung durchführen</button>
        </form>
    </div>
    <?php include '../src/View/templates/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#payment_method').on('change', function () {
                var selectedMethod = $(this).val();
                $('.payment-method').hide();
                if (selectedMethod === 'credit_card') {
                    $('#credit_card_info').show();
                } else if (selectedMethod === 'paypal') {
                    $('#paypal_info').show();
                } else if (selectedMethod === 'bank_transfer') {
                    $('#bank_transfer_info').show();
                }
            });

            // Initial Anzeige
            $('#payment_method').trigger('change');
        });
    </script>
</body>

</html>
<?php
// Simulierter Zahlungsvorgang
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];

    // Hier würde der tatsächliche Zahlungsvorgang durchgeführt
    echo 'Zahlung von ' . $amount . ' € mit ' . $payment_method . ' erfolgreich.';
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zahlung</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div class="container">
        <h1>Zahlung durchführen</h1>
        <form action="payment_integration.php" method="POST">
            <label for="amount">Betrag:</label>
            <input type="number" id="amount" name="amount" required>
            <label for="payment_method">Zahlungsmethode:</label>
            <select id="payment_method" name="payment_method">
                <option value="paypal">PayPal</option>
                <option value="credit_card">Kreditkarte</option>
            </select>
            <input type="submit" value="Zahlen">
        </form>
    </div>
</body>

</html>
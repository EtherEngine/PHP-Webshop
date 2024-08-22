<?php

namespace Model;

require 'C:/xampp/htdocs/Klausurprojekt/config/db_connect.php';


class Order
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Erstelle eine neue Bestellung
    public function createOrder($userId, $totalPrice, $shippingAddress, $paymentMethod, $items)
    {
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare('INSERT INTO orders (user_id, total_price, shipping_address, payment_method) VALUES (?, ?, ?, ?)');
            $stmt->execute([$userId, $totalPrice, $shippingAddress, $paymentMethod]);
            $orderId = $this->pdo->lastInsertId();

            foreach ($items as $item) {
                $stmt = $this->pdo->prepare('INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)');
                $stmt->execute([$orderId, $item['product_id'], $item['quantity'], $item['price']]);
            }

            $this->pdo->commit();
            return $orderId;
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    // Holt eine Bestellung anhand der ID
    public function getOrderById($orderId)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM orders WHERE id = ?');
        $stmt->execute([$orderId]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // Holt alle Bestellungen eines Benutzers
    public function getAllOrders($userId)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM orders WHERE user_id = ?');
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Holt die Produkte einer Bestellung
    public function getOrderItemsByOrderId($orderId)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM order_items WHERE order_id = ?');
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Aktualisiert den Status einer Bestellung
    public function updateOrderStatus($orderId, $status)
    {
        $stmt = $this->pdo->prepare('UPDATE orders SET status = ? WHERE id = ?');
        return $stmt->execute([$status, $orderId]);
    }

    // Löscht eine Bestellung
    public function deleteOrder($orderId)
    {
        $stmt = $this->pdo->prepare('DELETE FROM orders WHERE id = ?');
        return $stmt->execute([$orderId]);
    }
}

// Testdatei um die Order-Klasse zu testen

require 'Order.php';

$pdo = new \PDO('mysql:host=localhost;dbname=webshop', 'root', '');

// Neue Instanz der Order-Klasse erstellen
$orderModel = new \Model\Order($pdo);

// Beispiel: Bestellung anzeigen
$orderId = 1; // Die ID der Bestellung, die angezeigt werden soll
$order = $orderModel->getOrderById($orderId);
$products = $orderModel->getOrderItemsByOrderId($orderId);

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestelldetails</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .order-container {
            margin-top: 30px;
        }

        .order-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .order-header h2 {
            font-size: 2.5em;
            color: #333;
            font-family: 'Arial', sans-serif;
            margin-bottom: 20px;
        }

        .order-details {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .order-details h3 {
            font-size: 1.5em;
            margin-bottom: 20px;
            color: #333;
        }

        .order-details p {
            font-size: 1.2em;
            margin-bottom: 5px;
        }

        .order-products {
            margin-top: 30px;
        }

        .order-products table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-products th,
        .order-products td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .order-products th {
            background-color: #333;
            color: white;
            font-weight: bold;
        }

        .order-status {
            margin-top: 30px;
            text-align: center;
        }

        .order-status .status-indicator {
            font-size: 1.5em;
            padding: 10px;
            border-radius: 5px;
            color: white;
        }

        .order-status .confirmed {
            background-color: #007bff;
        }

        .order-status .processing {
            background-color: #ffc107;
        }

        .order-status .shipped {
            background-color: #28a745;
        }

        .order-status .delivered {
            background-color: #17a2b8;
        }

        .order-total {
            font-size: 1.5em;
            text-align: right;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }

        .order-total .total-price {
            color: #333;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/../View/templates/header.php'; ?>
    <?php include __DIR__ . '/../View/templates/navigation.php'; ?>

    <div class="container order-container">
        <div class="order-header">
            <h2>Bestelldetails</h2>
        </div>

        <div class="order-details">
            <h3>Bestellnummer: <?php echo htmlspecialchars($order['id']); ?></h3>
            <p><strong>Bestelldatum:</strong> <?php echo date('d.m.Y', strtotime($order['order_date'])); ?></p>
            <p><strong>Versandadresse:</strong> <?php echo htmlspecialchars($order['shipping_address']); ?></p>
            <p><strong>Gesamtbetrag:</strong> <?php echo number_format($order['total_price'], 2, ',', '.'); ?> €</p>
        </div>

        <div class="order-products">
            <h3>Bestellte Produkte</h3>
            <table>
                <thead>
                    <tr>
                        <th>Produkt</th>
                        <th>Menge</th>
                        <th>Preis</th>
                        <th>Zwischensumme</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td>
                                <img src="../assets/images/<?php echo htmlspecialchars($product['image']); ?>"
                                    alt="<?php echo htmlspecialchars($product['name']); ?>" style="height: 50px;">
                                <?php echo htmlspecialchars($product['name']); ?>
                            </td>
                            <td><?php echo $product['quantity']; ?></td>
                            <td><?php echo number_format($product['price'], 2, ',', '.'); ?> €</td>
                            <td><?php echo number_format($product['price'] * $product['quantity'], 2, ',', '.'); ?> €</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="order-status">
            <h3>Bestellstatus</h3>
            <div class="status-indicator <?php echo strtolower($order['status']); ?>">
                <?php echo ucfirst($order['status']); ?>
            </div>
        </div>

        <div class="order-total">
            Gesamt: <span class="total-price"><?php echo number_format($order['total_price'], 2, ',', '.'); ?> €</span>
        </div>
    </div>

    <?php include __DIR__ . '/../View/templates/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
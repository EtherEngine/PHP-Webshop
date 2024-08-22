<?php
session_start();
require __DIR__ . '/../config/db_connect.php';

// Holen der Daten aus dem POST-Request
$shipping_method = $_POST['shipping_method'];
$total_weight = $_POST['total_weight'];
$country = $_POST['country'];
$total = $_POST['total'];

// Funktion zur Berechnung der Versandkosten
function calculate_shipping_cost($method, $weight, $country, $total)
{
    $base_cost = 0;

    switch ($method) {
        case 'standard':
            $base_cost = 5.00;
            break;
        case 'express':
            $base_cost = 10.00;
            break;
        case 'same_day':
            $base_cost = 20.00;
            break;
        case 'packstation':
            $base_cost = 4.00;
            break;
        case 'international':
            $base_cost = 15.00;
            break;
        case 'free_shipping':
            if ($total >= 50) {
                return 0;
            } else {
                $base_cost = 5.00;
            }
            break;
        case 'cash_on_delivery':
            $base_cost = 7.00; // Zusätzliche Gebühr für Nachnahme
            break;
        default:
            $base_cost = 5.00;
            break;
    }

    // Gewichtszuschlag berechnen
    if ($weight > 5) {
        $base_cost += 5.00; // Zuschlag für schwerere Pakete
    }

    // Zuschlag für internationale Sendungen
    if ($country !== 'Deutschland') {
        $base_cost += 10.00;
    }

    return $base_cost;
}

// Versandkosten berechnen
$shipping_cost = calculate_shipping_cost($shipping_method, $total_weight, $country, $total);

// Rückgabe der Versandkosten
echo json_encode(['shipping_cost' => $shipping_cost]);

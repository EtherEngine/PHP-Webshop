<?php

require_once __DIR__ . '/../config/db_connect.php';
require_once __DIR__ . '/../Model/User.php';
require_once __DIR__ . '/../Model/Product.php';
require_once __DIR__ . '/../Model/Order.php';
require_once __DIR__ . '/../Model/SalesReport.php';

class AdminController
{
    public function __construct()
    {
        session_start();
        if (!isset($_SESSION['admin_logged_in'])) {
            header('Location: admin_login.php');
            exit();
        }
    }

    // Benutzer sperren/entsperren
    public function toggleUserStatus($userId)
    {
        $user = new User();
        $status = $user->toggleStatus($userId);
        return $status;
    }

    // Produkt hinzufügen
    public function addProduct($productData)
    {
        $product = new Product();
        $product->add($productData);
    }

    // Produkt bearbeiten
    public function editProduct($productId, $productData)
    {
        $product = new Product();
        $product->edit($productId, $productData);
    }

    // Produkt löschen
    public function deleteProduct($productId)
    {
        $product = new Product();
        $product->delete($productId);
    }

    // Alle Bestellungen einsehen
    public function viewOrders()
    {
        $order = new Order();
        return $order->getAllOrders();
    }

    // Verkaufsbericht anzeigen
    public function viewSalesReport()
    {
        $report = new SalesReport();
        return $report->getReport();
    }
}



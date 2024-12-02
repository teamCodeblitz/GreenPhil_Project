<?php
// backend/index.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'config/database.php'; // Ensure the database connection is included
header('Content-Type: application/json');

$requestUri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Route handling
switch (true) {
    // Registration Route
    case preg_match('/^\/register$/', $requestUri) && $method === 'POST':
        include 'register.php';
        break;

    // Login Route
    case preg_match('/^\/login$/', $requestUri) && $method === 'POST':
        include 'login.php';
        break;

    // Admin Routes
    case preg_match('/^\/admin\/manage_orders$/', $requestUri) && $method === 'GET':
        include 'api/admin/manage_orders.php'; // Fetch all orders for admin
        break;

    case preg_match('/^\/admin\/manage_orders$/', $requestUri) && $method === 'POST':
        include 'api/admin/manage_orders.php'; // Handle POST requests to update order status (e.g., shipped, canceled)
        break;

    case preg_match('/^\/admin\/manage_customers$/', $requestUri) && $method === 'GET':
        include 'api/admin/manage_customers.php'; // Fetch customer details for admin
        break;

    case preg_match('/^\/admin\/manage_inventory$/', $requestUri) && $method === 'GET':
        include 'api/admin/manage_inventory.php'; // Fetch inventory details for admin
        break;

    // Product Search Route
    case preg_match('/^\/search_products$/', $requestUri) && $method === 'GET':
        include 'api/search_products.php'; // Fetch products based on search criteria (filters, keywords)
        break;

    // Order History Route (for customers)
    case preg_match('/^\/order_history$/', $requestUri) && $method === 'GET':
        include 'api/order_history.php'; // Fetch order history for customers
        break;

    default:
        echo json_encode([
            "status" => "error",
            "message" => "Route not found."
        ]);
        break;
}

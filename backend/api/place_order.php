<?php
// api/place_order.php
require 'config/database.php';

// Ensure the user is logged in
session_start();
if (!isset($_SESSION['customer_id'])) {
    echo json_encode(["status" => "error", "message" => "You must be logged in to place an order."]);
    exit();
}

// Get the POST data
$data = json_decode(file_get_contents('php://input'), true);

// Extract order data
$products = $data['products']; // Array of product_id and quantity
$total_amount = 0;

foreach ($products as $product) {
    $product_id = $product['product_id'];
    $quantity = $product['quantity'];

    // Get product price and stock
    $sql = "SELECT price, stock FROM product WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product_data = $result->fetch_assoc();

    if (!$product_data || $product_data['stock'] < $quantity) {
        echo json_encode(["status" => "error", "message" => "Insufficient stock for product ID: $product_id"]);
        exit();
    }

    $total_amount += $product_data['price'] * $quantity;
}

// Insert the order
$order_sql = "INSERT INTO orders (customer_id, total_amount, status) VALUES (?, ?, 'Pending')";
$order_stmt = $conn->prepare($order_sql);
$order_stmt->bind_param("id", $_SESSION['customer_id'], $total_amount);
$order_stmt->execute();
$order_id = $order_stmt->insert_id;

$order_stmt->close();

// Insert order items
foreach ($products as $product) {
    $product_id = $product['product_id'];
    $quantity = $product['quantity'];
    $price = $product['price'];

    $order_item_sql = "INSERT INTO orderitem (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
    $order_item_stmt = $conn->prepare($order_item_sql);
    $order_item_stmt->bind_param("iiii", $order_id, $product_id, $quantity, $price);
    $order_item_stmt->execute();
}

echo json_encode(["status" => "success", "message" => "Order placed successfully."]);

$order_item_stmt->close();
$conn->close();
?>

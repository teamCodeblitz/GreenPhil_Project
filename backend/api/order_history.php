<?php
// api/order_history.php
require 'config/database.php';

// Ensure the user is logged in
session_start();
if (!isset($_SESSION['customer_id'])) {
    echo json_encode(["status" => "error", "message" => "You must be logged in to view your order history."]);
    exit();
}

// Get the customer's order history
$sql = "SELECT o.order_id, o.total_amount, o.status, o.order_date, oi.product_id, oi.quantity, oi.price 
        FROM orders o
        LEFT JOIN orderitem oi ON o.order_id = oi.order_id
        WHERE o.customer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['customer_id']);
$stmt->execute();
$result = $stmt->get_result();

$order_history = [];
while ($row = $result->fetch_assoc()) {
    $order_history[] = $row;
}

echo json_encode(["status" => "success", "data" => $order_history]);

$stmt->close();
$conn->close();
?>

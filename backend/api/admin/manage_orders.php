<?php
// api/manage_orders.php
require 'config/database.php';

// Ensure the user is logged in and is an admin
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'Manager') {
    echo json_encode(["status" => "error", "message" => "Unauthorized access."]);
    exit();
}

// Get the GET data
$order_id = $_GET['order_id'] ?? null;
$status = $_GET['status'] ?? null;

// Get orders
if ($order_id) {
    // Fetch a specific order by order_id
    $sql = "SELECT * FROM orders WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
} else {
    // Fetch all orders
    $sql = "SELECT * FROM orders";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();
$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

// If the admin wants to update the order status
if ($status && $order_id) {
    $update_sql = "UPDATE orders SET status = ? WHERE order_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $status, $order_id);
    if ($update_stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Order status updated."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error updating order status."]);
    }
    $update_stmt->close();
}

echo json_encode(["status" => "success", "data" => $orders]);

$stmt->close();
$conn->close();
?>

<?php
// api/payment.php
require 'config/database.php';

// Ensure the user is logged in
session_start();
if (!isset($_SESSION['customer_id'])) {
    echo json_encode(["status" => "error", "message" => "You must be logged in to make a payment."]);
    exit();
}

// Get the POST data
$data = json_decode(file_get_contents('php://input'), true);

// Extract payment data
$order_id = $data['order_id'];
$amount = $data['amount'];
$status = $data['status']; // e.g., Paid, Failed

// Validate payment
if (empty($order_id) || empty($amount) || empty($status)) {
    echo json_encode(["status" => "error", "message" => "Order ID, amount, and status are required."]);
    exit();
}

// Check if order exists and total amount matches
$sql = "SELECT total_amount FROM orders WHERE order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order || $order['total_amount'] !== $amount) {
    echo json_encode(["status" => "error", "message" => "Invalid order or amount."]);
    exit();
}

// Insert payment
$payment_sql = "INSERT INTO payment (order_id, payment_date, amount, status) VALUES (?, NOW(), ?, ?)";
$payment_stmt = $conn->prepare($payment_sql);
$payment_stmt->bind_param("iis", $order_id, $amount, $status);

if ($payment_stmt->execute()) {
    // Update order status if payment is successful
    if ($status === 'Paid') {
        $order_update_sql = "UPDATE orders SET status = 'Completed' WHERE order_id = ?";
        $order_update_stmt = $conn->prepare($order_update_sql);
        $order_update_stmt->bind_param("i", $order_id);
        $order_update_stmt->execute();
        echo json_encode(["status" => "success", "message" => "Payment successful and order completed."]);
    } else {
        echo json_encode(["status" => "success", "message" => "Payment status: " . $status]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Error processing payment."]);
}

$payment_stmt->close();
$conn->close();
?>

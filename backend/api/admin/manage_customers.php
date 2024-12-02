<?php
// api/manage_customers.php
require 'config/database.php';

// Ensure the user is logged in and is an admin
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'Manager') {
    echo json_encode(["status" => "error", "message" => "Unauthorized access."]);
    exit();
}

// Get the GET data
$customer_id = $_GET['customer_id'] ?? null;

// Get customers
if ($customer_id) {
    // Fetch a specific customer by customer_id
    $sql = "SELECT * FROM customer WHERE customer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $customer_id);
} else {
    // Fetch all customers
    $sql = "SELECT * FROM customer";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();
$customers = [];
while ($row = $result->fetch_assoc()) {
    $customers[] = $row;
}

echo json_encode(["status" => "success", "data" => $customers]);

$stmt->close();
$conn->close();
?>

<?php
// api/manage_inventory.php
require 'config/database.php';

// Ensure the user is logged in and is an admin
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'Manager') {
    echo json_encode(["status" => "error", "message" => "Unauthorized access."]);
    exit();
}

// Get the GET data
$product_id = $_GET['product_id'] ?? null;
$stock_update = $_GET['stock_update'] ?? null;

// Get inventory
if ($product_id) {
    // Fetch a specific product's inventory by product_id
    $sql = "SELECT * FROM product WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
} else {
    // Fetch all products and their stock levels
    $sql = "SELECT product_id, name, stock FROM product";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();
$inventory = [];
while ($row = $result->fetch_assoc()) {
    $inventory[] = $row;
}

// If the admin wants to update the product stock
if ($stock_update && $product_id) {
    $update_sql = "UPDATE product SET stock = ? WHERE product_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ii", $stock_update, $product_id);
    if ($update_stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Product stock updated."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error updating product stock."]);
    }
    $update_stmt->close();
}

echo json_encode(["status" => "success", "data" => $inventory]);

$stmt->close();
$conn->close();
?>

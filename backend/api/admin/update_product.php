<?php
// api/update_product.php
require 'config/database.php';

// Ensure the user is logged in and is an admin
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'Manager') {
    echo json_encode(["status" => "error", "message" => "Unauthorized access."]);
    exit();
}

// Get the PUT data
$data = json_decode(file_get_contents('php://input'), true);

// Extract product data
$product_id = $data['product_id'];
$name = $data['name'];
$description = $data['description'];
$price = $data['price'];
$stock = $data['stock'];

// Validate required fields
if (empty($product_id) || empty($name) || empty($price) || empty($stock)) {
    echo json_encode(["status" => "error", "message" => "Product ID, name, price, and stock are required."]);
    exit();
}

// Update the product in the database
$sql = "UPDATE product SET name = ?, description = ?, price = ?, stock = ? WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdii", $name, $description, $price, $stock, $product_id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Product updated successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>

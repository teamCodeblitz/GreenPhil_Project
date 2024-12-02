<?php
// api/add_product.php
require 'config/database.php';

// Ensure the user is logged in and is an admin
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'Manager') {
    echo json_encode(["status" => "error", "message" => "Unauthorized access."]);
    exit();
}

// Get the POST data
$data = json_decode(file_get_contents('php://input'), true);

// Extract product data
$name = $data['name'];
$description = $data['description'];
$price = $data['price'];
$stock = $data['stock'];
$supplier_id = $data['supplier_id'];

// Validate required fields
if (empty($name) || empty($price) || empty($stock)) {
    echo json_encode(["status" => "error", "message" => "Product name, price, and stock are required."]);
    exit();
}

// Insert the product into the database
$sql = "INSERT INTO product (name, description, price, stock, supplier_id) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdii", $name, $description, $price, $stock, $supplier_id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Product added successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>

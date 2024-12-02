<?php
// api/view_products.php
require 'config/database.php';

// Get the products from the database
$sql = "SELECT * FROM product";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

// Return the products as a JSON response
echo json_encode(["status" => "success", "data" => $products]);

$stmt->close();
$conn->close();
?>

<?php
// api/search_products.php
require 'config/database.php';

// Get the search query and filters from the GET request
$search_query = $_GET['search_query'] ?? '';
$category = $_GET['category'] ?? '';
$min_price = $_GET['min_price'] ?? 0;
$max_price = $_GET['max_price'] ?? 10000;
$in_stock = $_GET['in_stock'] ?? 1; // 1 = in stock, 0 = out of stock

// Build the query
$sql = "SELECT * FROM product WHERE name LIKE ? AND price BETWEEN ? AND ?";
$params = ["%$search_query%", $min_price, $max_price];

if ($category) {
    $sql .= " AND category = ?";
    $params[] = $category;
}
if ($in_stock) {
    $sql .= " AND stock > 0";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat("s", count($params) - 2) . "ii", ...$params);
$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode(["status" => "success", "data" => $products]);

$stmt->close();
$conn->close();
?>

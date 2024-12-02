<?php
// api/register.php
require_once 'config/database.php';

// Allow cross-origin requests (for development purposes)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Establish database connection
$conn = getDbConnection();

// Get the POST data
$data = json_decode(file_get_contents('php://input'), true);

$name = $data['name'] ?? '';
$email = $data['email'] ?? '';
$address = $data['address'] ?? '';
$phoneNumber = $data['phoneNumber'] ?? '';
$password = $data['password'] ?? '';

// Check if required fields are set
if (empty($name) || empty($email) || empty($address) || empty($phoneNumber) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "All fields are required."]);
    exit();
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["status" => "error", "message" => "Invalid email format."]);
    exit();
}

// Validate phone number
if (!preg_match("/^\d{11}$/", $phoneNumber)) {
    echo json_encode(["status" => "error", "message" => "Phone number must be exactly 11 digits."]);
    exit();
}

// Check if email already exists
$sql = "SELECT * FROM customer WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $email);
$stmt->execute();
if ($stmt->rowCount() > 0) {
    echo json_encode(["status" => "error", "message" => "Email already exists."]);
    exit();
}

// Hash the password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Insert user data into database
$sql = "INSERT INTO customer (name, email, password_hash, address, phone_number) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $name);
$stmt->bindParam(2, $email);
$stmt->bindParam(3, $password_hash);
$stmt->bindParam(4, $address);
$stmt->bindParam(5, $phoneNumber);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "User registered successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Error: " . $stmt->errorInfo()[2]]);
}

$conn = null;
?>

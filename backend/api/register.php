<?php
// Add these headers at the very top of your PHP file
header("Access-Control-Allow-Origin: http://localhost:5173"); // Replace with your frontend URL
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Accept");
header("Access-Control-Max-Age: 3600");
header("Content-Type: application/json");

// Handle OPTIONS request for CORS preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Database connection
$host = 'localhost';
$db = 'green-phil_db';
$user = 'root'; // replace with your database username
$pass = ''; // replace with your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Get the JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate input
$requiredFields = ['name', 'email', 'password', 'address', 'phoneNumber'];
foreach ($requiredFields as $field) {
    if (empty($data[$field])) {
        echo json_encode(['status' => 'error', 'message' => ucfirst($field) . ' is required.']);
        exit;
    }
}

// Hash the password
$passwordHash = password_hash($data['password'], PASSWORD_BCRYPT);

// Prepare SQL statement
$sql = "INSERT INTO customer (name, email, password_hash, address, phone_number) VALUES (?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);

try {
    // Execute the statement
    $stmt->execute([$data['name'], $data['email'], $passwordHash, $data['address'], $data['phoneNumber']]);
    echo json_encode(['status' => 'success', 'message' => 'Registration successful!']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Registration failed: ' . $e->getMessage()]);
}
?>

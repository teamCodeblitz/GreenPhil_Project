<?php
// config/database.php

$host = "localhost";
$db_name = "green-phil";
$username = "root";
$password = "";

function getDbConnection() {
    global $host, $db_name, $username, $password;

    try {
        // Using PDO for the database connection
        $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

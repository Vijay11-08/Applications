<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'furniture_db';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Global configurations
define('APP_NAME', 'Luxura Furniture');
define('CURRENCY', '$');

session_start();
?>

<?php
// Admin password reset utility — DELETE THIS FILE AFTER USE
require 'includes/db.php';

$new_password = 'admin123';
$hash = password_hash($new_password, PASSWORD_DEFAULT);

$conn->query("UPDATE users SET password='$hash', role='admin' WHERE email='admin@example.com'");

if($conn->affected_rows > 0) {
    echo "<h2 style='font-family:sans-serif; color:green; text-align:center; margin-top:100px;'>✅ Admin password reset to <strong>admin123</strong></h2>";
    echo "<p style='text-align:center; font-family:sans-serif;'><a href='login.php'>Go to Login →</a></p>";
} else {
    // Maybe user doesn't exist — create them
    $conn->query("INSERT INTO users (name, email, password, role) VALUES ('Admin User', 'admin@example.com', '$hash', 'admin')");
    echo "<h2 style='font-family:sans-serif; color:blue; text-align:center; margin-top:100px;'>✅ Admin account created. Password: <strong>admin123</strong></h2>";
    echo "<p style='text-align:center; font-family:sans-serif;'><a href='login.php'>Go to Login →</a></p>";
}
?>

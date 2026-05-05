<?php
include 'includes/db.php';

if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $product_id = (int)$_POST['product_id'];
    $action = $_POST['action'] ?? 'add';

    if($action == 'add') {
        // Check if item already in cart
        $check = $conn->query("SELECT id, quantity FROM cart WHERE user_id = $user_id AND product_id = $product_id");
        if($check->num_rows > 0) {
            $conn->query("UPDATE cart SET quantity = quantity + 1 WHERE user_id = $user_id AND product_id = $product_id");
        } else {
            $conn->query("INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, 1)");
        }
    } elseif($action == 'remove') {
        $conn->query("DELETE FROM cart WHERE user_id = $user_id AND product_id = $product_id");
    } elseif($action == 'update') {
        $qty = (int)$_POST['quantity'];
        if($qty > 0) {
            $conn->query("UPDATE cart SET quantity = $qty WHERE user_id = $user_id AND product_id = $product_id");
        } else {
            $conn->query("DELETE FROM cart WHERE user_id = $user_id AND product_id = $product_id");
        }
    }
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>

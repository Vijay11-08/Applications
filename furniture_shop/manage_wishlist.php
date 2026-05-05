<?php
include 'includes/db.php';

if(!isset($_SESSION['user_id'])) {
    header('Location: login.php'); exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id    = (int)$_SESSION['user_id'];
    $product_id = (int)$_POST['product_id'];

    $check = $conn->query("SELECT id FROM wishlist WHERE user_id=$user_id AND product_id=$product_id");
    if($check->num_rows > 0) {
        $conn->query("DELETE FROM wishlist WHERE user_id=$user_id AND product_id=$product_id");
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'wishlist.php';
        // If removing from wishlist page itself, add ?removed=1
        if(strpos($redirect, 'wishlist.php') !== false) {
            header('Location: wishlist.php?removed=1');
        } else {
            header('Location: ' . $redirect);
        }
    } else {
        $conn->query("INSERT INTO wishlist (user_id, product_id) VALUES ($user_id, $product_id)");
        header('Location: wishlist.php?added=1');
    }
    exit;
}

header('Location: shop.php');
exit;
?>

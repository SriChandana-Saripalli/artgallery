<?php
session_start();
include 'includes/db_connect.php';

header('Content-Type: application/json');

if (isset($_POST['artwork_id'])) {
    $artwork_id = intval($_POST['artwork_id']);
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $_SESSION['cart'][$artwork_id] = ($_SESSION['cart'][$artwork_id] ?? 0) + 1;

    // Count total items in cart
    $cart_count = 0;
    foreach ($_SESSION['cart'] as $qty) {
        $cart_count += $qty;
    }

    echo json_encode(['success' => true, 'cart_count' => $cart_count]);
    exit();
}

echo json_encode(['success' => false]);
exit();
?>

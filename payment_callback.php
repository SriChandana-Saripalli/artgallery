<?php
session_start();
include 'includes/db_connect.php';

if (!isset($_SESSION['order_id'])) {
    header("Location: shop.php");
    exit();
}

$order_id = $_SESSION['order_id'];
$status = ($_POST['payment_status'] === 'success') ? 'paid' : 'failed';

// Update order status
$conn->query("UPDATE orders SET status='$status' WHERE id=$order_id");

// Clear session
unset($_SESSION['order_id']);
unset($_SESSION['total_price']);
unset($_SESSION['cart']);

include 'includes/header.php';
?>

<div class="container mt-5">
    <?php if ($status === 'paid'): ?>
        <div class="alert alert-success">🎉 Payment Successful! Your order has been placed.</div>
        <a href="shop.php" class="btn btn-primary">🛍️ Continue Shopping</a>
    <?php else: ?>
        <div class="alert alert-danger">❌ Payment Failed! Please try again.</div>
        <a href="checkout.php" class="btn btn-warning">🔄 Retry Checkout</a>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>

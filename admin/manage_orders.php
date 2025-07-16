<?php
include '../includes/db_connect.php';
include '../includes/functions.php';
session_start();
admin_only();

// Change order status
if (isset($_GET['ship'])) {
    $order_id = intval($_GET['ship']);
    $conn->query("UPDATE orders SET status='shipped' WHERE id=$order_id");
}
if (isset($_GET['deliver'])) {
    $order_id = intval($_GET['deliver']);
    $conn->query("UPDATE orders SET status='delivered' WHERE id=$order_id");
}

// Fetch all orders
$result = $conn->query("SELECT o.*, u.name as customer_name FROM orders o 
                        JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC");
?>

<?php include '../includes/header.php'; ?>
<div class="container mt-5">
    <h2>Manage Orders</h2>
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Placed On</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['customer_name'] ?></td>
                <td>$<?= $row['total_price'] ?></td>
                <td><?= ucfirst($row['status']) ?></td>
                <td><?= $row['created_at'] ?></td>
                <td>
                    <?php if ($row['status'] == 'pending'): ?>
                        <a href="?ship=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Ship</a>
                    <?php elseif ($row['status'] == 'shipped'): ?>
                        <a href="?deliver=<?= $row['id'] ?>" class="btn btn-success btn-sm">Deliver</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include '../includes/footer.php'; ?>

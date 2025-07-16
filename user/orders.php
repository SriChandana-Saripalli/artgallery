<?php
include '../includes/db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$orders = $conn->query("SELECT * FROM orders WHERE user_id=$user_id ORDER BY created_at DESC");
?>

<?php include '../includes/header.php'; ?>

<style>
    body {
        background: #f5f7fa;
    }

    .order-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        margin-bottom: 25px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
    }

    .order-details {
        flex: 2;
        padding: 20px;
    }

    .order-details h5 {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .order-details p {
        margin-bottom: 6px;
        color: #555;
    }

    .order-image {
        flex: 1;
        max-width: 200px;
        height: 150px;
        overflow: hidden;
    }

    .order-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-left: 1px solid #e5e5e5;
    }

    .no-orders {
        text-align: center;
        color: #888;
        font-size: 1.2rem;
        margin-top: 50px;
    }

    footer {
        margin-top: auto;
    }
</style>

<main class="d-flex flex-column min-vh-100">
    <div class="container my-5 flex-grow-1">
        <h2 class="text-center mb-4">🛒 My Orders</h2>

        <?php if ($orders->num_rows > 0): ?>
            <?php while ($order = $orders->fetch_assoc()): ?>
                <?php
                // Fetch the first artwork image for preview
                $order_id = $order['id'];
                $item = $conn->query("
                    SELECT a.title, a.image
                    FROM order_items oi
                    JOIN artworks a ON oi.artwork_id = a.id
                    WHERE oi.order_id = $order_id
                    LIMIT 1
                ")->fetch_assoc();

                // Count total artworks in this order
                $total_items = $conn->query("SELECT COUNT(*) as total FROM order_items WHERE order_id = $order_id")
                                    ->fetch_assoc()['total'];
                ?>
                <div class="order-card">
                    <!-- Left: Order Details -->
                    <div class="order-details">
                        <h5>Order #<?= htmlspecialchars($order['id']) ?></h5>
                        <p><strong>Total Price:</strong> $<?= number_format($order['total_price'], 2) ?></p>
                        <p><strong>Status:</strong> <?= ucfirst(htmlspecialchars($order['status'])) ?></p>
                        <p><strong>Placed On:</strong> <?= htmlspecialchars($order['created_at']) ?></p>
                        <p><strong>Items:</strong> <?= $total_items ?></p>
                    </div>

                    <!-- Right: Artwork Image -->
                    <div class="order-image">
                        <?php if ($item): ?>
                            <img src="../uploads/<?= htmlspecialchars($item['image']) ?>" 
                                 alt="<?= htmlspecialchars($item['title']) ?>">
                        <?php else: ?>
                            <img src="../uploads/default.png" alt="No Image">
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="no-orders">You have no orders yet.</p>
        <?php endif; ?>
    </div>
</main>

<?php include '../includes/footer.php'; ?>

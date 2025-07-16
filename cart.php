<?php
include 'includes/db_connect.php';
include 'includes/header.php';

// ✅ Add to cart (from product page)
if (isset($_POST['add_to_cart'])) {
    $artwork_id = intval($_POST['artwork_id']);
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    $_SESSION['cart'][$artwork_id] = ($_SESSION['cart'][$artwork_id] ?? 0) + 1;
    header("Location: cart.php");
    exit();
}

// ✅ Increase quantity
if (isset($_GET['increase'])) {
    $artwork_id = intval($_GET['increase']);
    if (isset($_SESSION['cart'][$artwork_id])) {
        $_SESSION['cart'][$artwork_id]++;
    }
    header("Location: cart.php");
    exit();
}

// ✅ Decrease quantity
if (isset($_GET['decrease'])) {
    $artwork_id = intval($_GET['decrease']);
    if (isset($_SESSION['cart'][$artwork_id])) {
        $_SESSION['cart'][$artwork_id]--;
        if ($_SESSION['cart'][$artwork_id] <= 0) {
            unset($_SESSION['cart'][$artwork_id]);
        }
    }
    header("Location: cart.php");
    exit();
}

// ✅ Remove item
if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    header("Location: cart.php");
    exit();
}
?>

<style>
    .cart-container {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        padding: 30px;
        max-width: 1000px;
        margin: 50px auto;
    }

    .cart-header {
        border-bottom: 2px solid #eee;
        margin-bottom: 20px;
        padding-bottom: 10px;
        text-align: center;
    }

    .cart-header h2 {
        font-weight: 600;
        color: #333;
    }

    .table th, .table td {
        vertical-align: middle;
    }

    .quantity-control a {
        width: 32px;
        height: 32px;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        font-size: 20px;
        border-radius: 50%;
    }

    .btn-success {
        border-radius: 30px;
        padding: 10px 25px;
    }

    .total-amount {
        text-align: right;
        font-size: 1.5rem;
        font-weight: bold;
        color: #28a745;
        margin-top: 15px;
    }

    .alert-info {
        border-radius: 12px;
    }
</style>

<main class="flex-grow-1">
    <div class="cart-container">
        <div class="cart-header">
            <h2>Your Shopping Cart 🛒</h2>
        </div>
        <?php if (!empty($_SESSION['cart'])): ?>
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Artwork</th>
                    <th class="text-center">Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $total = 0;
            foreach ($_SESSION['cart'] as $id => $qty):
                $result = $conn->query("SELECT * FROM artworks WHERE id=$id");
                $artwork = $result->fetch_assoc();
                $subtotal = $artwork['price'] * $qty;
                $total += $subtotal;
            ?>
                <tr>
                    <td><strong><?= htmlspecialchars($artwork['title']) ?></strong></td>
                    <td class="text-center">
                        <div class="quantity-control d-flex justify-content-center align-items-center">
                            <a href="?decrease=<?= $id ?>" class="btn btn-outline-secondary btn-sm me-1">–</a>
                            <span class="mx-2"><?= $qty ?></span>
                            <a href="?increase=<?= $id ?>" class="btn btn-outline-secondary btn-sm ms-1">+</a>
                        </div>
                    </td>
                    <td>$<?= number_format($artwork['price'], 2) ?></td>
                    <td>$<?= number_format($subtotal, 2) ?></td>
                    <td class="text-center">
                        <a href="?remove=<?= $id ?>" class="btn btn-outline-danger btn-sm">Remove</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="total-amount">Total: $<?= number_format($total, 2) ?></div>
        <div class="text-end mt-3">
            <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
        </div>
        <?php else: ?>
        <div class="alert alert-info text-center">Your cart is empty.</div>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

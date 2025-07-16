<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'includes/db_connect.php';

// ✅ Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: user/login.php");
    exit();
}

include 'includes/header.php';

$success = "";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_address'])) {
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        $success = "Your cart is empty. Please add items before checkout.";
    } else {
        // Get and validate user input
        $fullname = trim($_POST['fullname']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $address = trim($_POST['address']);
        $city = trim($_POST['city']);
        $zipcode = trim($_POST['zipcode']);

        if (empty($fullname)) $errors[] = "Full Name is required.";
        if (empty($email)) $errors[] = "Email is required.";
        if (empty($phone)) $errors[] = "Phone Number is required.";
        if (empty($address)) $errors[] = "Address is required.";
        if (empty($city)) $errors[] = "City is required.";
        if (empty($zipcode)) $errors[] = "Zip Code is required.";

        if (empty($errors)) {
            $user_id = intval($_SESSION['user_id']);
            $total_price = 0;
            $cart = $_SESSION['cart'];

            // Calculate total price and validate items
            $artworks = [];
            foreach ($cart as $id => $qty) {
                $id = intval($id);
                $qty = intval($qty);
                $result = $conn->query("SELECT * FROM artworks WHERE id = $id");
                if ($result && $result->num_rows > 0) {
                    $artwork = $result->fetch_assoc();
                    $artworks[] = ['id' => $id, 'qty' => $qty, 'price' => $artwork['price']];
                    $total_price += $artwork['price'] * $qty;
                }
            }

            // Insert order
            $stmt = $conn->prepare("INSERT INTO orders (user_id, fullname, email, phone, address, city, zipcode, total_price, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())");
            $stmt->bind_param("issssssd", $user_id, $fullname, $email, $phone, $address, $city, $zipcode, $total_price);
            $stmt->execute();
            $order_id = $stmt->insert_id;

            // Insert order items
            foreach ($artworks as $item) {
                $stmt = $conn->prepare("INSERT INTO order_items (order_id, artwork_id, quantity, price) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("iiid", $order_id, $item['id'], $item['qty'], $item['price']);
                $stmt->execute();
            }

            // Store order_id in session for payment
            $_SESSION['order_id'] = $order_id;
            $_SESSION['total_price'] = $total_price;

            // ✅ Redirect to payment page
            header("Location: payment.php");
            exit();
        }
    }
}
?>

<style>
    html, body {
        height: 100%;
        margin: 0;
    }

    main {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: calc(100vh - 80px); /* Adjust for header/footer height */
        padding: 20px;
    }

    .checkout-container {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        padding: 30px;
        max-width: 600px;
        width: 100%;
    }

    .checkout-header h2 {
        font-weight: 700;
        color: #343a40;
        margin-bottom: 20px;
        text-align: center;
    }

    .form-control {
        border-radius: 8px;
    }

    .btn-success {
        border-radius: 30px;
        padding: 10px 25px;
        width: 100%;
    }

    .alert {
        border-radius: 12px;
        margin-bottom: 15px;
    }
</style>

<main>
    <div class="checkout-container">
        <div class="checkout-header">
            <h2>🧾 Checkout</h2>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-warning"><?= $success ?></div>
            <a href="shop.php" class="btn btn-primary">🛍️ Continue Shopping</a>
        <?php elseif (!isset($_SESSION['cart']) || empty($_SESSION['cart'])): ?>
            <div class="alert alert-warning">Your cart is empty. Please <a href="shop.php">shop artworks</a> first.</div>
        <?php else: ?>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="fullname" class="form-label">Full Name</label>
                    <input type="text" class="form-control" name="fullname" id="fullname" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" name="phone" id="phone" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" name="address" id="address" rows="2" required></textarea>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" name="city" id="city" required>
                    </div>
                    <div class="col">
                        <label for="zipcode" class="form-label">Zip Code</label>
                        <input type="text" class="form-control" name="zipcode" id="zipcode" required>
                    </div>
                </div>
                <button type="submit" name="submit_address" class="btn btn-success">💳 Proceed to Payment</button>
            </form>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

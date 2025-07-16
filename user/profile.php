<?php
include '../includes/db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user = $conn->query("SELECT * FROM users WHERE id=$user_id")->fetch_assoc();
?>

<?php include '../includes/header.php'; ?>

<main class="d-flex flex-column min-vh-100">
    <div class="container my-5 flex-grow-1">
        <div class="shadow rounded p-4 bg-light" style="max-width: 600px; margin: 0 auto;">
            <h2 class="mb-4 text-center">Welcome, <?= htmlspecialchars($user['name']) ?>!</h2>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
            <p><strong>Role:</strong> <?= ucfirst(htmlspecialchars($user['role'])) ?></p>
            <div class="mt-4 d-flex justify-content-between">
                <a href="orders.php" class="btn btn-info">View My Orders</a>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>

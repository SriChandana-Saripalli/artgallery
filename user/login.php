<?php
include '../includes/db_connect.php';
include '../includes/functions.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    $role = sanitize($_POST['role']); // Role selected by user

    if ($role === 'user' || $role === 'artist') {
        // Check users table
        $sql = "SELECT * FROM users WHERE email='$email' AND role='$role' AND status='active'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['role'] = $row['role'];

                // Redirect User or Artist
                if ($role === 'user') {
                    header("Location: ../index.php"); // Buyer's dashboard
                } else {
                    header("Location: ../artist/dashboard.php"); // Artist's dashboard
                }
                exit();
            } else {
                $error = "Invalid email or password!";
            }
        } else {
            $error = "Account not found or blocked!";
        }
    } elseif ($role === 'admin') {
        // Hardcoded admin credentials
        $admin_email = "admin@artgallery.com";
        $admin_password = "admin";

        if ($email === $admin_email && $password === $admin_password) {
            $_SESSION['admin_id'] = 1; // Dummy ID
            $_SESSION['admin_name'] = "Admin Master";
            $_SESSION['role'] = "admin";

            header("Location: ../admin/dashboard.php"); // Admin dashboard
            exit();
        } else {
            $error = "Invalid admin credentials!";
        }
    } else {
        $error = "Please select a valid role!";
    }
}
?>

<?php include '../includes/header.php'; ?>
<main class="d-flex flex-column min-vh-100">
    <div class="container my-5 flex-grow-1 d-flex justify-content-center align-items-center">
        <div class="card shadow-lg p-4" style="width: 400px;">
            <h2 class="mb-4 text-center">Login</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required placeholder="Enter your email">
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required placeholder="Enter your password">
                </div>
                <div class="mb-3">
                    <label>Select Role</label>
                    <select name="role" class="form-control" required>
                        <option value="">-- Select Role --</option>
                        <option value="user">User</option>
                        <option value="artist">Artist</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button class="btn btn-primary w-100">Login</button>
            </form>
            <div class="mt-3 text-center">
                <p>Don’t have an account? <a href="register.php">Register here</a></p>
            </div>
        </div>
    </div>
</main>
<?php include '../includes/footer.php'; ?>

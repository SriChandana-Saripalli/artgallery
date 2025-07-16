<?php
include '../includes/db_connect.php';
include '../includes/functions.php'; // ✅ Add this line
session_start();



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = sanitize($_POST['role']); // user or artist

    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if email exists
        $check = $conn->query("SELECT * FROM users WHERE email='$email'");
        if ($check->num_rows > 0) {
            $error = "Email already registered!";
        } else {
            $sql = "INSERT INTO users (name, email, password, role, status) 
                    VALUES ('$name', '$email', '$hashed_password', '$role', 'active')";
            if ($conn->query($sql)) {
                $_SESSION['user_id'] = $conn->insert_id;
                $_SESSION['name'] = $name;
                $_SESSION['role'] = $role;
                header("Location: profile.php");
                exit();
            } else {
                $error = "Error: " . $conn->error;
            }
        }
    }
}
?>

<?php include '../includes/header.php'; ?>
<main class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
    <div class="shadow rounded p-5 bg-white" style="max-width: 600px; width: 100%;">
        <h2 class="text-center mb-4">Register</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" onsubmit="return validateForm()">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" id="password" class="form-control" required minlength="6">
                <small class="text-muted">Password must be at least 6 characters.</small>
            </div>
            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="user">Buyer</option>
                    <option value="artist">Artist</option>
                </select>
            </div>
            <button class="btn btn-primary w-100">Register</button>
        </form>

        <p class="text-center mt-3">
            Already have an account? <a href="login.php">Login here</a>.
        </p>
    </div>
</main>
<?php include '../includes/footer.php'; ?>

<script>
// Client-side validation for password match
function validateForm() {
    let pw = document.getElementById('password').value;
    let cpw = document.getElementById('confirm_password').value;
    if (pw !== cpw) {
        alert("Passwords do not match!");
        return false;
    }
    return true;
}
</script>

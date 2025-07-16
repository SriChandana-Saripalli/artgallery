<?php
include '../includes/db_connect.php';
include '../includes/functions.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


artist_only();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize($_POST['title']);
    $price = floatval($_POST['price']);
    $description = sanitize($_POST['description']);
    $category = sanitize($_POST['category']);
    $artist_id = $_SESSION['user_id'];

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Ensure folder exists
        }
        $image_name = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Allow only certain file types
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowed_types)) {
            $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        } elseif ($_FILES["image"]["size"] > 2 * 1024 * 1024) {
            $error = "File size should not exceed 2MB.";
        } elseif (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Prepared statement to insert data
            $stmt = $conn->prepare("INSERT INTO artworks 
                (artist_id, title, description, price, category, image, status, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW())");
            $stmt->bind_param("issdss", $artist_id, $title, $description, $price, $category, $image_name);

            if ($stmt->execute()) {
                $success = "✅ Artwork submitted for approval!";
            } else {
                $error = "❌ Failed to save artwork in database.";
            }
            $stmt->close();
        } else {
            $error = "❌ Failed to upload image. Check folder permissions.";
        }
    } else {
        $error = "⚠️ Please select an image.";
    }
}
?>

<?php include '../includes/artist_header.php'; ?>
<div class="container my-5 flex-grow-1">
    <h2>📤 Upload Artwork</h2>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="shadow p-4 rounded bg-light">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Price (USD)</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label>Category</label>
            <input type="text" name="category" class="form-control" placeholder="e.g. Painting, Sculpture" required>
        </div>
        <div class="mb-3">
            <label>Upload Image</label>
            <input type="file" name="image" class="form-control" accept="image/*" required>
        </div>
        <button class="btn btn-primary">Submit Artwork</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>

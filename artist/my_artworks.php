<?php
include '../includes/db_connect.php';
include '../includes/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

artist_only();

$artist_id = $_SESSION['user_id'];

// Handle Delete
if (isset($_GET['delete'])) {
    $art_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM artworks WHERE id=? AND artist_id=?");
    $stmt->bind_param("ii", $art_id, $artist_id);
    $stmt->execute();
    $stmt->close();
    header("Location: my_artworks.php");
    exit();
}

// Fetch all artworks uploaded by this artist
$result = $conn->query("SELECT * FROM artworks WHERE artist_id=$artist_id ORDER BY created_at DESC");
?>

<?php include '../includes/artist_header.php'; ?>
<div class="container my-5 flex-grow-1">
    <h2 class="mb-4">🖼 My Artworks</h2>

    <a href="upload_artwork.php" class="btn btn-primary mb-3">📤 Upload New Artwork</a>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Price</th>
                <th>Status</th>
                <th>Created On</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><img src="../uploads/<?= htmlspecialchars($row['image']) ?>" width="80" class="rounded"></td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td>$<?= number_format($row['price'], 2) ?></td>
                    <td><?= ucfirst($row['status']) ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                        <a href="edit_artwork.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">✏️ Edit</a>
                        <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this artwork?');" class="btn btn-danger btn-sm">🗑 Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No artworks uploaded yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php include '../includes/footer.php'; ?>

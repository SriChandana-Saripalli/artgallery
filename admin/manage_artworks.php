<?php
include '../includes/db_connect.php';
include '../includes/functions.php';
session_start();
admin_only();

// Approve Artwork
if (isset($_GET['approve'])) {
    $art_id = intval($_GET['approve']);
    $conn->query("UPDATE artworks SET status='approved' WHERE id=$art_id");
    header("Location: manage_artworks.php");
    exit();
}

// Reject Artwork
if (isset($_GET['reject'])) {
    $art_id = intval($_GET['reject']);
    $conn->query("UPDATE artworks SET status='rejected' WHERE id=$art_id");
    header("Location: manage_artworks.php");
    exit();
}

// Delete Artwork
if (isset($_GET['delete'])) {
    $art_id = intval($_GET['delete']);
    $conn->query("DELETE FROM artworks WHERE id=$art_id");
    header("Location: manage_artworks.php");
    exit();
}

// Fetch all artworks
$result = $conn->query("SELECT a.*, u.name AS artist_name FROM artworks a JOIN users u ON a.artist_id=u.id ORDER BY a.created_at DESC");
?>

<?php include '../includes/header.php'; ?>
<div class="container mt-5">
    <h2 class="mb-4">Manage Artworks</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Title</th>
                <th>Price</th>
                <th>Artist</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><img src="../uploads/<?= $row['image'] ?>" width="80"></td>
                <td><?= $row['title'] ?></td>
                <td>$<?= $row['price'] ?></td>
                <td><?= $row['artist_name'] ?></td>
                <td><?= ucfirst($row['status']) ?></td>
                <td>
                    <?php if ($row['status'] == 'pending'): ?>
                        <a href="?approve=<?= $row['id'] ?>" class="btn btn-success btn-sm">Approve</a>
                        <a href="?reject=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Reject</a>
                    <?php endif; ?>
                    <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this artwork?');" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include '../includes/footer.php'; ?>

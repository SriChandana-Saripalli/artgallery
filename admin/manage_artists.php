<?php
include '../includes/db_connect.php';
include '../includes/functions.php';
session_start();
admin_only();

// Approve Artist
if (isset($_GET['approve'])) {
    $artist_id = intval($_GET['approve']);
    $conn->query("UPDATE users SET status='active' WHERE id=$artist_id");
    header("Location: manage_artists.php");
    exit();
}

// Block Artist
if (isset($_GET['block'])) {
    $artist_id = intval($_GET['block']);
    $conn->query("UPDATE users SET status='blocked' WHERE id=$artist_id");
    header("Location: manage_artists.php");
    exit();
}

// Fetch artists
$result = $conn->query("SELECT * FROM users WHERE role='artist'");
?>

<?php include '../includes/header.php'; ?>
<div class="container mt-5">
    <h2 class="mb-4">Manage Artists</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= ucfirst($row['status']) ?></td>
                <td>
                    <?php if ($row['status'] == 'pending'): ?>
                        <a href="?approve=<?= $row['id'] ?>" class="btn btn-success btn-sm">Approve</a>
                    <?php elseif ($row['status'] == 'active'): ?>
                        <a href="?block=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Block</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include '../includes/footer.php'; ?>

<?php
include '../includes/db_connect.php';
include '../includes/functions.php';
session_start();

// Allow only artists
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'artist') {
    header("Location: ../user/login.php");
    exit();
}

// Fetch artist's artworks
$artist_id = $_SESSION['user_id'];
$my_artworks = $conn->query("SELECT * FROM artworks WHERE artist_id = $artist_id ORDER BY created_at DESC");
?>

<?php include '../includes/artist_header.php'; ?>

<main class="d-flex flex-column min-vh-100"> <!-- Make main stretch full height -->
    <div class="container my-5 flex-grow-1">
        <h2>Welcome, <?= htmlspecialchars($_SESSION['name']) ?> (Artist)</h2>
        <a href="../user/logout.php" class="btn btn-danger float-end">Logout</a>
        <p class="lead">Here’s your dashboard overview:</p>

        <h4>🎨 Your Artworks</h4>
        <?php if ($my_artworks->num_rows > 0): ?>
        <table class="table table-hover mt-3 align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $my_artworks->fetch_assoc()): ?>
                <tr>
                    <td>
                        <img src="../uploads/<?= htmlspecialchars($row['image']) ?>" 
                             alt="<?= htmlspecialchars($row['title']) ?>" 
                             class="img-thumbnail" 
                             style="height: 70px; width: auto;">
                    </td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td>$<?= number_format($row['price'], 2) ?></td>
                    <td><?= ucfirst($row['status']) ?></td>
                    <td><?= date("d M Y", strtotime($row['created_at'])) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p class="text-muted">No artworks uploaded yet.</p>
        <?php endif; ?>
    </div>

    <?php include '../includes/footer.php'; ?>
</main>

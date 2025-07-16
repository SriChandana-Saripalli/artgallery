<?php
include '../includes/db_connect.php';
include '../includes/functions.php';
session_start();
admin_only();

// ✅ Handle status update
if (isset($_GET['approve_artwork'])) {
    $artwork_id = intval($_GET['approve_artwork']); // Sanitize input
    $conn->query("UPDATE artworks SET status='approved' WHERE id=$artwork_id");
    header("Location: dashboard.php?artworks_page={$_GET['artworks_page']}&orders_page={$_GET['orders_page']}&artists_page={$_GET['artists_page']}");
    exit;
}

// ✅ Pagination setup
$limit = 5; // Records per page

// Safely get current pages for each table
$artworks_page = (isset($_GET['artworks_page']) && (int)$_GET['artworks_page'] > 0) ? (int)$_GET['artworks_page'] : 1;
$orders_page   = (isset($_GET['orders_page']) && (int)$_GET['orders_page'] > 0) ? (int)$_GET['orders_page'] : 1;
$artists_page  = (isset($_GET['artists_page']) && (int)$_GET['artists_page'] > 0) ? (int)$_GET['artists_page'] : 1;

// Calculate offsets
$artworks_offset = ($artworks_page - 1) * $limit;
$orders_offset   = ($orders_page - 1) * $limit;
$artists_offset  = ($artists_page - 1) * $limit;

// ✅ Fetch total records
$total_artworks = $conn->query("SELECT COUNT(*) as total FROM artworks")->fetch_assoc()['total'];
$total_orders   = $conn->query("SELECT COUNT(*) as total FROM orders")->fetch_assoc()['total'];
$total_artists  = $conn->query("SELECT COUNT(*) as total FROM users WHERE role='artist' AND status='active'")->fetch_assoc()['total'];

// ✅ Fetch paginated data
$artworks = $conn->query("SELECT id, title, price, status FROM artworks ORDER BY created_at DESC LIMIT $limit OFFSET $artworks_offset");
$orders   = $conn->query("SELECT total_price, status, created_at FROM orders ORDER BY created_at DESC LIMIT $limit OFFSET $orders_offset");
$artists  = $conn->query("SELECT name, email FROM users WHERE role='artist' AND status='active' ORDER BY id DESC LIMIT $limit OFFSET $artists_offset");

// ✅ Calculate total pages
$artworks_total_pages = ceil($total_artworks / $limit);
$orders_total_pages   = ceil($total_orders / $limit);
$artists_total_pages  = ceil($total_artists / $limit);
?>

<?php include '../includes/admin_header.php'; ?>

<main class="d-flex flex-column min-vh-100">
    <div class="container my-5 flex-grow-1">
        <h2 class="mb-4 fw-bold">📊 Dashboard Overview</h2>

        <!-- ✅ Artworks Table -->
        <div class="card shadow-sm rounded mb-4">
            <div class="card-header bg-primary text-white fw-semibold">🎨 Artworks</div>
            <div class="card-body">
                <table class="table table-hover table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Status / Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $artworks->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td class="text-success fw-semibold">$<?= number_format($row['price'], 2) ?></td>
                            <td>
                                <?php if ($row['status'] === 'pending'): ?>
                                    <a href="?approve_artwork=<?= $row['id'] ?>&artworks_page=<?= $artworks_page ?>&orders_page=<?= $orders_page ?>&artists_page=<?= $artists_page ?>" 
                                       class="btn btn-danger btn-sm rounded-pill"
                                       onclick="return confirm('Approve this artwork?');">
                                       🟥 Approve
                                    </a>
                                <?php else: ?>
                                    <span class="badge bg-success">✅ Approved</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <!-- Artworks Pagination -->
                <?php if ($artworks_total_pages > 1): ?>
                    <nav>
                        <ul class="pagination justify-content-center">
                            <?php for ($i = 1; $i <= $artworks_total_pages; $i++): ?>
                                <li class="page-item <?= ($i == $artworks_page) ? 'active' : '' ?>">
                                    <a class="page-link" href="?artworks_page=<?= $i ?>&orders_page=<?= $orders_page ?>&artists_page=<?= $artists_page ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>

        <!-- ✅ Orders Table -->
        <div class="card shadow-sm rounded mb-4">
            <div class="card-header bg-success text-white fw-semibold">🛒 Orders</div>
            <div class="card-body">
                <table class="table table-hover table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Placed On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $orders->fetch_assoc()): ?>
                        <tr>
                            <td>$<?= number_format($row['total_price'], 2) ?></td>
                            <td><?= ucfirst($row['status']) ?></td>
                            <td><?= date("d M Y", strtotime($row['created_at'])) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <!-- Orders Pagination -->
                <?php if ($orders_total_pages > 1): ?>
                    <nav>
                        <ul class="pagination justify-content-center">
                            <?php for ($i = 1; $i <= $orders_total_pages; $i++): ?>
                                <li class="page-item <?= ($i == $orders_page) ? 'active' : '' ?>">
                                    <a class="page-link" href="?artworks_page=<?= $artworks_page ?>&orders_page=<?= $i ?>&artists_page=<?= $artists_page ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>

        <!-- ✅ Artists Table -->
        <div class="card shadow-sm rounded mb-4">
            <div class="card-header bg-info text-white fw-semibold">👩‍🎨 Approved Artists</div>
            <div class="card-body">
                <table class="table table-hover table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $artists->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <!-- Artists Pagination -->
                <?php if ($artists_total_pages > 1): ?>
                    <nav>
                        <ul class="pagination justify-content-center">
                            <?php for ($i = 1; $i <= $artists_total_pages; $i++): ?>
                                <li class="page-item <?= ($i == $artists_page) ? 'active' : '' ?>">
                                    <a class="page-link" href="?artworks_page=<?= $artworks_page ?>&orders_page=<?= $orders_page ?>&artists_page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>

    </div>
</main>

<?php include '../includes/footer.php'; ?>

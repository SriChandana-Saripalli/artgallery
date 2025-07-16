<?php
include 'includes/db_connect.php';
include 'includes/header.php';

// Pagination setup
$limit = 6; // Artworks per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$total_result = $conn->query("SELECT COUNT(*) AS total FROM artworks WHERE status='approved'");
$total_artworks = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_artworks / $limit);

$result = $conn->query("SELECT * FROM artworks WHERE status='approved' ORDER BY created_at DESC LIMIT $limit OFFSET $offset");
?>

<!-- ✅ Custom Style for Artwork Cards -->
<style>
/* 🌸 Artwork card with *intense* lavender glow and animations */
.artwork-card {
    border: 2px solid #e6e6fa; /* Light lavender border */
    border-radius: 12px;
    overflow: hidden;
    transition: transform 0.4s ease, box-shadow 0.4s ease, border-color 0.4s ease;
}

.artwork-card:hover {
    transform: translateY(-20px) scale(1.1); /* Lift higher & scale more */
    /* 💜 Layered lavender shadows for stronger glow */
    box-shadow:
        0 0 40px 15px rgba(230, 230, 250, 0.9), /* Outer glow */
        0 0 80px 30px rgba(186, 85, 211, 0.7), /* Medium glow */
        0 0 120px 50px rgba(148, 0, 211, 0.5); /* Deep glow */
    border-color: #ba55d3; /* Deep lavender border */
    cursor: pointer;
}

.artwork-card img {
    transition: transform 0.5s ease;
}

.artwork-card:hover img {
    transform: scale(1.15); /* Zoom in image more */
}

/* 🪄 Fade-in animation for cards */
@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(40px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.artwork-card {
    animation: fadeInUp 0.6s ease forwards;
}
</style>

<!-- ✅ Wrap main content -->
<main class="main-content">
    <div class="container my-5">
        <!-- Welcome Section -->
        <div class="text-center mb-5">
            <h1 class="fw-bold">🎨 Welcome to Art Gallery</h1>
            <p class="lead">Discover and buy original artworks from talented artists.</p>
        </div>

        <!-- Featured Artworks -->
        <h2 class="mb-4 text-center">🌟 Featured Artworks</h2>
        <div class="row g-4">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4">
                    <!-- ✅ Entire card clickable -->
                    <a href="product.php?id=<?= $row['id'] ?>" style="text-decoration: none; color: inherit;">
                        <div class="card artwork-card h-100 shadow-sm">
                            <img src="uploads/<?= htmlspecialchars($row['image']) ?>" 
                                 class="card-img-top" 
                                 alt="<?= htmlspecialchars($row['title']) ?>" 
                                 style="height: 250px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
                                <p class="card-text text-muted mb-3">$<?= number_format($row['price'], 2) ?></p>
                                <div class="btn btn-outline-primary mt-auto">View Details</div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center">No artworks found.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <nav aria-label="Page navigation" class="mt-5">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

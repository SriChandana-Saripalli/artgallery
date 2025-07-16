<?php
include 'includes/db_connect.php';
include 'includes/header.php';

$id = intval($_GET['id']);
$result = $conn->query("SELECT a.*, u.name as artist_name FROM artworks a JOIN users u ON a.artist_id = u.id WHERE a.id=$id AND a.status='approved'");
$artwork = $result->fetch_assoc();
?>

<!-- ✅ Custom Style for Details Box and Image -->
<style>
/* 🌸 Artwork Details Box with lavender glow */
.artwork-details-box {
    border: 2px solid #e6e6fa; /* Light lavender border */
    border-radius: 12px;
    background: #fff;
    transition: transform 0.4s ease, box-shadow 0.4s ease, border-color 0.4s ease;
}

.artwork-details-box:hover {
    transform: translateY(-12px) scale(1.03); /* Slight lift and scale */
    box-shadow:
        0 0 30px 10px rgba(230, 230, 250, 0.9), /* Outer lavender glow */
        0 0 60px 20px rgba(186, 85, 211, 0.6); /* Deeper lavender glow */
    border-color: #ba55d3; /* Darker lavender border on hover */
    cursor: pointer;
}

/* 🌸 Artwork Image with lavender glow */
.artwork-image {
    border-radius: 8px;
    transition: transform 0.5s ease, box-shadow 0.5s ease;
}

.artwork-image:hover {
    transform: scale(1.05); /* Slight zoom */
    box-shadow:
        0 0 25px 10px rgba(230, 230, 250, 0.8), /* Soft lavender glow */
        0 0 50px 20px rgba(186, 85, 211, 0.5); /* Deeper lavender glow */
}

/* Smooth fade-in animation */
@keyframes fadeInZoom {
    0% {
        opacity: 0;
        transform: scale(0.95);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

.artwork-details-box {
    animation: fadeInZoom 0.6s ease forwards;
}
</style>

<main class="flex-grow-1 d-flex align-items-center">
    <div class="container my-5">
        <?php if ($artwork): ?>
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12">
                <div class="row g-4 align-items-center">
                    <!-- ✅ Artwork Image with hover glow -->
                    <div class="col-md-6 text-center">
                        <img src="uploads/<?= htmlspecialchars($artwork['image']) ?>" 
                             class="img-fluid artwork-image mx-auto d-block shadow-sm"
                             alt="<?= htmlspecialchars($artwork['title']) ?>"
                             style="max-height: 450px; width: auto; object-fit: cover;">
                    </div>

                    <!-- ✅ Artwork Details Box with hover glow -->
                    <div class="col-md-6">
                        <div class="artwork-details-box p-4 shadow-sm rounded">
                            <h2 class="mb-3"><?= htmlspecialchars($artwork['title']) ?></h2>
                            <p><strong>Artist:</strong> <?= htmlspecialchars($artwork['artist_name']) ?></p>
                            <p><strong>Price:</strong> <span class="text-success fw-bold">$<?= number_format($artwork['price'], 2) ?></span></p>

                            <!-- Bigger description box -->
                            <div class="artwork-description mt-4 mb-4" style="max-height: 300px; overflow-y: auto;">
                                <?= nl2br(htmlspecialchars($artwork['description'])) ?>
                            </div>

                            <form method="POST" action="cart.php">
                                <input type="hidden" name="artwork_id" value="<?= $artwork['id'] ?>">
                                <button class="btn btn-primary w-100" name="add_to_cart">🛒 Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="alert alert-danger">Artwork not found.</div>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

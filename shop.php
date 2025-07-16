<?php
include 'includes/db_connect.php';
include 'includes/header.php';

// Fetch all approved artworks
$result = $conn->query("SELECT * FROM artworks WHERE status='approved'");
?>

<style>
    body {
        background: #f8f9fa; /* subtle light background */
    }

    h2 {
        text-align: center;
        font-weight: 700;
        margin-bottom: 30px;
        color: #333;
    }

    .card {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        background: #fff;
    }

    .card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .card img {
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
    }

    .card-body {
        padding: 20px;
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
        text-align: center;
    }

    .card-text {
        font-size: 1.1rem;
        color: #16a085;
        text-align: center;
        margin-bottom: 15px;
        font-weight: 500;
    }

    .btn-outline-primary {
        display: block;
        margin: 0 auto;
        border-radius: 30px;
        padding: 8px 20px;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        background-color: #007bff;
        color: #fff;
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.4);
    }

    .main-content {
        padding-top: 50px;
        padding-bottom: 50px;
    }
</style>

<main class="main-content">
    <div class="container mt-5 flex-grow-1">
        <h2>🖼️ Shop Artworks</h2>
        <div class="row mt-4">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="uploads/<?= htmlspecialchars($row['image']) ?>" 
                        class="card-img-top" 
                        alt="<?= htmlspecialchars($row['title']) ?>" 
                        style="height: 250px; width: 100%; object-fit: cover;">

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
                            <p class="card-text">$<?= number_format($row['price'], 2) ?></p>
                            <a href="product.php?id=<?= $row['id'] ?>" class="btn btn-outline-primary btn-sm mt-auto">View</a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">No artworks available at the moment.</p>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

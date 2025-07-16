<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Artist Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Your custom styles -->
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">🎨 ArtGallery Artist</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#artistNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="artistNavbar">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="my_artworks.php">🖼 My Artworks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="upload_artwork.php">📤 Upload Artwork</a>
                </li>
                <li class="nav-item">
                    <span class="nav-link text-light">👤 <?= htmlspecialchars($_SESSION['name']) ?></span>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-light btn-sm" href="../user/logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ArtGallery Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .topbar {
            background: #343a40;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .topbar .project-name {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .topbar .admin-controls {
            display: flex;
            gap: 10px;
            align-items: center;
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
<header class="bg-dark text-white py-3">
    <div class="container d-flex justify-content-between align-items-center">
        <h4 class="mb-0">🎨 ArtGallery Admin</h4>
        <div>
            <span class="me-3">👤 <?= htmlspecialchars($_SESSION['admin_name']) ?></span>
            
            <a href="../user/logout.php" class="btn btn-sm btn-light">Logout</a>

        </div>
    </div>
</header>
 

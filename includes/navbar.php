<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/artgallery/index.php">🎨 Art Gallery</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="/artgallery/shop.php">Shop</a></li>
                <li class="nav-item"><a class="nav-link" href="/artgallery/about.php">About</a></li>
                <li class="nav-item"><a class="nav-link" href="/artgallery/contact.php">Contact</a></li>
                <?php if (!isset($_SESSION)) session_start(); ?>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a class="nav-link" href="/artgallery/user/profile.php">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="/artgallery/user/logout.php">Logout</a></li>
                <?php elseif(isset($_SESSION['admin_id'])): ?>
                    <li class="nav-item"><a class="nav-link" href="/artgallery/admin/dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="/artgallery/user/logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="/artgallery/user/login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="/artgallery/user/register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

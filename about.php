<?php include 'includes/header.php'; ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
        font-size: 1.05rem;
        line-height: 1.8;
        color: #333;
    }

    h1, h2 {
        font-weight: 700;
    }

    h1 {
        font-size: 2.8rem;
        color: #2c3e50;
    }

    h2 {
        font-size: 2rem;
        color: #34495e;
        margin-bottom: 1rem;
    }

    p {
        font-size: 1.1rem;
        color: #555;
    }

    .lead {
        font-size: 1.3rem;
        color: #666;
        font-weight: 500;
    }

    ul li {
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }

    .rounded {
        border-radius: 10px;
    }

    .shadow {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    /* ✅ Reduce first image size */
    .about-image-small {
        max-width: 80%; /* Scale down image width */
        margin: 0 auto; /* Center image */
        display: block;
    }
</style>

<main class="flex-grow-1">
    <div class="container mt-5">
        <div class="text-center mb-5">
            <h1 class="display-4">About Us</h1>
            <p class="lead">Celebrating creativity and connecting art lovers worldwide.</p>
        </div>

        <div class="row align-items-center mb-5">
            <div class="col-md-6 mb-4 mb-md-0">
                <!-- ✅ Added custom class for smaller size -->
                <img src="assets/images/about-art-gallery.jpg" alt="About Art Gallery" class="img-fluid rounded shadow about-image-small">
            </div>
            <div class="col-md-6">
                <h2>Welcome to Art Gallery</h2>
                <p>
                    Art Gallery is more than just an online platform – it’s a vibrant community where creativity meets appreciation. We are dedicated to bridging the gap between talented artists and art enthusiasts from around the world.
                </p>
                <p>
                    <strong>Our mission</strong> is to make art accessible to all while empowering artists to share their passion and connect with a global audience. From stunning paintings and sculptures to digital masterpieces, our gallery celebrates every artistic style and medium.
                </p>
            </div>
        </div>

        <div class="row align-items-center mb-5">
            <div class="col-md-6 order-md-2 mb-4 mb-md-0">
                <img src="assets/images/artist-community.jpg" alt="Artist Community" class="img-fluid rounded shadow">
            </div>
            <div class="col-md-6 order-md-1">
                <h2>Why Choose Us?</h2>
                <ul class="list-unstyled">
                    <li>🎨 Handpicked, high-quality artworks</li>
                    <li>🛒 Secure and seamless buying experience</li>
                    <li>🌍 Worldwide shipping and customer support</li>
                    <li>⭐ Community events, workshops, and artist spotlights</li>
                </ul>
                <p>
                    At Art Gallery, we believe every piece of art has a story to tell – and we’re here to help you find yours.
                </p>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

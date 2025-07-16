<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Art Gallery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Your custom CSS -->
    <link href="/artgallery/assets/css/style.css" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
            font-family: 'Poppins', sans-serif;
            font-size: 1.05rem;
            line-height: 1.8;
            color: #333;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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
        main {
            flex: 1;
        }
        footer {
            margin-top: auto;
        }
    </style>
</head>
<body>
    <?php include $_SERVER['DOCUMENT_ROOT'].'/artgallery/includes/navbar.php'; ?>

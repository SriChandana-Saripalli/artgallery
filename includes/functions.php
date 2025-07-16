<?php

// Sanitize user input
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)), ENT_QUOTES, 'UTF-8');
}

// Check if user is admin
function is_admin() {
    return (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
}

// Check if user is artist
function is_artist() {
    return (isset($_SESSION['role']) && $_SESSION['role'] === 'artist');
}

// Redirect to login if not admin
function admin_only() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!is_admin()) {
        header("Location: /artgallery/admin/login.php");
        exit();
    }
}

// Redirect to login if not artist
function artist_only() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id']) || !is_artist()) {
        header("Location: ../user/login.php"); // Redirect to login if not
        exit();
    }
}
?>

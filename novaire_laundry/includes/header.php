<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Proteksi halaman: hanya bisa diakses jika sudah login
if (!isset($_SESSION['user_id']) && basename($_SERVER['PHP_SELF']) !== 'index.php' && basename($_SERVER['PHP_SELF']) !== 'register.php') {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novaire Laundry</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="app-wrapper">
    <aside class="sidebar">
        <div class="sidebar-brand">
            <span class="brand-gold">Novaire</span> Laundry
        </div>
        <nav class="sidebar-nav">
            <a href="dashboard.php" class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">Dashboard</a>
            <a href="pesan_laundry.php" class="<?= basename($_SERVER['PHP_SELF']) == 'pesan_laundry.php' ? 'active' : '' ?>">Pesan Laundry</a>
            <a href="data_laundry.php" class="<?= basename($_SERVER['PHP_SELF']) == 'data_laundry.php' ? 'active' : '' ?>">Data Laundry</a>
            <a href="laporan.php" class="<?= basename($_SERVER['PHP_SELF']) == 'laporan.php' ? 'active' : '' ?>">Laporan</a>
        </nav>
        <div class="sidebar-footer">
            <div class="user-info">
                <?= isset($_SESSION['user_nama']) ? htmlspecialchars($_SESSION['user_nama']) : '' ?>
                <span class="role-badge"><?= isset($_SESSION['user_role']) ? htmlspecialchars($_SESSION['user_role']) : '' ?></span>
            </div>
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
    </aside>
    <main class="main-content">

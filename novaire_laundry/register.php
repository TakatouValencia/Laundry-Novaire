<?php
session_start();
require 'includes/db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim($_POST['nama'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    if ($nama === '' || $email === '' || $password === '' || $confirm === '') {
        $error = 'Semua field wajib diisi.';
    } elseif ($password !== $confirm) {
        $error = 'Konfirmasi password tidak cocok.';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter.';
    } else {
        // Cek email sudah dipakai atau belum
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $error = 'Email sudah terdaftar. Gunakan email lain.';
        } else {
            $hashed = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, 'pelanggan')");
            $stmt->execute([$nama, $email, $hashed]);
            $success = 'Registrasi berhasil! Silakan login.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Novaire Laundry</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="auth-body">
    <div class="auth-card">
        <div class="auth-brand">
            <span class="brand-gold">Novaire</span> Laundry
        </div>
        <p class="auth-subtitle">Buat akun baru</p>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST" action="register.php" class="auth-form">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" placeholder="Nama kamu" required value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>">

            <label>Email</label>
            <input type="email" name="email" placeholder="nama@email.com" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

            <label>Password</label>
            <input type="password" name="password" placeholder="Minimal 6 karakter" required>

            <label>Konfirmasi Password</label>
            <input type="password" name="confirm_password" placeholder="Ulangi password" required>

            <button type="submit" class="btn-primary">Daftar</button>
        </form>

        <p class="auth-footer">Sudah punya akun? <a href="index.php">Login di sini</a></p>
    </div>
</body>
</html>

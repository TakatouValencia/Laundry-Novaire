<?php
require_once 'includes/db.php';

try {
    // Tambahkan opsi 'pelanggan' ke tipe ENUM kolom role
    $sql = "ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'kasir', 'pelanggan') NOT NULL DEFAULT 'pelanggan'";
    $pdo->exec($sql);
    
    echo "<h1>Migrasi Database Sukses!</h1>";
    echo "<p>Kolom 'role' pada tabel users berhasil diupdate untuk mendukung Pelanggan.</p>";
    echo "<p>Anda sekarang bisa menghapus file migrate_v2.php dari repository demi keamanan.</p>";
    echo "<p><a href='index.php'>Kembali ke Halaman Utama</a></p>";
} catch (PDOException $e) {
    die("Gagal melakukan migrasi database: " . $e->getMessage());
}
?>

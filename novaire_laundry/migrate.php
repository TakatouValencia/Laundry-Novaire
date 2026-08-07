<?php
require_once 'includes/db.php';

// Cek apakah database sudah memiliki tabel
$check = $pdo->query("SHOW TABLES")->fetchAll();
if (count($check) > 0) {
    die("Database sudah terisi! Hapus tabel terlebih dahulu jika ingin mengulang import.");
}

// Baca file SQL
$sql_file = 'novaire_laundry.sql';
if (!file_exists($sql_file)) {
    die("File $sql_file tidak ditemukan.");
}

$sql = file_get_contents($sql_file);

// Jalankan perintah SQL
try {
    $pdo->exec($sql);
    echo "<h1>Sukses!</h1>";
    echo "<p>Database novaire_laundry berhasil di-import ke Railway MySQL!</p>";
    echo "<p><a href='index.php'>Kembali ke Halaman Utama</a></p>";
} catch (PDOException $e) {
    die("Gagal meng-import database: " . $e->getMessage());
}

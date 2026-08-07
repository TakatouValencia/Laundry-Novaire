<?php
// =========================================================
// Koneksi Database - Novaire Laundry
// =========================================================

// Cek apakah web sedang berjalan di Railway (Railway selalu memberikan variabel PORT otomatis)
if (getenv('PORT') !== false) {
    // Mode Railway (Otomatis tanpa perlu setting variabel lagi)
    $db_host = 'mysql.railway.internal';
    $db_user = 'root';
    $db_pass = 'VXAitkYFRCDBwbwSbYXLhnpOVhAuyhrG';
    $db_name = 'railway';
    $db_port = '3306';
} else {
    // Mode Laptop / XAMPP
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'novaire_laundry';
    $db_port = '3306';
}

try {
    $pdo = new PDO(
        "mysql:host=$db_host;port=$db_port;dbname=$db_name;charset=utf8mb4",
        $db_user,
        $db_pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}

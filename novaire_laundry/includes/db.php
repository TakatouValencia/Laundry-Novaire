<?php
$db_host = 'mysql.railway.internal';
$db_user = 'root';
$db_pass = 'VXAitkYFRCDBwbwSbYXLhnpOVhAuyhrG';
$db_name = 'railway';
$db_port = '3306';

try {
    $pdo = new PDO("mysql:host=$db_host;port=$db_port;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>

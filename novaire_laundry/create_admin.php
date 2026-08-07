<?php
require_once 'includes/db.php';

$email = 'admin@novairelaundry.com';
$password = 'admin123';
$nama = 'Bos Novaire';
$role = 'admin';

// Membuat hash password secara otomatis menggunakan server
$hashed = password_hash($password, PASSWORD_BCRYPT);

try {
    // Mengecek apakah email admin sudah pernah ada di database
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->fetch()) {
        // Jika sudah ada, kita perbaiki (update) password & memastikan rolenya 'admin'
        $stmt = $pdo->prepare("UPDATE users SET password = ?, role = ? WHERE email = ?");
        $stmt->execute([$hashed, $role, $email]);
        echo "<h1>Berhasil!</h1><p>Akun Admin yang lama berhasil diselamatkan dan di-reset ulang.</p>";
    } else {
        // Jika belum ada, kita buatkan baru
        $stmt = $pdo->prepare("INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nama, $email, $hashed, $role]);
        echo "<h1>Berhasil!</h1><p>Akun Admin khusus (Super Admin) berhasil dibuat.</p>";
    }
    
    echo "<h3>Silakan gunakan data berikut untuk login:</h3>";
    echo "<ul>";
    echo "<li>Email: <b>$email</b></li>";
    echo "<li>Password: <b>$password</b></li>";
    echo "</ul>";
    echo "<br><br><a href='index.php'>Klik di sini untuk menuju halaman Login</a>";
    echo "<br><br><div style='color:red; font-weight:bold;'>PERHATIAN: Demi keamanan web Anda, tolong segera hapus file create_admin.php ini dari GitHub setelah akun berhasil dibuat!</div>";
    
} catch (PDOException $e) {
    die("Ada kesalahan sistem: " . $e->getMessage());
}
?>

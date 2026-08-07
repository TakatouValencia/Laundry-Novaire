<?php
require 'includes/db.php';
require 'includes/header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pelanggan = trim($_POST['nama_pelanggan'] ?? '');
    $no_hp          = trim($_POST['no_hp'] ?? '');
    $jenis_layanan  = trim($_POST['jenis_layanan'] ?? '');
    $berat_kg       = (float)($_POST['berat_kg'] ?? 0);
    $harga_per_kg   = (float)($_POST['harga_per_kg'] ?? 0);
    $tanggal_masuk  = $_POST['tanggal_masuk'] ?? '';

    if ($nama_pelanggan === '' || $no_hp === '' || $jenis_layanan === '' || $berat_kg <= 0 || $harga_per_kg <= 0 || $tanggal_masuk === '') {
        $error = 'Semua field wajib diisi dengan benar.';
    } else {
        $total_harga = $berat_kg * $harga_per_kg;
        $stmt = $pdo->prepare("INSERT INTO pesanan (id_user, nama_pelanggan, no_hp, jenis_layanan, berat_kg, harga_per_kg, total_harga, status, tanggal_masuk) VALUES (?, ?, ?, ?, ?, ?, ?, 'proses', ?)");
        $stmt->execute([
            $_SESSION['user_id'],
            $nama_pelanggan,
            $no_hp,
            $jenis_layanan,
            $berat_kg,
            $harga_per_kg,
            $total_harga,
            $tanggal_masuk
        ]);
        $success = 'Pesanan berhasil disimpan! Total: Rp ' . number_format($total_harga, 0, ',', '.');
    }
}
?>

<div class="page-header">
    <h1>Pesan Laundry</h1>
    <p>Tambahkan pesanan laundry baru</p>
</div>

<div class="card card-form">
    <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST" action="pesan_laundry.php" class="form-grid">
        <div class="form-group">
            <label>Nama Pelanggan</label>
            <input type="text" name="nama_pelanggan" required>
        </div>
        <div class="form-group">
            <label>No. HP</label>
            <input type="text" name="no_hp" required>
        </div>
        <div class="form-group">
            <label>Jenis Layanan</label>
            <select name="jenis_layanan" required>
                <option value="">-- Pilih Layanan --</option>
                <option value="Cuci Kering Lipat">Cuci Kering Lipat</option>
                <option value="Cuci Setrika">Cuci Setrika</option>
                <option value="Setrika Saja">Setrika Saja</option>
                <option value="Cuci Sepatu">Cuci Sepatu</option>
                <option value="Dry Clean">Dry Clean</option>
            </select>
        </div>
        <div class="form-group">
            <label>Berat (kg)</label>
            <input type="number" step="0.1" min="0.1" name="berat_kg" required>
        </div>
        <div class="form-group">
            <label>Harga per Kg (Rp)</label>
            <input type="number" step="500" min="500" name="harga_per_kg" required>
        </div>
        <div class="form-group">
            <label>Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk" required value="<?= date('Y-m-d') ?>">
        </div>
        <div class="form-group form-full">
            <button type="submit" class="btn-primary">Simpan Pesanan</button>
        </div>
    </form>
</div>

<?php require 'includes/footer.php'; ?>

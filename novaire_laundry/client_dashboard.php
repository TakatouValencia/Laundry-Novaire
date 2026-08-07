<?php
require 'includes/db.php';
require 'includes/header.php';

// Pastikan yang akses adalah pelanggan
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'pelanggan') {
    header('Location: dashboard.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil riwayat pesanan milik pelanggan ini
$stmt = $pdo->prepare("SELECT * FROM pesanan WHERE id_user = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$pesanan = $stmt->fetchAll();

// Hitung ringkasan khusus untuk pelanggan ini
$totalPesanan = count($pesanan);
$totalProses = 0;
$totalSelesai = 0;
foreach ($pesanan as $p) {
    if ($p['status'] === 'proses') {
        $totalProses++;
    } else {
        $totalSelesai++;
    }
}
?>

<div class="page-header">
    <h1>Pesanan Saya</h1>
    <p>Pantau status laundry kamu di sini</p>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <span class="stat-label">Total Pesanan</span>
        <span class="stat-value"><?= $totalPesanan ?></span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Sedang Diproses</span>
        <span class="stat-value"><?= $totalProses ?></span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Selesai / Diambil</span>
        <span class="stat-value"><?= $totalSelesai ?></span>
    </div>
</div>

<div class="card">
    <h2>Riwayat Cucian</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Tanggal Masuk</th>
                <th>Layanan</th>
                <th>Berat</th>
                <th>Total Harga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($pesanan) === 0): ?>
                <tr><td colspan="5" class="empty-state">Kamu belum punya riwayat pesanan.</td></tr>
            <?php endif; ?>
            <?php foreach ($pesanan as $r): ?>
            <tr>
                <td><?= date('d M Y', strtotime($r['tanggal_masuk'])) ?></td>
                <td><?= htmlspecialchars($r['jenis_layanan']) ?></td>
                <td><?= $r['berat_kg'] ?> kg</td>
                <td>Rp <?= number_format($r['total_harga'], 0, ',', '.') ?></td>
                <td>
                    <span class="badge badge-<?= $r['status'] ?>">
                        <?= ucfirst($r['status']) ?>
                    </span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require 'includes/footer.php'; ?>

<?php
require 'includes/db.php';
require 'includes/header.php';

// Proteksi: Pelanggan tidak boleh akses halaman admin
if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'pelanggan') {
    header('Location: client_dashboard.php');
    exit;
}

// Statistik ringkas
$totalPesanan = $pdo->query("SELECT COUNT(*) FROM pesanan")->fetchColumn();
$totalProses  = $pdo->query("SELECT COUNT(*) FROM pesanan WHERE status = 'proses'")->fetchColumn();
$totalSelesai = $pdo->query("SELECT COUNT(*) FROM pesanan WHERE status IN ('selesai','diambil')")->fetchColumn();
$totalOmzet   = $pdo->query("SELECT COALESCE(SUM(total_harga),0) FROM pesanan")->fetchColumn();

$recent = $pdo->query("SELECT * FROM pesanan ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>

<div class="page-header">
    <h1>Dashboard</h1>
    <p>Ringkasan aktivitas Novaire Laundry</p>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <span class="stat-label">Total Pesanan</span>
        <span class="stat-value"><?= (int)$totalPesanan ?></span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Sedang Proses</span>
        <span class="stat-value"><?= (int)$totalProses ?></span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Selesai / Diambil</span>
        <span class="stat-value"><?= (int)$totalSelesai ?></span>
    </div>
    <div class="stat-card stat-gold">
        <span class="stat-label">Total Omzet</span>
        <span class="stat-value">Rp <?= number_format($totalOmzet, 0, ',', '.') ?></span>
    </div>
</div>

<div class="card">
    <h2>Pesanan Terbaru</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Pelanggan</th>
                <th>Layanan</th>
                <th>Berat</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($recent) === 0): ?>
                <tr><td colspan="5" class="empty-state">Belum ada pesanan.</td></tr>
            <?php endif; ?>
            <?php foreach ($recent as $r): ?>
            <tr>
                <td><?= htmlspecialchars($r['nama_pelanggan']) ?></td>
                <td><?= htmlspecialchars($r['jenis_layanan']) ?></td>
                <td><?= $r['berat_kg'] ?> kg</td>
                <td>Rp <?= number_format($r['total_harga'], 0, ',', '.') ?></td>
                <td><span class="badge badge-<?= $r['status'] ?>"><?= ucfirst($r['status']) ?></span></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require 'includes/footer.php'; ?>

<?php
require 'includes/db.php';
require 'includes/header.php';

$dari = $_GET['dari'] ?? date('Y-m-01');
$sampai = $_GET['sampai'] ?? date('Y-m-d');

$stmt = $pdo->prepare("SELECT * FROM pesanan WHERE tanggal_masuk BETWEEN ? AND ? ORDER BY tanggal_masuk ASC");
$stmt->execute([$dari, $sampai]);
$data = $stmt->fetchAll();

$totalPesanan = count($data);
$totalBerat = 0;
$totalOmzet = 0;
foreach ($data as $d) {
    $totalBerat += $d['berat_kg'];
    $totalOmzet += $d['total_harga'];
}
?>

<div class="page-header">
    <h1>Laporan</h1>
    <p>Laporan transaksi dan pendapatan Novaire Laundry</p>
</div>

<div class="card">
    <form method="GET" action="laporan.php" class="filter-bar">
        <label>Dari</label>
        <input type="date" name="dari" value="<?= htmlspecialchars($dari) ?>">
        <label>Sampai</label>
        <input type="date" name="sampai" value="<?= htmlspecialchars($sampai) ?>">
        <button type="submit" class="btn-secondary">Tampilkan</button>
    </form>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <span class="stat-label">Jumlah Transaksi</span>
        <span class="stat-value"><?= $totalPesanan ?></span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Total Berat</span>
        <span class="stat-value"><?= number_format($totalBerat, 1) ?> kg</span>
    </div>
    <div class="stat-card stat-gold">
        <span class="stat-label">Total Pendapatan</span>
        <span class="stat-value">Rp <?= number_format($totalOmzet, 0, ',', '.') ?></span>
    </div>
</div>

<div class="card">
    <h2>Rincian Transaksi</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Layanan</th>
                <th>Berat</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($data) === 0): ?>
                <tr><td colspan="6" class="empty-state">Tidak ada transaksi pada periode ini.</td></tr>
            <?php endif; ?>
            <?php foreach ($data as $d): ?>
            <tr>
                <td><?= date('d/m/Y', strtotime($d['tanggal_masuk'])) ?></td>
                <td><?= htmlspecialchars($d['nama_pelanggan']) ?></td>
                <td><?= htmlspecialchars($d['jenis_layanan']) ?></td>
                <td><?= $d['berat_kg'] ?> kg</td>
                <td>Rp <?= number_format($d['total_harga'], 0, ',', '.') ?></td>
                <td><span class="badge badge-<?= $d['status'] ?>"><?= ucfirst($d['status']) ?></span></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require 'includes/footer.php'; ?>

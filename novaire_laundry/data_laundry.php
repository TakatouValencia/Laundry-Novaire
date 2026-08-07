<?php
require 'includes/db.php';
require 'includes/header.php';

// Update status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $id = (int)$_POST['id'];
    $status = $_POST['status'];
    $tanggal_selesai = ($status === 'proses') ? null : date('Y-m-d');
    $stmt = $pdo->prepare("UPDATE pesanan SET status = ?, tanggal_selesai = ? WHERE id = ?");
    $stmt->execute([$status, $tanggal_selesai, $id]);
    header('Location: data_laundry.php');
    exit;
}

// Hapus data
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $stmt = $pdo->prepare("DELETE FROM pesanan WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: data_laundry.php');
    exit;
}

// Search & filter
$search = trim($_GET['search'] ?? '');
$filterStatus = $_GET['status'] ?? '';

$sql = "SELECT * FROM pesanan WHERE 1=1";
$params = [];

if ($search !== '') {
    $sql .= " AND nama_pelanggan LIKE ?";
    $params[] = "%$search%";
}
if ($filterStatus !== '') {
    $sql .= " AND status = ?";
    $params[] = $filterStatus;
}
$sql .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$data = $stmt->fetchAll();
?>

<div class="page-header">
    <h1>Data Laundry</h1>
    <p>Kelola semua pesanan laundry</p>
</div>

<div class="card">
    <form method="GET" action="data_laundry.php" class="filter-bar">
        <input type="text" name="search" placeholder="Cari nama pelanggan..." value="<?= htmlspecialchars($search) ?>">
        <select name="status">
            <option value="">Semua Status</option>
            <option value="proses" <?= $filterStatus === 'proses' ? 'selected' : '' ?>>Proses</option>
            <option value="selesai" <?= $filterStatus === 'selesai' ? 'selected' : '' ?>>Selesai</option>
            <option value="diambil" <?= $filterStatus === 'diambil' ? 'selected' : '' ?>>Diambil</option>
        </select>
        <button type="submit" class="btn-secondary">Filter</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Pelanggan</th>
                <th>No. HP</th>
                <th>Layanan</th>
                <th>Berat</th>
                <th>Total</th>
                <th>Tgl Masuk</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($data) === 0): ?>
                <tr><td colspan="8" class="empty-state">Tidak ada data.</td></tr>
            <?php endif; ?>
            <?php foreach ($data as $d): ?>
            <tr>
                <td><?= htmlspecialchars($d['nama_pelanggan']) ?></td>
                <td><?= htmlspecialchars($d['no_hp']) ?></td>
                <td><?= htmlspecialchars($d['jenis_layanan']) ?></td>
                <td><?= $d['berat_kg'] ?> kg</td>
                <td>Rp <?= number_format($d['total_harga'], 0, ',', '.') ?></td>
                <td><?= date('d/m/Y', strtotime($d['tanggal_masuk'])) ?></td>
                <td>
                    <form method="POST" action="data_laundry.php" class="inline-form">
                        <input type="hidden" name="id" value="<?= $d['id'] ?>">
                        <select name="status" onchange="this.form.submit()">
                            <option value="proses" <?= $d['status'] === 'proses' ? 'selected' : '' ?>>Proses</option>
                            <option value="selesai" <?= $d['status'] === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                            <option value="diambil" <?= $d['status'] === 'diambil' ? 'selected' : '' ?>>Diambil</option>
                        </select>
                        <input type="hidden" name="update_status" value="1">
                    </form>
                </td>
                <td>
                    <a href="data_laundry.php?hapus=<?= $d['id'] ?>" class="btn-delete" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require 'includes/footer.php'; ?>

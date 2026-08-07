-- =========================================================
-- Database: novaire_laundry
-- Aplikasi: Novaire Laundry
-- =========================================================

CREATE DATABASE IF NOT EXISTS novaire_laundry CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE novaire_laundry;

-- =========================================================
-- Tabel: users
-- =========================================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'kasir') NOT NULL DEFAULT 'kasir',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =========================================================
-- Tabel: pesanan
-- =========================================================
CREATE TABLE pesanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    nama_pelanggan VARCHAR(100) NOT NULL,
    no_hp VARCHAR(20) NOT NULL,
    jenis_layanan VARCHAR(50) NOT NULL,
    berat_kg DECIMAL(6,2) NOT NULL,
    harga_per_kg DECIMAL(10,2) NOT NULL,
    total_harga DECIMAL(12,2) NOT NULL,
    status ENUM('proses', 'selesai', 'diambil') NOT NULL DEFAULT 'proses',
    tanggal_masuk DATE NOT NULL,
    tanggal_selesai DATE NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =========================================================
-- Data awal: 1 akun admin default
-- Password asli: admin123  (sudah di-hash pakai bcrypt)
-- =========================================================
INSERT INTO users (nama, email, password, role) VALUES
('Admin Novaire', 'admin@novairelaundry.com', '$2y$10$92g2p7O1vXexrCEXBqjkxOZzVwGZmA1KcFXqjOw2QIhqUYVePzJ2C', 'admin');

-- =========================================================
-- Contoh data pesanan (opsional, boleh dihapus)
-- =========================================================
INSERT INTO pesanan (id_user, nama_pelanggan, no_hp, jenis_layanan, berat_kg, harga_per_kg, total_harga, status, tanggal_masuk, tanggal_selesai) VALUES
(1, 'Budi Santoso', '081234567890', 'Cuci Kering Lipat', 3.5, 7000, 24500, 'selesai', '2026-07-28', '2026-07-29'),
(1, 'Siti Aminah', '081298765432', 'Cuci Setrika', 2.0, 10000, 20000, 'proses', '2026-08-01', NULL);

# Tutorial Instalasi — Novaire Laundry

Aplikasi manajemen laundry berbasis PHP + MySQL dengan branding Navy (#1A2340) & Gold (#B08D2B).

## Struktur File
```
novaire_laundry/
├── index.php              → Login
├── register.php           → Registrasi akun
├── logout.php             → Logout
├── dashboard.php          → Dashboard ringkasan
├── pesan_laundry.php      → Form input pesanan baru
├── data_laundry.php       → Kelola data pesanan (edit status, hapus)
├── laporan.php            → Laporan transaksi per periode
├── includes/
│   ├── db.php              → Koneksi database
│   ├── header.php          → Template header + sidebar (reusable)
│   └── footer.php          → Template footer (reusable)
├── assets/
│   ├── css/style.css       → Semua styling
│   └── js/script.js        → Interaktivitas (preview total harga, konfirmasi hapus)
└── novaire_laundry.sql     → Skema database + data awal
```

## 1. Persiapan Software
Install salah satu dari:
- **XAMPP** (Windows/Mac/Linux) — https://www.apachefriends.org
- **Laragon** (Windows, lebih ringan) — https://laragon.org

Pastikan Apache & MySQL aktif setelah instalasi.

## 2. Copy File Project
1. Buka folder instalasi XAMPP/Laragon, masuk ke folder `htdocs` (XAMPP) atau `www` (Laragon).
2. Buat folder baru bernama `novaire_laundry`.
3. Copy semua file project ke dalam folder tersebut.

## 3. Import Database
1. Jalankan XAMPP/Laragon, aktifkan **Apache** dan **MySQL**.
2. Buka browser → akses `http://localhost/phpmyadmin`.
3. Klik tab **Import**.
4. Pilih file `novaire_laundry.sql` dari folder project.
5. Klik **Go / Kirim**. Database `novaire_laundry` beserta tabel `users` dan `pesanan` otomatis terbuat, lengkap dengan 1 akun admin default.

## 4. Konfigurasi Koneksi Database
Buka file `includes/db.php`, sesuaikan jika perlu:
```php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';        // isi jika MySQL kamu pakai password
$db_name = 'novaire_laundry';
```
Default XAMPP/Laragon biasanya `root` tanpa password — jadi kalau setup standar, tidak perlu diubah.

## 5. Jalankan Aplikasi
Buka browser, akses:
```
http://localhost/novaire_laundry/
```

## 6. Login dengan Akun Default
```
Email    : admin@novairelaundry.com
Password : admin123
```
Setelah login, kamu bisa langsung eksplor Dashboard, atau daftar akun kasir baru lewat halaman Registrasi.

## 7. Alur Penggunaan
1. **Login** → masuk pakai akun admin/kasir.
2. **Pesan Laundry** → input pesanan baru, total harga otomatis terhitung (berat × harga/kg).
3. **Data Laundry** → lihat semua pesanan, ubah status (Proses → Selesai → Diambil) langsung dari dropdown, atau hapus data.
4. **Laporan** → filter transaksi berdasarkan rentang tanggal, lihat total pendapatan.
5. **Logout** → keluar dari sesi.

## Catatan Keamanan
- Password disimpan dengan `password_hash()` (bcrypt), bukan plain text.
- Semua query database pakai **prepared statement** (PDO) → aman dari SQL Injection.
- Halaman selain login/register otomatis redirect ke login kalau session belum ada (lihat `includes/header.php`).

## Troubleshooting
| Masalah | Solusi |
|---|---|
| "Koneksi database gagal" | Pastikan MySQL aktif & nama database di `db.php` sesuai |
| Halaman blank/putih | Aktifkan error display: tambahkan `ini_set('display_errors', 1); error_reporting(E_ALL);` di awal file untuk debug |
| CSS tidak muncul | Pastikan folder `assets/css/style.css` ke-copy dengan benar, cek path di `includes/header.php` |
| Font Google tidak muncul | Butuh koneksi internet karena font di-load dari Google Fonts CDN |

Selesai! Novaire Laundry siap dipakai. 🧺

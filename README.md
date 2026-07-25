# Toko Pesan Roti - E-Commerce & Management System

Aplikasi E-Commerce Pemesanan Roti & Sistem Manajemen Toko berbasis web menggunakan **Laravel 11**, **PHP 8.2+**, **TailwindCSS**, dan **MySQL**.

## 🌟 Fitur Utama

### Sisi Pelanggan (Customer):
- **Katalog Roti Modern**: Pencarian, filter kategori, dan detail produk.
- **Keranjang Belanja & Wishlist**: Manajemen keranjang belanja dan produk favorit.
- **Checkout & Transfer Bank**: Form alamat pengiriman, opsi pembayaran, dan unggah bukti transfer.
- **Tracking Pesanan Real-Time**: Status pesanan dari *Pending*, *Menunggu Verifikasi*, *Diproses*, hingga *Selesai*.
- **Review Produk**: Pemberian rating dan ulasan roti.

### Sisi Administrator:
- **Dashboard Analytics**: Ringkasan omset, total pesanan, dan statistik pelanggan.
- **Manajemen Kategori & Produk (CRUD)**: Kelola roti, harga, foto, dan status ketersediaan.
- **Manajemen Stok**: Peringatan otomatis stok menipis (*Low Stock Alert* <= 10).
- **Verifikasi Pembayaran**: Peninjauan foto resi transfer bank dan persetujuan transaksi.
- **Laporan Penjualan & Ekspor Pelanggan**: Rekapitulasi penjualan lunas dan ekspor data ke CSV.

---

## 📚 Dokumentasi Project Rekayasa Perangkat Lunak (RPL)

Dokumentasi lengkap untuk **Project RPL (40%)** telah tersedia di dalam repositori ini:
- 📑 **[LAPORAN_RPL.md](LAPORAN_RPL.md)**: Dokumen lengkap berisi SDLC Waterfall Iteratif, SRS, Kamus Data (9 tabel), DFD (Level 0, 1, 2), ERD, UML Diagrams (Use Case, Class, Activity, Sequence), Functionality Test (Black Box), dan Usability Test (SUS Score 84.5).
- 📊 **[PPT_PRESENTASI_RPL.md](PPT_PRESENTASI_RPL.md)**: Outlining 15 Slide Presentasi UAS.

---

## 🚀 Panduan Instalasi & Menjalankan Proyek

1. **Clone Repositori**:
   ```bash
   git clone https://github.com/AzrilRyzcho/Toko-Pesan-Roti.git
   cd Toko-Pesan-Roti
   ```

2. **Install Dependensi**:
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrasi Database & Seed Data**:
   ```bash
   php artisan migrate --seed
   ```

5. **Jalankan Server Lokal**:
   ```bash
   php artisan serve
   ```


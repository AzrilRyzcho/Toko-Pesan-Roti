# SLIDE PRESENTASI UAS - PROJECT RPL (40%)
## SISTEM INFORMASI E-COMMERCE "TOKO ROTI" BERBASIS WEB

> **Mata Kuliah**: Rekayasa Perangkat Lunak (RPL)  
> **Jadwal Presentasi**: Minggu UAS (22–30 Juli 2026)  
> **Framework & Tech**: Laravel 11, PHP 8.2+, MySQL, TailwindCSS, Blade

---

### **SLIDE 1: COVER PRESENTASI**
- **Judul**: Pengembangan Sistem Informasi E-Commerce "Toko Roti" Berbasis Web
- **Sub-judul**: Laporan Akhir Rekayasa Perangkat Lunak (Project RPL 40%)
- **Tim Penyusun**:
  1. *Nama Anggota 1* - System Analyst
  2. *Nama Anggota 2* - Software Designer
  3. *Nama Anggota 3* - Programmer (Lead Dev)
  4. *Nama Anggota 4* - Software Tester (QA)
  5. *Nama Anggota 5* - Technical Writer

---

### **SLIDE 2: LATAR BELAKANG & SOLUSI**
- **Permasalahan**:
  - Penjualan roti konvensional terbatas oleh lokasi dan jam operasional toko.
  - Pencatatan transaksi manual rentan terhadap selisih stok dan rekapitulasi pembayaran.
- **Solusi Yang Ditawarkan**:
  - Membangun Platform Web E-Commerce Toko Roti yang dapat diakses 24/7.
  - Fitur Keranjang Belanja, Upload Bukti Transfer, Tracking Pesanan Real-time.
  - Panel Admin terpusat untuk Manajemen Stok & Verifikasi Pembayaran otomatis.

---

### **SLIDE 3: SOFTWARE DEVELOPMENT MODEL (SDLC)**
- **Model Yang Dipilih**: *Waterfall Model dengan Pendekatan Iteratif*
- **Tahapan Eksekusi**:
  1. **Analysis**: Analisis kebutuhan & penyusunan SRS
  2. **Design**: Perancangan DFD, Kamus Data, ERD, dan UML Diagram
  3. **Coding**: Pengembangan website dengan Laravel 11 & MySQL
  4. **Testing**: Functionality Test (Black Box) & Usability Test (SUS)
  5. **Deployment**: Pengujian lokal (`php artisan serve`) & kesiapan rilis.

---

### **SLIDE 4: ARCHITECTURE & TECHNOLOGY STACK**
- **Backend Framework**: Laravel 11 (PHP 8.2+)
- **Frontend / Templating**: Blade Engine + TailwindCSS (Modern, Glassmorphism UI)
- **Database Management**: MySQL Database (9 Relational Tables)
- **Security Features**: Middleware Auth & Admin, Password Bcrypt Hashing, CSRF Protection.

---

### **SLIDE 5: DATA FLOW DIAGRAM (DFD)**
- **Diagram Konteks (Level 0)**:
  - Entitas **Pelanggan**: Mengirim data akun, order, bukti bayar $\rightarrow$ Menerima info roti, invoice, status order.
  - Entitas **Admin**: Menginput produk/stok, verifikasi bayar $\rightarrow$ Menerima laporan penjualan & notifikasi order.
- **DFD Level 1**:
  - 6 Proses Utama: Autentikasi (1.0), Katalog (2.0), Keranjang (3.0), Checkout (4.0), Verifikasi (5.0), Laporan (6.0).

---

### **SLIDE 6: DATABASE SCHEMA & ERD**
- **Total Entitas**: 9 Tabel (`users`, `categories`, `products`, `carts`, `cart_items`, `orders`, `order_items`, `reviews`, `favorites`).
- **Kardinalitas Utama**:
  - User 1 : N Orders
  - Category 1 : N Products
  - Order 1 : N OrderItems
  - Product 1 : N OrderItems

---

### **SLIDE 7: UML USE CASE DIAGRAM**
- **Aktor Customer**: Register/Login, Browse Katalog, Tambah Keranjang, Checkout, Upload Bukti Transfer, Lacak Status Order, Beri Review.
- **Aktor Admin**: Login Admin (`/admin/login`), CRUD Produk & Kategori, Kelola Stok, Verifikasi Pembayaran, Export Data Pelanggan, Lihat Laporan Omset.

---

### **SLIDE 8: UML CLASS DIAGRAM**
- Memetakan arsitektur Object-Oriented dalam framework Laravel:
  - `User`, `Product`, `Category`, `Cart`, `CartItem`, `Order`, `OrderItem`, `Review`, `Favorite`.
  - Relasi Eloquent: `hasMany()`, `belongsTo()`, `hasOne()`.

---

### **SLIDE 9: UML ACTIVITY DIAGRAM**
- **Alur Transaksi Pembeli & Verifikasi Admin**:
  1. Pembeli memilih roti & menambahkan ke keranjang.
  2. Input alamat pengiriman $\rightarrow$ System create order (`pending`).
  3. Pembeli upload bukti bayar $\rightarrow$ Status berubah `waiting_verification`.
  4. Admin memeriksa resi bayar:
     - Jika Valid $\rightarrow$ `paid` & `processing` (Stok terpotong).
     - Jika Invalid $\rightarrow$ `rejected`.

---

### **SLIDE 10: UML SEQUENCE DIAGRAM**
- Visualisasi alur pesan (*message calls*) antar komponen (Customer $\rightarrow$ View Blade $\rightarrow$ Controller $\rightarrow$ Database MySQL $\rightarrow$ Admin).
- Memastikan tidak ada loncatan proses dalam alur pembayaran e-commerce.

---

### **SLIDE 11: DEMO ANTARMUKA (SISI PELANGGAN / CUSTOMER)**
- **Katalog & Shop**: Tampilan grid roti modern, filter kategori, badge harga & stok.
- **Shopping Cart & Checkout**: Ringkasan belanjaan, kalkulasi total harga, input alamat.
- **Order Tracking**: Timeline visual status pesanan (*Pending* $\rightarrow$ *Menunggu Verifikasi* $\rightarrow$ *Diproses* $\rightarrow$ *Selesai*).

---

### **SLIDE 12: DEMO ANTARMUKA (SISI ADMINISTRATOR)**
- **Dashboard Admin**: Card statistik total omset, jumlah pesanan, dan grafik ringkasan.
- **Manajemen Stok**: Peringatan otomatis stok menipis (*Low Stock Alert* <= 10).
- **Tab Verifikasi Pembayaran**: Modal peninjauan bukti foto resi transfer bank pelanggan.

---

### **SLIDE 13: PENGUJIANKAN: FUNCTIONALITY TEST (BLACK BOX)**
- **Metode**: Black Box Testing (10 Skenario Uji)
- **Hasil Pengujian**:
  - Test Cases (Auth, Cart, Checkout, Upload Resi, Verifikasi Admin, CRUD Produk, Laporan) = **100% PASS**.
  - Bebas dari error fatal / exception handling.

---

### **SLIDE 14: PENGUJIANKAN: USABILITY TEST (SUS SCORE)**
- **Metode**: System Usability Scale (SUS) dengan 10 Responden Pembeli.
- **Hasil Evaluation**:
  - **Skor Akhir SUS**: **84.5 / 100** (Grade A - *Excellent*).
  - Umpan balik pengguna: Navigasi intuitif, visual menarik, dan proses checkout sangat cepat.

---

### **SLIDE 15: KESIMPULAN & PENUTUP**
- **Kesimpulan**:
  - Aplikasi E-Commerce Toko Roti telah rampung 100% dan memenuhi seluruh standar Rekayasa Perangkat Lunak (RPL).
  - Dokumentasi sistem (Kamus Data, DFD, ERD, UML, Testing) lengkap & terstruktur.
- **Sesi Tanya Jawab (Q&A)**: Terima Kasih!

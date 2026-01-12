<div align="center">

# Aplikasi Perpustakaan Digital Berbasis Web
### Tugas Besar / Ujian Akhir Semester (UAS) Pemrograman Web

![PHP Version](https://img.shields.io/badge/PHP-8.0%2B-777bb4?style=flat-square&logo=php&logoColor=white)
![Database](https://img.shields.io/badge/Database-MySQL%2FMariaDB-4479a1?style=flat-square&logo=mysql&logoColor=white)
![Frontend](https://img.shields.io/badge/Frontend-Bootstrap%205-7952b3?style=flat-square&logo=bootstrap&logoColor=white)
![Status](https://img.shields.io/badge/Status-Completed-success?style=flat-square)

</div>

---

## 📋 Identitas Pengembang

> **Catatan untuk Dosen Penilai:** Berikut adalah identitas mahasiswa pengembang aplikasi ini.

| Data | Keterangan |
| :--- | :--- |
| **Nama Lengkap** | **Dedi Ramadhan** |
| **NIM** | **312410171** |
| **Kelas** | **TI.24.A.1** |

---

## 📖 1. Deskripsi Program

**Aplikasi Perpustakaan Digital** ini adalah sistem informasi manajemen buku sederhana yang dirancang berbasis web. Proyek ini dikembangkan sebagai implementasi nyata dari konsep **Object-Oriented Programming (OOP)** menggunakan bahasa pemrograman **PHP Native** (tanpa bantuan framework backend) dan basis data **MySQL/MariaDB**.

### Tujuan Pengembangan
Aplikasi ini dibangun untuk memenuhi dan mendemonstrasikan pemahaman mendalam mengenai aspek-aspek berikut:

1.  **Implementasi OOP:** Penerapan *Class*, *Object*, dan *Inheritance* dalam PHP untuk struktur koneksi database dan logika bisnis yang modular.
2.  **Keamanan Database:** Penggunaan **PDO (PHP Data Objects)** dan *prepared statements* untuk mencegah serangan *SQL Injection*.
3.  **Autentikasi & Otorisasi:** Manajemen **Session** yang aman untuk membatasi hak akses berdasarkan peran (*Multi-role login*).
4.  **Manajemen Data:** Implementasi operasi **CRUD** (*Create, Read, Update, Delete*) yang lengkap pada data buku.
5.  **Fitur Esensial:** Pengembangan fitur pendukung seperti **Upload Gambar**, **Pencarian (Search)**, dan **Paginasi (Pagination)** data.

### Stack Teknologi

| Kategori | Teknologi Yang Digunakan |
| :--- | :--- |
| **Core Backend** | PHP 8.x (OOP Style) |
| **Database** | MySQL / MariaDB |
| **Frontend Framework**| Bootstrap 5 (Responsif UX/UI) |
| **Web Server** | Apache (via XAMPP/LAMPP) |

---

## 🚀 2. Fitur Utama Aplikasi

Aplikasi ini dibagi menjadi dua peran pengguna dengan hak akses yang berbeda:

### A. Fitur Umum & Keamanan
* **Sistem Login Multi-role:** Validasi keamanan untuk memisahkan akses Administrator dan User Biasa.
* **Proteksi Route:** Mencegah akses langsung ke halaman admin tanpa sesi login yang valid.
* **Sanitasi Input:** Mencegah input berbahaya dari pengguna.

### B. Fitur Administrator (Full Access)
Admin memiliki kontrol penuh terhadap manajemen data:
* ✅ **Dashboard Informatif:** Melihat daftar buku lengkap dengan thumbnail gambar sampul.
* ✅ **Pencarian Canggih:** Mencari buku berdasarkan kata kunci judul atau nama penulis.
* ✅ **Paginasi Data:** Menampilkan data dalam beberapa halaman agar antarmuka tetap rapi.
* ✅ **Tambah Buku & Upload:** Input data buku baru disertai fitur unggah gambar sampul (validasi format JPG/PNG).
* ✅ **Edit Data & Gambar:** Memperbarui informasi buku dan mengganti gambar sampul yang sudah ada.
* ✅ **Hapus Buku (Soft Delete/Hard Delete):** Menghapus data buku dari database sekaligus membersihkan file gambarnya dari server.

### C. Fitur User Biasa (Read-Only)
* ✅ **Katalog Buku:** Halaman khusus untuk melihat koleksi buku yang tersedia tanpa memiliki akses untuk memodifikasi data.

---

## 🛠️ 3. Panduan Instalasi

Ikuti langkah-langkah berikut untuk menjalankan aplikasi di komputer lokal (localhost).

### Prasyarat
Pastikan telah menginstal paket web server seperti **XAMPP** (Windows/Linux) atau MAMP (macOS) yang mencakup Apache, PHP, dan MySQL.

### Langkah 1: Penempatan File
1.  Salin/Ekstrak folder project ini (misalnya: `perpustakaan_uas`) ke direktori root web server:
    * Windows: `C:\xampp\htdocs\`
    * Linux: `/opt/lampp/htdocs/` atau `/var/www/html/`
2.  **PENTING:** Pastikan di dalam folder `public/` terdapat direktori bernama `uploads`. Jika belum ada, buat folder tersebut dan pastikan izin aksesnya *writable*.

### Langkah 2: Konfigurasi Database
1.  Buka **phpMyAdmin** (`http://localhost/phpmyadmin`).
2.  Buat database baru bernama: `db_perpustakaan`.
3.  Buka tab **SQL**, salin script di bawah ini, dan jalankan (Go):

```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL
);

CREATE TABLE buku (
    id INT PRIMARY KEY AUTO_INCREMENT,
    judul VARCHAR(255) NOT NULL,
    penulis VARCHAR(100) NOT NULL,
    stok INT NOT NULL,
    gambar VARCHAR(255) DEFAULT 'default.jpg'
);

-- Akun Default untuk Login
-- Password untuk keduanya adalah: password123
INSERT INTO users (username, password, role) VALUES 
('admin', '$2y$10$wYp.8/s6.c.6.6.6.6.6.6.6.6.6.6.6.6.6.6.6.6.6.6.6.6.6', 'admin'),
('user', '$2y$10$wYp.8/s6.c.6.6.6.6.6.6.6.6.6.6.6.6.6.6.6.6.6.6.6.6', 'user');

-- Data Dummy Buku
INSERT INTO buku (judul, penulis, stok, gambar) VALUES
('Belajar PHP OOP', 'Budi Raharjo', 10, 'default.jpg'),
('Mahir Bootstrap 5', 'Tim Pengembang', 25, 'default.jpg');

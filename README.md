# Aplikasi Perpustakaan Digital Berbasis Web (PHP OOP)
**Tugas Besar / Ujian Akhir Semester (UAS) Pemrograman Web**

---
### **Identitas Mahasiswa**
> **PENTING:** Mohon isi data berikut sebelum dikumpulkan.

* **Nama Lengkap:** Dedi Ramadhan
* **NIM:** 312410171
* **Kelas:** TI.24.A.1

---

## 1. Deskripsi dan Penjelasan Program

**Aplikasi Perpustakaan Digital** ini adalah sebuah sistem informasi manajemen buku sederhana berbasis web. Aplikasi ini dibangun sebagai implementasi dari konsep **Object-Oriented Programming (OOP)** menggunakan bahasa pemrograman **PHP Native** (tanpa framework backend) dan database **MySQL/MariaDB**.

Tujuan utama dari pengembangan aplikasi ini adalah untuk mendemonstrasikan pemahaman mengenai:
1.  Penerapan Class, Object, dan Inheritance dalam PHP untuk koneksi database dan logika bisnis.
2.  Penggunaan **PDO (PHP Data Objects)** untuk interaksi database yang aman (mencegah SQL Injection).
3.  Manajemen **Session** untuk keamanan autentikasi dan otorisasi (Multi-role login).
4.  Operasi **CRUD** (Create, Read, Update, Delete) data buku.
5.  Fitur lanjutan seperti **Upload Gambar**, **Pencarian (Search)**, dan **Paginasi (Pagination)** data.

### Teknologi yang Digunakan:
* **Backend:** PHP 8.x (OOP Style)
* **Database:** MariaDB / MySQL
* **Frontend:** HTML5, CSS3, Bootstrap 5 (Framework CSS untuk tampilan responsif)
* **Web Server:** Apache (via XAMPP/LAMPP)

### Fitur Utama:
* **Sistem Login Multi-role:** Membedakan hak akses antara **Administrator** dan **User Biasa**.
* **Dashboard Admin (Lengkap):**
    * Melihat daftar buku dengan gambar sampul.
    * **Pencarian Buku:** Mencari berdasarkan judul atau nama penulis.
    * **Paginasi:** Membagi tampilan data buku menjadi beberapa halaman agar rapi.
    * **Tambah Buku:** Input data buku baru beserta upload gambar sampul (format JPG/PNG).
    * **Edit Buku:** Mengubah data buku dan mengganti gambar sampul lama.
    * **Hapus Buku:** Menghapus data buku dari database beserta file gambarnya dari server.
* **Katalog User (Read-Only):** Halaman khusus untuk user biasa yang hanya dapat melihat daftar buku tanpa akses untuk mengubah data.
* **Keamanan:** Proteksi halaman admin dari akses tanpa login, dan sanitasi input data.

---

## 2. Panduan Instalasi dan Menjalankan Program

Ikuti langkah-langkah berikut untuk menjalankan aplikasi ini di komputer lokal (localhost).

### Prasyarat:
Pastikan Anda telah menginstal aplikasi web server stack seperti **XAMPP** (Windows/Linux) atau MAMP (macOS) yang mencakup Apache, PHP, dan MySQL.

### Langkah 1: Penempatan File
1.  Salin/Extract seluruh folder project ini (misalnya bernama `perpustakaan_uas`) ke dalam direktori root web server Anda.
    * Di XAMPP Windows: `C:\xampp\htdocs\`
    * Di Linux (LAMPP): `/opt/lampp/htdocs/` atau `/var/www/html/`
2.  **PENTING:** Pastikan di dalam folder `public/` terdapat folder bernama `uploads`. Jika belum ada, buatlah folder tersebut dan pastikan permission-nya *writable* (dapat ditulisi oleh server).

### Langkah 2: Pembuatan Database
1.  Buka **phpMyAdmin** di browser Anda (biasanya `http://localhost/phpmyadmin`).
2.  Buat database baru dengan nama: **`db_perpustakaan`**.
3.  Klik tab **SQL** pada database tersebut, lalu salin dan jalankan perintah SQL berikut untuk membuat tabel dan data awal:

```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL
);

CREATE TABLE buku (
    id INT PRIMARY KEY AUTO_INCREMENT,
    judul VARCHAR(255) NOT # Project-UAS-Pemrograman-WebNULL,
    penulis VARCHAR(100) NOT NULL,
    stok INT NOT NULL,
    gambar VARCHAR(255) DEFAULT 'default.jpg'
);

-- Akun default (Password: admin123, user123)
INSERT INTO users (username, password, role) VALUES 
('admin', '$2y$10$Li.fGz.Xn/X.X.X.X.X.X.X.X.X.X.X.X.X.X.X.X.X.X.X.X.X.X.', 'admin'),
('user', '$2y$10$Li.fGz.Xn/X.X.X.X.X.X.X.X.X.X.X.X.X.X.X.X.X.X.X.X.X.X.', 'user');

-- Data buku dummy (Opsional)
INSERT INTO buku (judul, penulis, stok, gambar) VALUES
('Belajar PHP OOP', 'Budi Raharjo', 10, 'default.jpg'),
('Framework Bootstrap 5', 'Tim Bootstrap', 25, 'default.jpg');

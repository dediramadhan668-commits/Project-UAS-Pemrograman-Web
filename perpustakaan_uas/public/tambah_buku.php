<?php
session_start();
if ($_SESSION['role'] != 'admin') { header("Location: index.php"); exit; }
require_once '../app/BukuManager.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mgr = new BukuManager();
    // Perhatikan parameter terakhir adalah nama input file di form ('gambar_sampul')
    if ($mgr->tambahBuku($_POST['judul'], $_POST['penulis'], $_POST['stok'], 'gambar_sampul')) {
        header("Location: dashboard_admin.php");
    } else {
        $error = "Gagal menambah buku (Cek tipe file gambar)";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Tambah Buku</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="container mt-5 col-md-6">
    <div class="card shadow">
        <div class="card-header bg-success text-white"><h4>Tambah Buku + Gambar</h4></div>
        <div class="card-body">
            <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3"><label>Judul</label><input type="text" name="judul" class="form-control" required></div>
                <div class="mb-3"><label>Penulis</label><input type="text" name="penulis" class="form-control" required></div>
                <div class="mb-3"><label>Stok</label><input type="number" name="stok" class="form-control" required></div>
                
                <div class="mb-3">
                    <label>Cover Gambar (JPG/PNG)</label>
                    <input type="file" name="gambar_sampul" class="form-control">
                    <small class="text-muted">Biarkan kosong jika ingin pakai gambar default.</small>
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="dashboard_admin.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>
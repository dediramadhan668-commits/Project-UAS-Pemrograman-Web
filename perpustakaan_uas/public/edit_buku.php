<?php
session_start();
if ($_SESSION['role'] != 'admin') { header("Location: index.php"); exit; }
require_once '../app/BukuManager.php';

$mgr = new BukuManager();
$buku = $mgr->getBukuById($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($mgr->updateBuku($_POST['id'], $_POST['judul'], $_POST['penulis'], $_POST['stok'], 'gambar_sampul')) {
        header("Location: dashboard_admin.php");
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Edit Buku</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="container mt-5 col-md-6">
    <div class="card shadow">
        <div class="card-header bg-warning"><h4>Edit Buku</h4></div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $buku['id'] ?>">
                <div class="mb-3"><label>Judul</label><input type="text" name="judul" value="<?= $buku['judul'] ?>" class="form-control" required></div>
                <div class="mb-3"><label>Penulis</label><input type="text" name="penulis" value="<?= $buku['penulis'] ?>" class="form-control" required></div>
                <div class="mb-3"><label>Stok</label><input type="number" name="stok" value="<?= $buku['stok'] ?>" class="form-control" required></div>
                
                <div class="mb-3 text-center">
                    <label class="d-block">Gambar Saat Ini:</label>
                    <img src="uploads/<?= $buku['gambar'] ?>" style="height: 100px;" class="rounded border">
                </div>

                <div class="mb-3">
                    <label>Ganti Cover (Opsional)</label>
                    <input type="file" name="gambar_sampul" class="form-control">
                </div>

                <button type="submit" class="btn btn-warning">Update</button>
                <a href="dashboard_admin.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>
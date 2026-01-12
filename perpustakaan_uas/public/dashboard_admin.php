<?php
session_start();
if ($_SESSION['role'] != 'admin') { header("Location: index.php"); exit; }
require_once '../app/BukuManager.php';

// Inisialisasi Manager
$bukuMgr = new BukuManager();

// Ambil parameter dari URL (Search keyword & Halaman saat ini)
$keyword = isset($_GET['q']) ? $_GET['q'] : "";
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5; // Jumlah buku per halaman

// Ambil data dari backend
$result = $bukuMgr->tampilBukuPaginate($keyword, $limit, $page);
$bukuData = $result['data'];
$totalPage = $result['totalPage'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard Admin Advanced</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style> .cover-img { width: 60px; height: 80px; object-fit: cover; } </style>
</head>
<body class="bg-light p-4">
    <div class="container card shadow p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Dashboard Admin</h2>
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <a href="tambah_buku.php" class="btn btn-success"> + Tambah Buku Baru</a>
            </div>
            <div class="col-md-6">
                <form action="" method="GET" class="d-flex">
                    <input type="text" name="q" class="form-control me-2" placeholder="Cari Judul atau Penulis..." value="<?= htmlspecialchars($keyword) ?>">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </form>
            </div>
        </div>

        <table class="table table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Cover</th><th>Judul</th><th>Penulis</th><th>Stok</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($bukuData as $b) : ?>
                <tr>
                    <td class="text-center">
                        <img src="uploads/<?= $b['gambar'] ?>" class="cover-img rounded" alt="Cover">
                    </td>
                    <td><?= $b['judul'] ?></td>
                    <td><?= $b['penulis'] ?></td>
                    <td><?= $b['stok'] ?></td>
                    <td>
                        <a href="edit_buku.php?id=<?= $b['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="hapus_buku.php?id=<?= $b['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <nav>
            <ul class="pagination justify-content-center">
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?q=<?= $keyword ?>&page=<?= $page - 1 ?>">Previous</a>
                </li>
                <?php for($i = 1; $i <= $totalPage; $i++) : ?>
                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                    <a class="page-link" href="?q=<?= $keyword ?>&page=<?= $i ?>"><?= $i ?></a>
                </li>
                <?php endfor; ?>
                <li class="page-item <?= ($page >= $totalPage) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?q=<?= $keyword ?>&page=<?= $page + 1 ?>">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</body>
</html>
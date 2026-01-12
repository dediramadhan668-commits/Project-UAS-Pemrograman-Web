<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Katalog Buku - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-info">
            <h2>Halo, <?php echo $_SESSION['username']; ?>!</h2>
            <p>Anda login sebagai <strong>User</strong>. Anda hanya dapat melihat katalog buku.</p>
        </div>
        <a href="logout.php" class="btn btn-secondary">Logout</a>
    </div>
</body>
</html>
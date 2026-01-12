<?php
session_start();
if ($_SESSION['role'] != 'admin') { header("Location: index.php"); exit; }
require_once '../app/BukuManager.php';

if (isset($_GET['id'])) {
    $mgr = new BukuManager();
    $mgr->hapusBuku($_GET['id']); // Ini akan menghapus data di DB DAN file gambarnya
}
header("Location: dashboard_admin.php");
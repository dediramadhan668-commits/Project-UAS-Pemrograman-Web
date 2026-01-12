<?php
session_start();
require_once '../app/Database.php';

// Class Auth mewarisi koneksi dari Class Database (Konsep OOP)
class Auth extends Database {
    public function login($user, $pass) {
        $sql = "SELECT * FROM users WHERE username = :u AND password = :p";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['u' => $user, 'p' => $pass]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $auth = new Auth();
    $userData = $auth->login($_POST['username'], $_POST['password']);

    if ($userData) {
        $_SESSION['username'] = $userData['username'];
        $_SESSION['role'] = $userData['role'];

        // Pengalihan berdasarkan ROLE (Syarat No. 9)
        if ($userData['role'] == 'admin') {
            header("Location: dashboard_admin.php");
        } else {
            header("Location: katalog_buku.php");
        }
    } else {
        echo "<script>alert('Login Gagal! Username/Password Salah'); window.location='index.php';</script>";
    }
}
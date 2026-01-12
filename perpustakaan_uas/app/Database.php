<?php
class Database {
    private $host = "127.0.0.1"; 
    private $user = "root";
    private $pass = ""; 
    private $db_name = "db_perpustakaan";
    protected $conn;

    public function __construct() {
        try {
            // Kita pakai IP 127.0.0.1 dan port 3306 agar tidak mencari file socket
            $dsn = "mysql:host=127.0.0.1;port=3306;dbname=db_perpustakaan";
            $this->conn = new PDO($dsn, "root", ""); 
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Koneksi Gagal: " . $e->getMessage();
            exit;
        }
    }
}
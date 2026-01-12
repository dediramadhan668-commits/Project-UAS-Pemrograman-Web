<?php
require_once 'Database.php';

class BukuManager extends Database {
    
    // --- FUNGSI BANTUAN: Upload Gambar ---
    private function uploadGambar($fileInputName) {
        $targetDir = "../public/uploads/"; // Folder tujuan
        $fileName = basename($_FILES[$fileInputName]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Jika tidak ada file yang diupload, kembalikan null (pakai default nanti)
        if(empty($fileName)) { return null; }

        // Validasi ekstensi file
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if(in_array(strtolower($fileType), $allowTypes)){
            // Upload file ke server
            if(move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetFilePath)){
                return $fileName; // Kembalikan nama file jika sukses
            }
        }
        return false; // Gagal upload atau tipe salah
    }

    // --- FUNGSI BANTUAN: Hapus Gambar Fisik ---
    private function hapusFileGambar($namaFile) {
        if ($namaFile && $namaFile != 'default.jpg') {
            $filePath = "../public/uploads/" . $namaFile;
            if (file_exists($filePath)) {
                unlink($filePath); // Hapus file dari folder
            }
        }
    }

    // --- CREATE (Tambah Buku dengan Gambar) ---
    public function tambahBuku($judul, $penulis, $stok, $fileInputName) {
        $gambar = $this->uploadGambar($fileInputName);
        // Jika upload gagal/tidak ada, pakai default
        $namaFileGambar = ($gambar) ? $gambar : 'default.jpg';

        $sql = "INSERT INTO buku (judul, penulis, stok, gambar) VALUES (:j, :p, :s, :g)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['j' => $judul, 'p' => $penulis, 's' => $stok, 'g' => $namaFileGambar]);
    }

    // --- READ (Tampil Semua dengan SEARCH & PAGINATION) ---
    public function tampilBukuPaginate($keyword = "", $limit = 5, $page = 1) {
        $offset = ($page - 1) * $limit;
        $searchQuery = "%" . $keyword . "%";

        // Query data dengan filter dan limit
        $sql = "SELECT * FROM buku WHERE judul LIKE :k OR penulis LIKE :k ORDER BY id DESC LIMIT :lim OFFSET :off";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':k', $searchQuery);
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':off', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Query untuk menghitung total data (untuk navigasi halaman)
        $sqlCount = "SELECT COUNT(*) as total FROM buku WHERE judul LIKE :k OR penulis LIKE :k";
        $stmtCount = $this->conn->prepare($sqlCount);
        $stmtCount->bindValue(':k', $searchQuery);
        $stmtCount->execute();
        $totalData = $stmtCount->fetch(PDO::FETCH_ASSOC)['total'];
        $totalPage = ceil($totalData / $limit);

        return [
            'data' => $data,
            'totalPage' => $totalPage,
            'currentPage' => $page,
            'keyword' => $keyword
        ];
    }

    // --- READ SINGLE (Ambil 1 buku untuk Edit) ---
    public function getBukuById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM buku WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // --- UPDATE (Edit Buku dan Ganti Gambar) ---
    public function updateBuku($id, $judul, $penulis, $stok, $fileInputName) {
        // Cek apakah ada gambar baru diupload
        $gambarBaru = $this->uploadGambar($fileInputName);

        if ($gambarBaru) {
            // Ambil nama gambar lama untuk dihapus
            $bukuLama = $this->getBukuById($id);
            $this->hapusFileGambar($bukuLama['gambar']);
            
            $sql = "UPDATE buku SET judul=:j, penulis=:p, stok=:s, gambar=:g WHERE id=:id";
            $params = ['j'=>$judul, 'p'=>$penulis, 's'=>$stok, 'g'=>$gambarBaru, 'id'=>$id];
        } else {
            // Jika tidak update gambar, query tanpa kolom gambar
            $sql = "UPDATE buku SET judul=:j, penulis=:p, stok=:s WHERE id=:id";
            $params = ['j'=>$judul, 'p'=>$penulis, 's'=>$stok, 'id'=>$id];
        }
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    // --- DELETE (Hapus Buku dan Gambarnya) ---
    public function hapusBuku($id) {
        // Ambil data dulu untuk menghapus filenya
        $buku = $this->getBukuById($id);
        $this->hapusFileGambar($buku['gambar']);

        $stmt = $this->conn->prepare("DELETE FROM buku WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'] ?: null;
    $genre = $_POST['genre'];
    $stok = $_POST['stok'] ?: 0;
    $deskripsi = $_POST['deskripsi'];

    // Cek apakah ada file cover baru
    $cover = null;
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['cover']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $newname = time() . '_' . uniqid() . '.' . $ext;
            $upload_dir = '../assets/images/';
            if (move_uploaded_file($_FILES['cover']['tmp_name'], $upload_dir . $newname)) {
                $cover = $newname;
            } else {
                $_SESSION['error'] = "Gagal upload file.";
                header("Location: ../index.php?page=buku&action=edit&id=$id");
                exit;
            }
        } else {
            $_SESSION['error'] = "Ekstensi file tidak diizinkan.";
            header("Location: ../index.php?page=buku&action=edit&id=$id");
            exit;
        }
    }

    if ($cover) {
        $stmt = $conn->prepare("UPDATE buku SET judul=?, penulis=?, penerbit=?, tahun_terbit=?, genre=?, cover=?, stok=?, deskripsi=? WHERE id=?");
        $stmt->bind_param("ssssssisi", $judul, $penulis, $penerbit, $tahun_terbit, $genre, $cover, $stok, $deskripsi, $id);
    } else {
        $stmt = $conn->prepare("UPDATE buku SET judul=?, penulis=?, penerbit=?, tahun_terbit=?, genre=?, stok=?, deskripsi=? WHERE id=?");
        $stmt->bind_param("sssssisi", $judul, $penulis, $penerbit, $tahun_terbit, $genre, $stok, $deskripsi, $id);
    }

    if ($stmt->execute()) {
        $_SESSION['success'] = "Buku berhasil diperbarui.";
        header("Location: ../index.php?page=buku");
    } else {
        $_SESSION['error'] = "Gagal memperbarui buku.";
        header("Location: ../index.php?page=buku&action=edit&id=$id");
    }
    exit;
} else {
    header("Location: ../index.php?page=buku");
    exit;
}

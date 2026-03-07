<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'] ?: null;
    $genre = $_POST['genre'];
    $stok = $_POST['stok'] ?: 0;
    $deskripsi = $_POST['deskripsi'];

    // Upload cover
    $cover = 'default.jpg';
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
                header("Location: ../index.php?page=buku&action=tambah");
                exit;
            }
        } else {
            $_SESSION['error'] = "Ekstensi file tidak diizinkan.";
            header("Location: ../index.php?page=buku&action=tambah");
            exit;
        }
    }

    $stmt = $conn->prepare("INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, genre, cover, stok, deskripsi) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssis", $judul, $penulis, $penerbit, $tahun_terbit, $genre, $cover, $stok, $deskripsi);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Buku berhasil ditambahkan.";
        header("Location: ../index.php?page=buku");
    } else {
        $_SESSION['error'] = "Gagal menambahkan buku: " . $conn->error;
        header("Location: ../index.php?page=buku&action=tambah");
    }
    exit;
} else {
    header("Location: ../index.php?page=buku");
    exit;
}

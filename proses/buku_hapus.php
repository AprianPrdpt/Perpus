<?php
session_start();
require_once '../config/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Cek apakah buku sedang dipinjam?
    $check = $conn->query("SELECT id FROM peminjaman WHERE buku_id = $id AND status='dipinjam'");
    if ($check->num_rows > 0) {
        $_SESSION['error'] = "Buku tidak dapat dihapus karena sedang dipinjam.";
        header("Location: ../index.php?page=buku");
        exit;
    }

    // Ambil nama cover untuk dihapus
    $cover = $conn->query("SELECT cover FROM buku WHERE id = $id")->fetch_assoc();
    if ($cover && $cover['cover'] != 'default.jpg' && file_exists("../assets/images/".$cover['cover'])) {
        unlink("../assets/images/".$cover['cover']);
    }

    $conn->query("DELETE FROM buku WHERE id = $id");
    $_SESSION['success'] = "Buku berhasil dihapus.";
}
header("Location: ../index.php?page=buku");
exit;

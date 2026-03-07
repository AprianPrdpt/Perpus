<?php
session_start();
require_once '../config/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data peminjaman untuk mengembalikan stok jika belum dikembalikan
    $pinjam = $conn->query("SELECT * FROM peminjaman WHERE id = $id")->fetch_assoc();
    if ($pinjam && $pinjam['status'] != 'dikembalikan') {
        // Kembalikan stok
        $conn->query("UPDATE buku SET stok = stok + 1 WHERE id = ".$pinjam['buku_id']);
    }

    // Hapus relasi di pengembalian jika ada
    $conn->query("DELETE FROM pengembalian WHERE peminjaman_id = $id");

    // Hapus peminjaman
    $conn->query("DELETE FROM peminjaman WHERE id = $id");

    $_SESSION['success'] = "Data peminjaman berhasil dihapus.";
}
header("Location: ../index.php?page=peminjaman");
exit;
?>
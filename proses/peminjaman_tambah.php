<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $buku_id = $_POST['buku_id'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_jatuh_tempo = $_POST['tanggal_jatuh_tempo'];

    // Cek stok buku
    $stok = $conn->query("SELECT stok FROM buku WHERE id = $buku_id")->fetch_assoc();
    if ($stok['stok'] <= 0) {
        $_SESSION['error'] = "Stok buku habis.";
        header("Location: ../index.php?page=peminjaman&action=tambah");
        exit;
    }

    // Kurangi stok
    $conn->query("UPDATE buku SET stok = stok - 1 WHERE id = $buku_id");

    // Insert peminjaman
    $stmt = $conn->prepare("INSERT INTO peminjaman (user_id, buku_id, tanggal_pinjam, tanggal_jatuh_tempo, status) VALUES (?, ?, ?, ?, 'dipinjam')");
    $stmt->bind_param("iiss", $user_id, $buku_id, $tanggal_pinjam, $tanggal_jatuh_tempo);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Peminjaman berhasil dicatat.";
        header("Location: ../index.php?page=peminjaman");
    } else {
        // Rollback stok jika gagal
        $conn->query("UPDATE buku SET stok = stok + 1 WHERE id = $buku_id");
        $_SESSION['error'] = "Gagal mencatat peminjaman.";
        header("Location: ../index.php?page=peminjaman&action=tambah");
    }
    exit;
} else {
    header("Location: ../index.php?page=peminjaman");
    exit;
}
?>
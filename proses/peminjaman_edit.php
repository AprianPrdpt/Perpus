<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_jatuh_tempo = $_POST['tanggal_jatuh_tempo'];
    $status = $_POST['status'];
    $tanggal_kembali = $_POST['tanggal_kembali'] ?: null;

    $stmt = $conn->prepare("UPDATE peminjaman SET tanggal_pinjam=?, tanggal_jatuh_tempo=?, status=?, tanggal_kembali=? WHERE id=?");
    $stmt->bind_param("ssssi", $tanggal_pinjam, $tanggal_jatuh_tempo, $status, $tanggal_kembali, $id);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Data peminjaman diperbarui.";
    } else {
        $_SESSION['error'] = "Gagal memperbarui.";
    }
    header("Location: ../index.php?page=peminjaman");
    exit;
} else {
    header("Location: ../index.php?page=peminjaman");
    exit;
}
?>
<?php
session_start();
require_once '../config/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id == $_SESSION['user_id']) {
        $_SESSION['error'] = "Anda tidak dapat menghapus akun sendiri.";
        header("Location: ../index.php?page=user");
        exit;
    }

    // Cek apakah user memiliki peminjaman aktif?
    $check = $conn->query("SELECT id FROM peminjaman WHERE user_id = $id AND status='dipinjam'");
    if ($check->num_rows > 0) {
        $_SESSION['error'] = "User masih memiliki peminjaman aktif, tidak dapat dihapus.";
        header("Location: ../index.php?page=user");
        exit;
    }

    $conn->query("DELETE FROM users WHERE id = $id");
    $_SESSION['success'] = "User berhasil dihapus.";
}
header("Location: ../index.php?page=user");
exit;
?>
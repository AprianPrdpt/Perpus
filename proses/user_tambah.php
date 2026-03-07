<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lengkap = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Cek username sudah ada?
    $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $_SESSION['error'] = "Username sudah digunakan.";
        header("Location: ../index.php?page=user&action=tambah");
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO users (username, password, role, nama_lengkap) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $password, $role, $nama_lengkap);
    if ($stmt->execute()) {
        $_SESSION['success'] = "User berhasil ditambahkan.";
        header("Location: ../index.php?page=user");
    } else {
        $_SESSION['error'] = "Gagal menambahkan user.";
        header("Location: ../index.php?page=user&action=tambah");
    }
    exit;
} else {
    header("Location: ../index.php?page=user");
    exit;
}
?>
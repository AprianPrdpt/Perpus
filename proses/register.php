<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lengkap = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if ($password != $confirm) {
        $_SESSION['error'] = "Password tidak cocok!";
        header("Location: ../index.php?page=register");
        exit;
    }

    // Cek username sudah ada?
    $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $_SESSION['error'] = "Username sudah digunakan!";
        header("Location: ../index.php?page=register");
        exit;
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password, role, nama_lengkap) VALUES (?, ?, 'user', ?)");
    $stmt->bind_param("sss", $username, $hashed, $nama_lengkap);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Pendaftaran berhasil, silakan login.";
        header("Location: ../index.php?page=login");
    } else {
        $_SESSION['error'] = "Gagal mendaftar.";
        header("Location: ../index.php?page=register");
    }
    exit;
}
?>
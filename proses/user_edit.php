<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../index.php?page=user");
    exit;
}

$id = $_POST['id'];
$nama_lengkap = $_POST['nama_lengkap'];
$username = $_POST['username'];
$role = $_POST['role'];
$password = $_POST['password'];
$nim = $_POST['nim'] ?: null;
$jenis_kelamin = $_POST['jenis_kelamin'] ?: null;
$instansi = $_POST['instansi'] ?: null;
$alamat = $_POST['alamat'] ?: null;
$no_telp = $_POST['no_telp'] ?: null;

// Cek username sudah digunakan oleh user lain?
$check = $conn->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
$check->bind_param("si", $username, $id);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    $_SESSION['error'] = "Username sudah digunakan.";
    header("Location: ../index.php?page=user&action=edit&id=$id");
    exit;
}

if (!empty($password)) {
    if (strlen($password) < 6) {
        $_SESSION['error'] = "Password minimal 6 karakter.";
        header("Location: ../index.php?page=user&action=edit&id=$id");
        exit;
    }
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET username=?, password=?, role=?, nama_lengkap=?, nim=?, jenis_kelamin=?, instansi=?, alamat=?, no_telp=? WHERE id=?");
    $stmt->bind_param("sssssssssi", $username, $hashed, $role, $nama_lengkap, $nim, $jenis_kelamin, $instansi, $alamat, $no_telp, $id);
} else {
    $stmt = $conn->prepare("UPDATE users SET username=?, role=?, nama_lengkap=?, nim=?, jenis_kelamin=?, instansi=?, alamat=?, no_telp=? WHERE id=?");
    $stmt->bind_param("ssssssssi", $username, $role, $nama_lengkap, $nim, $jenis_kelamin, $instansi, $alamat, $no_telp, $id);
}

if ($stmt->execute()) {
    $_SESSION['success'] = "User berhasil diperbarui.";
    header("Location: ../index.php?page=user");
} else {
    $_SESSION['error'] = "Gagal memperbarui user: " . $conn->error;
    header("Location: ../index.php?page=user&action=edit&id=$id");
}
exit;
?>
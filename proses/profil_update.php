<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../index.php?page=profil");
    exit;
}

$user_id = $_SESSION['user_id'];
$nama_lengkap = $_POST['nama_lengkap'];
$nim = $_POST['nim'] ?: null;
$jenis_kelamin = $_POST['jenis_kelamin'] ?: null;
$instansi = $_POST['instansi'] ?: null;
$alamat = $_POST['alamat'] ?: null;
$no_telp = $_POST['no_telp'] ?: null;
$password = $_POST['password'];

// Validasi password jika diisi
if (!empty($password)) {
    if (strlen($password) < 6) {
        $_SESSION['error'] = "Password minimal 6 karakter.";
        header("Location: ../index.php?page=profil");
        exit;
    }
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET nama_lengkap=?, nim=?, jenis_kelamin=?, instansi=?, alamat=?, no_telp=?, password=? WHERE id=?");
    $stmt->bind_param("sssssssi", $nama_lengkap, $nim, $jenis_kelamin, $instansi, $alamat, $no_telp, $hashed, $user_id);
} else {
    $stmt = $conn->prepare("UPDATE users SET nama_lengkap=?, nim=?, jenis_kelamin=?, instansi=?, alamat=?, no_telp=? WHERE id=?");
    $stmt->bind_param("ssssssi", $nama_lengkap, $nim, $jenis_kelamin, $instansi, $alamat, $no_telp, $user_id);
}

if ($stmt->execute()) {
    $_SESSION['nama_lengkap'] = $nama_lengkap;
    $_SESSION['success'] = "Profil berhasil diperbarui.";
} else {
    $_SESSION['error'] = "Gagal memperbarui profil: " . $conn->error;
}

header("Location: ../index.php?page=profil");
exit;
?>
<?php
session_start();
require_once '../config/database.php';

if (isset($_GET['id'])) {
    $peminjaman_id = $_GET['id'];

    // Ambil data peminjaman
    $pinjam = $conn->query("SELECT * FROM peminjaman WHERE id = $peminjaman_id")->fetch_assoc();
    if (!$pinjam) {
        $_SESSION['error'] = "Data peminjaman tidak ditemukan.";
        header("Location: ../index.php?page=peminjaman");
        exit;
    }

    // Hitung denda jika terlambat
    $tgl_kembali = date('Y-m-d');
    $denda = 0;
    if ($tgl_kembali > $pinjam['tanggal_jatuh_tempo']) {
        $tgl1 = new DateTime($pinjam['tanggal_jatuh_tempo']);
        $tgl2 = new DateTime($tgl_kembali);
        $selisih = $tgl2->diff($tgl1)->days;
        $denda = $selisih * 1000;
    }

    // Update status peminjaman
    $conn->query("UPDATE peminjaman SET status='dikembalikan', tanggal_kembali='$tgl_kembali' WHERE id=$peminjaman_id");

    // Tambah stok buku
    $conn->query("UPDATE buku SET stok = stok + 1 WHERE id = ".$pinjam['buku_id']);

    // Catat di tabel pengembalian
    $stmt = $conn->prepare("INSERT INTO pengembalian (peminjaman_id, tanggal_kembali, denda) VALUES (?, ?, ?)");
    $stmt->bind_param("isd", $peminjaman_id, $tgl_kembali, $denda);
    $stmt->execute();

    $_SESSION['success'] = "Buku berhasil dikembalikan. Denda: Rp " . number_format($denda,0,',','.');
    header("Location: ../index.php?page=peminjaman");
    exit;
} else {
    header("Location: ../index.php?page=peminjaman");
    exit;
}
?>
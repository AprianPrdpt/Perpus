<?php
session_start();
require_once '../config/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE FROM pengembalian WHERE id = $id");
    $_SESSION['success'] = "Data pengembalian berhasil dihapus.";
}
header("Location: ../index.php?page=pengembalian");
exit;
?>
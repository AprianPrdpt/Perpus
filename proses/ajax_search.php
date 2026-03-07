<?php
require_once '../config/database.php';

$keyword = isset($_GET['q']) ? $_GET['q'] : '';
$genre = isset($_GET['genre']) ? $_GET['genre'] : '';
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';

$sql = "SELECT * FROM buku WHERE (judul LIKE ? OR penulis LIKE ? OR penerbit LIKE ?)";
$params = ["%$keyword%", "%$keyword%", "%$keyword%"];
$types = "sss";

if (!empty($genre)) {
    $sql .= " AND genre = ?";
    $params[] = $genre;
    $types .= "s";
}
if (!empty($tahun)) {
    $sql .= " AND tahun_terbit = ?";
    $params[] = $tahun;
    $types .= "s";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($buku = $result->fetch_assoc()) {
        echo '<div class="col-md-4 mb-3">';
        echo '<div class="card h-100 shadow-sm">';
        echo '<img src="../assets/images/'.$buku['cover'].'" class="card-img-top" style="height:200px; object-fit:cover;">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">'.$buku['judul'].'</h5>';
        echo '<p class="card-text small">'.$buku['penulis'].' - '.$buku['penerbit'].' ('.$buku['tahun_terbit'].')</p>';
        echo '<p class="card-text">Stok: '.$buku['stok'].'</p>';
        if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'user') {
            echo '<a href="proses/pinjam.php?id='.$buku['id'].'" class="btn btn-primary btn-sm">Pinjam</a>';
        }
        echo '</div></div></div>';
    }
} else {
    echo '<p class="text-center">Tidak ada buku ditemukan.</p>';
}
?>
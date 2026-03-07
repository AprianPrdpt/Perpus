<?php
require_once 'config/database.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$result = $conn->query("SELECT * FROM peminjaman WHERE id = $id");
if ($result->num_rows == 0) {
    $_SESSION['error'] = "Data tidak ditemukan.";
    header("Location: index.php?page=peminjaman");
    exit;
}
$pinjam = $result->fetch_assoc();
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Peminjaman</h1>
    <a href="index.php?page=peminjaman" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="proses/peminjaman_edit.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $pinjam['id']; ?>">
            <div class="mb-3">
                <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" value="<?php echo $pinjam['tanggal_pinjam']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_jatuh_tempo" class="form-label">Jatuh Tempo</label>
                <input type="date" class="form-control" id="tanggal_jatuh_tempo" name="tanggal_jatuh_tempo" value="<?php echo $pinjam['tanggal_jatuh_tempo']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="dipinjam" <?php echo ($pinjam['status']=='dipinjam')?'selected':''; ?>>Dipinjam</option>
                    <option value="dikembalikan" <?php echo ($pinjam['status']=='dikembalikan')?'selected':''; ?>>Dikembalikan</option>
                    <option value="terlambat" <?php echo ($pinjam['status']=='terlambat')?'selected':''; ?>>Terlambat</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tanggal_kembali" class="form-label">Tanggal Kembali (jika sudah)</label>
                <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" value="<?php echo $pinjam['tanggal_kembali']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
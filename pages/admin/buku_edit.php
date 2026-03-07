<?php
require_once 'config/database.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$result = $conn->query("SELECT * FROM buku WHERE id = $id");
if ($result->num_rows == 0) {
    $_SESSION['error'] = "Buku tidak ditemukan.";
    header("Location: index.php?page=buku");
    exit;
}
$buku = $result->fetch_assoc();
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Buku</h1>
    <a href="index.php?page=buku" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form action="proses/buku_edit.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $buku['id']; ?>">
            <div class="mb-3">
                <label for="judul" class="form-label">Judul Buku *</label>
                <input type="text" class="form-control" id="judul" name="judul" value="<?php echo htmlspecialchars($buku['judul']); ?>" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="penulis" class="form-label">Penulis</label>
                    <input type="text" class="form-control" id="penulis" name="penulis" value="<?php echo htmlspecialchars($buku['penulis']); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="penerbit" class="form-label">Penerbit</label>
                    <input type="text" class="form-control" id="penerbit" name="penerbit" value="<?php echo htmlspecialchars($buku['penerbit']); ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                    <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" value="<?php echo $buku['tahun_terbit']; ?>" min="1900" max="<?php echo date('Y'); ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="genre" class="form-label">Genre</label>
                    <input type="text" class="form-control" id="genre" name="genre" value="<?php echo htmlspecialchars($buku['genre']); ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" class="form-control" id="stok" name="stok" value="<?php echo $buku['stok']; ?>" min="0">
                </div>
            </div>
            <div class="mb-3">
                <label for="cover" class="form-label">Cover Buku</label>
                <input type="file" class="form-control" id="cover" name="cover" accept="image/*">
                <small class="text-muted">Kosongkan jika tidak ingin mengganti. Cover saat ini: <?php echo $buku['cover']; ?></small>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?php echo htmlspecialchars($buku['deskripsi']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
<?php
require_once 'config/database.php';
$users = $conn->query("SELECT id, nama_lengkap FROM users WHERE role='user' ORDER BY nama_lengkap");
$buku = $conn->query("SELECT id, judul, stok FROM buku WHERE stok > 0 ORDER BY judul");
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Peminjaman</h1>
    <a href="index.php?page=peminjaman" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form action="proses/peminjaman_tambah.php" method="POST">
            <div class="mb-3">
                <label for="user_id" class="form-label">Peminjam</label>
                <select class="form-select" id="user_id" name="user_id" required>
                    <option value="">Pilih User</option>
                    <?php while ($u = $users->fetch_assoc()): ?>
                        <option value="<?php echo $u['id']; ?>"><?php echo htmlspecialchars($u['nama_lengkap']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="buku_id" class="form-label">Buku</label>
                <select class="form-select" id="buku_id" name="buku_id" required>
                    <option value="">Pilih Buku</option>
                    <?php while ($b = $buku->fetch_assoc()): ?>
                        <option value="<?php echo $b['id']; ?>"><?php echo htmlspecialchars($b['judul']); ?> (Stok: <?php echo $b['stok']; ?>)</option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                    <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tanggal_jatuh_tempo" class="form-label">Jatuh Tempo</label>
                    <input type="date" class="form-control" id="tanggal_jatuh_tempo" name="tanggal_jatuh_tempo" value="<?php echo date('Y-m-d', strtotime('+7 days')); ?>" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
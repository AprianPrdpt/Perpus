<?php
require_once 'config/database.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$result = $conn->query("SELECT * FROM users WHERE id = $id");
if ($result->num_rows == 0) {
    $_SESSION['error'] = "User tidak ditemukan.";
    header("Location: index.php?page=user");
    exit;
}
$user = $result->fetch_assoc();
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit User</h1>
    <a href="index.php?page=user" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form action="proses/user_edit.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?php echo htmlspecialchars($user['nama_lengkap']); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nim" class="form-label">No Identitas (NIM/NIK/DSB)</label>
                    <input type="text" class="form-control" id="nim" name="nim" value="<?php echo htmlspecialchars($user['nim'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                        <option value="">-- Pilih --</option>
                        <option value="L" <?php echo ($user['jenis_kelamin'] ?? '') == 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                        <option value="P" <?php echo ($user['jenis_kelamin'] ?? '') == 'P' ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="instansi" class="form-label">Instansi/Sekolah/Universitas</label>
                <input type="text" class="form-control" id="instansi" name="instansi" value="<?php echo htmlspecialchars($user['instansi'] ?? ''); ?>">
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="2"><?php echo htmlspecialchars($user['alamat'] ?? ''); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="no_telp" class="form-label">No. Telepon</label>
                <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?php echo htmlspecialchars($user['no_telp'] ?? ''); ?>">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password Baru (kosongkan jika tidak diubah)</label>
                <input type="password" class="form-control" id="password" name="password">
                <small class="text-muted">Minimal 6 karakter.</small>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="user" <?php echo $user['role'] == 'user' ? 'selected' : ''; ?>>User</option>
                    <option value="resepsionis" <?php echo $user['role'] == 'resepsionis' ? 'selected' : ''; ?>>Resepsionis</option>
                    <option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
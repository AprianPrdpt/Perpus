<?php
require_once 'config/database.php';

$limit = 10;
$page = isset($_GET['hal']) ? (int)$_GET['hal'] : 1;
$offset = ($page - 1) * $limit;

$total = $conn->query("SELECT COUNT(*) FROM peminjaman")->fetch_row()[0];
$total_pages = ceil($total / $limit);

$result = $conn->query("SELECT p.*, u.nama_lengkap, b.judul 
                        FROM peminjaman p
                        JOIN users u ON p.user_id = u.id
                        JOIN buku b ON p.buku_id = b.id
                        ORDER BY p.created_at DESC
                        LIMIT $offset, $limit");
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Peminjaman</h1>
    <a href="index.php?page=peminjaman&action=tambah" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Peminjaman</a>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>#</th>
                <th>Peminjam</th>
                <th>Buku</th>
                <th>Tgl Pinjam</th>
                <th>Jatuh Tempo</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = $offset + 1; while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($row['nama_lengkap']); ?></td>
                <td><?php echo htmlspecialchars($row['judul']); ?></td>
                <td><?php echo $row['tanggal_pinjam']; ?></td>
                <td><?php echo $row['tanggal_jatuh_tempo']; ?></td>
                <td><?php echo $row['tanggal_kembali'] ?: '-'; ?></td>
                <td>
                    <?php
                    $badge = 'warning';
                    if ($row['status'] == 'dikembalikan') $badge = 'success';
                    elseif ($row['status'] == 'terlambat') $badge = 'danger';
                    ?>
                    <span class="badge bg-<?php echo $badge; ?>"><?php echo $row['status']; ?></span>
                </td>
                <td>
                    <a href="index.php?page=peminjaman&action=edit&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                    <?php if ($row['status'] != 'dikembalikan'): ?>
                        <a href="proses/peminjaman_kembali.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success" onclick="return confirm('Tandai sebagai dikembalikan?')"><i class="bi bi-check-circle"></i></a>
                    <?php endif; ?>
                    <a href="proses/peminjaman_hapus.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')"><i class="bi bi-trash"></i></a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?php if ($page > 1): ?>
            <li class="page-item"><a class="page-link" href="index.php?page=peminjaman&hal=<?php echo $page-1; ?>">Previous</a></li>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>"><a class="page-link" href="index.php?page=peminjaman&hal=<?php echo $i; ?>"><?php echo $i; ?></a></li>
        <?php endfor; ?>
        <?php if ($page < $total_pages): ?>
            <li class="page-item"><a class="page-link" href="index.php?page=peminjaman&hal=<?php echo $page+1; ?>">Next</a></li>
        <?php endif; ?>
    </ul>
</nav>
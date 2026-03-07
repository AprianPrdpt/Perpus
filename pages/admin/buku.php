<?php
require_once 'config/database.php';

$limit = 10;
$page = isset($_GET['hal']) ? (int)$_GET['hal'] : 1;
$offset = ($page - 1) * $limit;

$total = $conn->query("SELECT COUNT(*) FROM buku")->fetch_row()[0];
$total_pages = ceil($total / $limit);

$result = $conn->query("SELECT * FROM buku ORDER BY id DESC LIMIT $offset, $limit");
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Buku</h1>
    <a href="index.php?page=buku&action=tambah" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Buku</a>
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
                <th>Cover</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>Genre</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = $offset + 1; while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td>
                    <?php if ($row['cover'] && file_exists("assets/images/".$row['cover'])): ?>
                        <img src="assets/images/<?php echo $row['cover']; ?>" width="50" height="70" style="object-fit: cover;">
                    <?php else: ?>
                        <img src="assets/images/default.jpg" width="50" height="70" style="object-fit: cover;">
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($row['judul']); ?></td>
                <td><?php echo htmlspecialchars($row['penulis']); ?></td>
                <td><?php echo htmlspecialchars($row['penerbit']); ?></td>
                <td><?php echo $row['tahun_terbit']; ?></td>
                <td><?php echo htmlspecialchars($row['genre']); ?></td>
                <td><?php echo $row['stok']; ?></td>
                <td>
                    <a href="index.php?page=buku&action=edit&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                    <a href="proses/buku_hapus.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')"><i class="bi bi-trash"></i></a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?php if ($page > 1): ?>
            <li class="page-item"><a class="page-link" href="index.php?page=buku&hal=<?php echo $page-1; ?>">Previous</a></li>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>"><a class="page-link" href="index.php?page=buku&hal=<?php echo $i; ?>"><?php echo $i; ?></a></li>
        <?php endfor; ?>
        <?php if ($page < $total_pages): ?>
            <li class="page-item"><a class="page-link" href="index.php?page=buku&hal=<?php echo $page+1; ?>">Next</a></li>
        <?php endif; ?>
    </ul>
</nav>
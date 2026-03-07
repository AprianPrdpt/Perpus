<?php
require_once 'config/database.php';
$user_id = $_SESSION['user_id'];

// Semua peminjaman yang sudah dikembalikan
$history = $conn->query("SELECT p.*, b.judul, b.cover, k.denda 
                            FROM peminjaman p 
                            JOIN buku b ON p.buku_id = b.id 
                            LEFT JOIN pengembalian k ON p.id = k.peminjaman_id
                            WHERE p.user_id = $user_id AND p.status = 'dikembalikan'
                            ORDER BY p.tanggal_kembali DESC");
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Histori Peminjaman</h1>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <?php if ($history->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Cover</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $history->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <img src="assets/images/<?php echo $row['cover'] ?: 'default.jpg'; ?>" width="50" height="70" style="object-fit: cover;">
                            </td>
                            <td><?php echo htmlspecialchars($row['judul']); ?></td>
                            <td><?php echo date('d-m-Y', strtotime($row['tanggal_pinjam'])); ?></td>
                            <td><?php echo date('d-m-Y', strtotime($row['tanggal_kembali'])); ?></td>
                            <td>Rp <?php echo number_format($row['denda'], 0, ',', '.'); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted">Belum ada histori peminjaman.</p>
        <?php endif; ?>
    </div>
</div>
<?php
require_once 'config/database.php';
$user_id = $_SESSION['user_id'];

// Peminjaman aktif (belum dikembalikan)
$active_peminjaman = $conn->query("SELECT p.*, b.judul, b.cover 
                                    FROM peminjaman p 
                                    JOIN buku b ON p.buku_id = b.id 
                                    WHERE p.user_id = $user_id AND p.status = 'dipinjam' 
                                    ORDER BY p.tanggal_jatuh_tempo ASC");

$latest_buku = $conn->query("SELECT * FROM buku ORDER BY created_at DESC LIMIT 6");
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard User</h1>
</div>

<!-- Buku yang sedang dipinjam -->
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-book"></i> Buku yang Sedang Dipinjam
            </div>
            <div class="card-body">
                <?php if ($active_peminjaman->num_rows > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Cover</th>
                                    <th>Judul Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $active_peminjaman->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <img src="assets/images/<?php echo $row['cover'] ?: 'default.jpg'; ?>" width="50" height="70" style="object-fit: cover;">
                                    </td>
                                    <td><?php echo htmlspecialchars($row['judul']); ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($row['tanggal_pinjam'])); ?></td>
                                    <td>
                                        <?php 
                                        $tgl_jatuh_tempo = new DateTime($row['tanggal_jatuh_tempo']);
                                        $today = new DateTime();
                                        $class = ($tgl_jatuh_tempo < $today) ? 'text-danger fw-bold' : '';
                                        echo "<span class='$class'>".date('d-m-Y', strtotime($row['tanggal_jatuh_tempo']))."</span>";
                                        ?>
                                    </td>
                                    <td>
                                        <?php if ($tgl_jatuh_tempo < $today): ?>
                                            <span class="badge bg-danger">Terlambat</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Dipinjam</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Anda sedang tidak meminjam buku apapun.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Buku terbaru -->
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <i class="bi bi-stars"></i> Buku Terbaru
            </div>
            <div class="card-body">
                <div class="row">
                    <?php while ($buku = $latest_buku->fetch_assoc()): ?>
                        <div class="col-md-2 col-6 mb-3">
                            <div class="card h-100">
                                <img src="assets/images/<?php echo $buku['cover'] ?: 'default.jpg'; ?>" class="card-img-top" alt="Cover" style="height: 150px; object-fit: cover;">
                                <div class="card-body p-2">
                                    <h6 class="card-title small text-truncate"><?php echo htmlspecialchars($buku['judul']); ?></h6>
                                    <p class="card-text small text-muted"><?php echo htmlspecialchars($buku['penulis']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</div>
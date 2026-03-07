<?php
// pages/admin/dashboard.php
require_once 'config/database.php';

// Hitung statistik
$total_buku = $conn->query("SELECT COUNT(*) FROM buku")->fetch_row()[0];
$total_user = $conn->query("SELECT COUNT(*) FROM users")->fetch_row()[0];
$total_pinjam = $conn->query("SELECT COUNT(*) FROM peminjaman")->fetch_row()[0];
$total_kembali = $conn->query("SELECT COUNT(*) FROM pengembalian")->fetch_row()[0];
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard Admin</h1>
</div>

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Buku</h6>
                        <h2 class="mb-0"><?php echo $total_buku; ?></h2>
                    </div>
                    <i class="bi bi-book fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total User</h6>
                        <h2 class="mb-0"><?php echo $total_user; ?></h2>
                    </div>
                    <i class="bi bi-people fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Peminjaman</h6>
                        <h2 class="mb-0"><?php echo $total_pinjam; ?></h2>
                    </div>
                    <i class="bi bi-arrow-right-circle fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Pengembalian</h6>
                        <h2 class="mb-0"><?php echo $total_kembali; ?></h2>
                    </div>
                    <i class="bi bi-arrow-left-circle fs-1"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Peminjaman Terbaru -->
<div class="card mt-4">
    <div class="card-header">
        <h5>Peminjaman Terbaru</h5>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Peminjam</th>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $pinjam = $conn->query("SELECT p.*, u.nama_lengkap, b.judul FROM peminjaman p 
                                            JOIN users u ON p.user_id = u.id 
                                            JOIN buku b ON p.buku_id = b.id 
                                            ORDER BY p.created_at DESC LIMIT 5");
                $no = 1;
                while ($row = $pinjam->fetch_assoc()):
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row['nama_lengkap']; ?></td>
                    <td><?php echo $row['judul']; ?></td>
                    <td><?php echo $row['tanggal_pinjam']; ?></td>
                    <td><?php echo $row['tanggal_jatuh_tempo']; ?></td>
                    <td><span class="badge bg-<?php echo ($row['status']=='dipinjam')?'warning':'success'; ?>"><?php echo $row['status']; ?></span></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
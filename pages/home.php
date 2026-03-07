<?php

require_once 'config/database.php';
$result = $conn->query("SELECT * FROM buku ORDER BY created_at DESC LIMIT 12");
?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1 class="display-4 fw-bold text-primary">Selamat Datang di DigiLib</h1>
            <p class="lead">Temukan ribuan koleksi buku terbaik untuk menambah wawasanmu.</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <form action="index.php?page=search" method="GET" class="d-flex">
                <input type="hidden" name="page" value="search">
                <input class="form-control form-control-lg me-2" type="search" name="q" placeholder="Cari judul, penulis, penerbit..." aria-label="Search">
                <button class="btn btn-primary btn-lg" type="submit"><i class="bi bi-search"></i> Cari</button>
            </form>
        </div>
    </div>

    <div class="row">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($buku = $result->fetch_assoc()): ?>
                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="assets/images/<?php echo $buku['cover']; ?>" class="card-img-top" alt="<?php echo $buku['judul']; ?>" style="height: 180px; object-fit: cover;">
                        <div class="card-body">
                            <h6 class="card-title text-truncate"><?php echo $buku['judul']; ?></h6>
                            <p class="card-text small text-muted"><?php echo $buku['penulis']; ?></p>
                            <span class="badge bg-info"><?php echo $buku['genre']; ?></span>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">Belum ada buku tersedia.</p>
        <?php endif; ?>
    </div>
</div>
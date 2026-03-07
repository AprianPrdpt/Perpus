<?php
$role = $_SESSION['role'];
?>
<div class="col-md-3 col-lg-2 px-0 bg-white shadow-sm" style="min-height: 100vh;">
    <div class="d-flex flex-column p-3">
        <a href="index.php?page=dashboard" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
            <i class="bi bi-book-half fs-4 me-2"></i>
            <span class="fs-5 fw-semibold">DigiLib</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <?php if ($role == 'admin'): ?>
                <li class="nav-item">
                    <a href="index.php?page=dashboard" class="nav-link <?php echo ($_GET['page'] ?? '') == 'dashboard' ? 'active' : ''; ?>">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="index.php?page=buku" class="nav-link <?php echo ($_GET['page'] ?? '') == 'buku' ? 'active' : ''; ?>">
                        <i class="bi bi-book me-2"></i> Kelola Buku
                    </a>
                </li>
                <li>
                    <a href="index.php?page=user" class="nav-link <?php echo ($_GET['page'] ?? '') == 'user' ? 'active' : ''; ?>">
                        <i class="bi bi-people me-2"></i> Kelola User
                    </a>
                </li>
                <li>
                    <a href="index.php?page=peminjaman" class="nav-link <?php echo ($_GET['page'] ?? '') == 'peminjaman' ? 'active' : ''; ?>">
                        <i class="bi bi-arrow-right-circle me-2"></i> Peminjaman
                    </a>
                </li>
                <li>
                    <a href="index.php?page=pengembalian" class="nav-link <?php echo ($_GET['page'] ?? '') == 'pengembalian' ? 'active' : ''; ?>">
                        <i class="bi bi-arrow-left-circle me-2"></i> Pengembalian
                    </a>
                </li>
            <?php elseif ($role == 'user'): ?>
                <li class="nav-item">
                    <a href="index.php?page=dashboard" class="nav-link <?php echo ($_GET['page'] ?? '') == 'dashboard' ? 'active' : ''; ?>">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="index.php?page=search" class="nav-link <?php echo ($_GET['page'] ?? '') == 'search' ? 'active' : ''; ?>">
                        <i class="bi bi-search me-2"></i> Cari Buku
                    </a>
                </li>
                <li>
                    <a href="index.php?page=history" class="nav-link <?php echo ($_GET['page'] ?? '') == 'history' ? 'active' : ''; ?>">
                        <i class="bi bi-clock-history me-2"></i> Histori Peminjaman
                    </a>
                </li>
            <?php endif; ?>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle me-2"></i>
                <strong><?php echo $_SESSION['nama_lengkap']; ?></strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="index.php?page=profil">Profil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="proses/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</div>
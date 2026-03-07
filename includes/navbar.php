<?php
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php?page=home">
            <i class="bi bi-book-half"></i> DigiLib
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=home">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=search">Cari Buku</a>
                </li>
            </ul>
            <form class="d-flex me-3" action="index.php?page=search" method="GET">
                <input class="form-control me-2" type="search" name="q" placeholder="Cari buku..." aria-label="Search">
                <button class="btn btn-outline-light" type="submit"><i class="bi bi-search"></i></button>
            </form>
            <?php if (isset($_SESSION['user_id'])): ?>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> <?php echo $_SESSION['nama_lengkap']; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="index.php?page=dashboard">Dashboard</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="proses/logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            <?php else: ?>
                <a href="index.php?page=login" class="btn btn-outline-light">Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
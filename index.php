<?php
session_start();
require_once 'config/database.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
    </style>
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php 
        if (isset($_SESSION['user_id'])) {
            include 'includes/sidebar.php'; 
            $content_class = "col-md-9 ms-sm-auto col-lg-10 px-md-4";
        } else {
            $content_class = "col-12";
        }
        ?>
        <main class="<?php echo $content_class; ?>">
            <?php
            if (!isset($_SESSION['user_id']) && !in_array($page, ['home', 'login', 'register', 'search'])) {
                header("Location: index.php?page=login");
                exit;
            }

            $role = $_SESSION['role'] ?? 'guest';
            $file = '';

            if ($page == 'home') $file = 'pages/home.php';
            elseif ($page == 'login') $file = 'pages/login.php';
            elseif ($page == 'register') $file = 'pages/register.php';
            elseif ($page == 'search') $file = 'pages/search.php';
            elseif ($page == 'dashboard') {
                if ($role == 'admin') $file = 'pages/admin/dashboard.php';
                elseif ($role == 'resepsionis') $file = 'pages/resepsionis/dashboard.php';
                elseif ($role == 'user') $file = 'pages/user/dashboard.php';
            }
            elseif ($page == 'buku') {
                if ($role == 'admin') {
                    if (isset($_GET['action']) && $_GET['action'] == 'tambah') $file = 'pages/admin/buku_tambah.php';
                    elseif (isset($_GET['action']) && $_GET['action'] == 'edit') $file = 'pages/admin/buku_edit.php';
                    else $file = 'pages/admin/buku.php';
                } 
            }
            elseif ($page == 'user') {
                if ($role == 'admin') {
                    if (isset($_GET['action']) && $_GET['action'] == 'tambah') $file = 'pages/admin/user_tambah.php';
                    elseif (isset($_GET['action']) && $_GET['action'] == 'edit') $file = 'pages/admin/user_edit.php';
                    else $file = 'pages/admin/user.php';
                } 
            }
            elseif ($page == 'peminjaman') {
                if ($role == 'admin') {
                    if (isset($_GET['action']) && $_GET['action'] == 'tambah') $file = 'pages/admin/peminjaman_tambah.php';
                    elseif (isset($_GET['action']) && $_GET['action'] == 'edit') $file = 'pages/admin/peminjaman_edit.php';
                    else $file = 'pages/admin/peminjaman.php';
                } 
            }
            elseif ($page == 'pengembalian') {
                if ($role == 'admin') {
                    $file = 'pages/admin/pengembalian.php';
                } 
            }
            elseif ($page == 'history') {
                if ($role == 'user') $file = 'pages/user/history.php';
            }
            elseif ($page == 'profil') {
                if (isset($_SESSION['user_id'])) {
                    $file = 'pages/profil.php';
                } else {
                    header("Location: index.php?page=login");
                    exit;
                }
            }

            if (file_exists($file)) {
                include $file;
            } else {
                echo "<div class='alert alert-danger'>Halaman tidak ditemukan.</div>";
            } 
            ?>
        </main>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
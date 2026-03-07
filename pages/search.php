<?php
// pages/search.php
require_once 'config/database.php';
$keyword = isset($_GET['q']) ? $_GET['q'] : '';
$genre = isset($_GET['genre']) ? $_GET['genre'] : '';
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';

$sql = "SELECT * FROM buku WHERE (judul LIKE ? OR penulis LIKE ? OR penerbit LIKE ?)";
$params = ["%$keyword%", "%$keyword%", "%$keyword%"];
$types = "sss";

if (!empty($genre)) {
    $sql .= " AND genre = ?";
    $params[] = $genre;
    $types .= "s";
}
if (!empty($tahun)) {
    $sql .= " AND tahun_terbit = ?";
    $params[] = $tahun;
    $types .= "s";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-funnel"></i> Filter Pencarian
                </div>
                <div class="card-body">
                    <form method="GET" action="index.php">
                        <input type="hidden" name="page" value="search">
                        <div class="mb-3">
                            <label for="q" class="form-label">Kata Kunci</label>
                            <input type="text" class="form-control" id="q" name="q" value="<?php echo htmlspecialchars($keyword); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="genre" class="form-label">Genre</label>
                            <select class="form-select" id="genre" name="genre">
                                <option value="">Semua Genre</option>
                                <?php
                                $genreQuery = $conn->query("SELECT DISTINCT genre FROM buku WHERE genre IS NOT NULL");
                                while ($g = $genreQuery->fetch_assoc()) {
                                    $selected = ($g['genre'] == $genre) ? 'selected' : '';
                                    echo "<option value='{$g['genre']}' $selected>{$g['genre']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <input type="number" class="form-control" id="tahun" name="tahun" value="<?php echo htmlspecialchars($tahun); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Terapkan Filter</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Hasil Pencarian untuk "<?php echo htmlspecialchars($keyword); ?>"</h4>
                <span class="badge bg-secondary"><?php echo $result->num_rows; ?> buku ditemukan</span>
            </div>
            <div class="row" id="search-results">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($buku = $result->fetch_assoc()): ?>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100 shadow-sm">
                                <img src="assets/images/<?php echo $buku['cover']; ?>" class="card-img-top" alt="Cover" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $buku['judul']; ?></h5>
                                    <p class="card-text small"><?php echo $buku['penulis']; ?> - <?php echo $buku['penerbit']; ?> (<?php echo $buku['tahun_terbit']; ?>)</p>
                                    <p class="card-text">Stok: <?php echo $buku['stok']; ?></p>
                                    <?php if (isset($_SESSION['user_id']) && in_array($_SESSION['role'], ['admin'])): ?>
                                        <a href="proses/peminjaman_tambah.php?id=<?php echo $buku['id']; ?>" class="btn btn-primary btn-sm">Pinjam</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-center">Tidak ada buku yang ditemukan.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#q, #genre, #tahun').on('input change', function() {
        var keyword = $('#q').val();
        var genre = $('#genre').val();
        var tahun = $('#tahun').val();
        $.ajax({
            url: 'proses/ajax_search.php',
            method: 'GET',
            data: { q: keyword, genre: genre, tahun: tahun },
            success: function(response) {
                $('#search-results').html(response);
            }
        });
    });
});
</script>
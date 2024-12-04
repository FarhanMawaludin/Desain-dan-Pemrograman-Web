<?php
require 'config/db.php';

// Inisialisasi variabel untuk hasil pencarian
$searchQuery = isset($_GET['search']) ? $_GET['search'] : "";
$collection = $db->news;

// Jika ada pencarian, gunakan filter
if ($searchQuery) {
    $cursor = $collection->find(
        [
            '$or' => [
                ['title' => new MongoDB\BSON\Regex($searchQuery, 'i')], // Cari di judul
                ['content' => new MongoDB\BSON\Regex($searchQuery, 'i')] // Cari di konten
            ]
        ],
        ['sort' => ['created_at' => -1]]
    );
} else {
    // Jika tidak ada pencarian, tampilkan semua berita
    $cursor = $collection->find([], ['sort' => ['created_at' => -1]]);
}

// Ubah cursor ke array untuk iterasi dan penghitungan
$newsList = iterator_to_array($cursor);
?>

<!DOCTYPE html>
<html>
<head>
    <title>News App</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">News App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <form class="d-flex ms-auto" method="GET" action="index.php">
                    <input class="form-control me-2" type="search" name="search" placeholder="Cari berita..." value="<?= htmlspecialchars($searchQuery) ?>" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Cari</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Konten -->
    <div class="container mt-4">
        <h1 class="mb-4">Daftar Berita</h1>
        <?php if ($searchQuery): ?>
            <p>Hasil pencarian untuk: <strong><?= htmlspecialchars($searchQuery) ?></strong></p>
        <?php endif; ?>
        <div class="row">
            <?php foreach ($newsList as $news): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= $news['title'] ?></h5>
                            <p class="card-text"><?= $news['summary'] ?></p>
                            <a href="detail.php?id=<?= $news['_id'] ?>" class="btn btn-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if (count($newsList) == 0): ?>
            <p class="text-muted">Tidak ada berita yang ditemukan.</p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

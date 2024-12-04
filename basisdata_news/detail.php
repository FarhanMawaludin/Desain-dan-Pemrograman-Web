<?php
require 'config/db.php';

// Pastikan ID berita ada di URL
if (isset($_GET['id'])) {
    $id = new MongoDB\BSON\ObjectId($_GET['id']);
    $collection = $db->news;

    // Ambil berita berdasarkan ID
    $news = $collection->findOne(['_id' => $id]);

    // Jika berita tidak ditemukan
    if (!$news) {
        echo "<p>Berita tidak ditemukan.</p>";
        exit;
    }
} else {
    echo "<p>ID berita tidak tersedia.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($news['title']) ?></title>
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
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Berita</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Detail Berita -->
    <div class="container mt-4">
        <h1 class="mb-4"><?= htmlspecialchars($news['title']) ?></h1>
        <p><strong>Kategori:</strong> <?= htmlspecialchars($news['category']) ?></p>
        <p><strong>Penulis:</strong> <?= htmlspecialchars($news['author']) ?></p>
        <p><strong>Tanggal:</strong> <?= $news['created_at']->toDateTime()->format('Y-m-d H:i:s') ?></p>
        <p><strong>Ringkasan:</strong> <?= htmlspecialchars($news['summary']) ?></p>
        <h3>Konten:</h3>
        <p><?= nl2br(htmlspecialchars($news['content'])) ?></p>
        <a href="index.php" class="btn btn-secondary mt-3">Kembali ke Berita</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

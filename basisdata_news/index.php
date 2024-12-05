<?php
require 'config/db.php';

$searchQuery = isset($_GET['search']) ? $_GET['search'] : "";
$collection = $db->news;

if ($searchQuery) {
    $cursor = $collection->find(
        [
            '$or' => [
                ['title' => new MongoDB\BSON\Regex($searchQuery, 'i')],
                ['content' => new MongoDB\BSON\Regex($searchQuery, 'i')]
            ]
        ],
        ['sort' => ['created_at' => -1]]
    );
} else {
    $cursor = $collection->find([], ['sort' => ['created_at' => -1]]);
}

$newsList = iterator_to_array($cursor);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News++</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
    .custom-container {
        max-width: 100%;
        margin: 0 auto;
        padding: 0 120px;
    }

    .card-text-custom {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .featured-card {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
    }

    .featured-card img {
        filter: brightness(70%);
        width: 100%;
        height: auto;
    }

    .featured-card .card-img-overlay {
        background: rgba(0, 0, 0, 0.6);
        color: white;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <div class="container custom-container">
            <a class="navbar-brand fw-bold text-danger" href="index.php" style="font-size: 36px;">PoliNews</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">All</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Kategori</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Olahraga</a>
                            <a class="dropdown-item" href="#">Pendidikan</a>
                            <a class="dropdown-item" href="#">Teknologi</a>
                        </div>
                    </li>
                </ul>
                <form class="d-flex" method="get" action="index.php">
                    <input class="form-control me-2" type="search" name="search" placeholder="Search"
                        value="<?= htmlspecialchars($searchQuery) ?>">
                    <button class="btn btn-outline-danger" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container custom-container mt-3">
        <div class="jumbotron jumbotron-fluid text-center py-4"
            style="background: rgba(234, 234, 234, 0.5); border-radius: 10px;">
            <div class="judul fw-bold" style="font-size: 20px;">Selamat Datang, di <span class="text-danger">PoliNews
            </div>
            <div class="judul fw-bold" style="font-size: 32px;">Sumber Berita Terpercaya, Aktual, dan Berimbang</div>
            <div class="judul text-danger fw-semibold text-danger">Tetap terhubung dengan informasi terkini, inspirasi,
                dan analisis mendalam di POLINEMA</div>
        </div>

        <div class=" mt-4">
            <div class="">
                <?php if ($searchQuery): ?>
                <h5>Hasil pencarian untuk: <strong><?= htmlspecialchars($searchQuery) ?></strong></h5>
                <?php endif; ?>

                <?php if (count($newsList) > 0): ?>
                <div class="featured-card mb-4">
                    <img src="<?= isset($newsList[0]['image']) ? 'images/' . $newsList[0]['image'] : 'https://placehold.co/300x200' ?>"
                        class="card-img-top" alt="News Image">
                    <div class="card-img-overlay d-flex flex-column justify-content-end py-3 px-3">
                        <span class="badge bg-danger mb-2"
                            style="width: fit-content;"><?= $newsList[0]['category'] ?? 'Kategori' ?></span>
                        <h5 class="card-title fw-bold mb-1"><?= $newsList[0]['title'] ?></h5>
                        <p class="card-text card-text-custom fs-6" style="line-height: 1.5;">
                            <?= $newsList[0]['summary'] ?? '' ?></p>
                    </div>
                </div>


                <?php else: ?>
                <p class="text-muted">Tidak ada berita yang ditemukan.</p>
                <?php endif; ?>
            </div>

        </div>
        <div class="row">
            <h5>Top Stories</h5>
            <?php foreach ($newsList as $news): ?>
            <div class="col-md-3 mb-4">

                <div class="card">
                    <img src="<?= isset($news['image']) ? 'images/' . $news['image'] : 'https://placehold.co/300x200' ?>"
                        class="card-img-top" alt="News Image">
                    <div class="card-body">
                        <h5 class="card-title"><?= $news['title'] ?></h5>
                        <p class="card-text card-text-custom"><?= $news['summary'] ?></p>
                        <a href="detail.php?id=<?= $news['_id'] ?>" class="btn btn-danger">Selengkapnya</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
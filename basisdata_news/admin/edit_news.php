<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$message = ""; // Variabel untuk pesan pemberitahuan

// Validasi ID dari URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID berita tidak valid.");
}
$id = new MongoDB\BSON\ObjectId($_GET['id']);
$news = $db->news->findOne(['_id' => $id]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $collection = $db->news;

    // Cek apakah file dipilih
    if (!empty($_FILES["image"]["name"])) {
        $local_file = $_FILES["image"]["name"]; // Hanya menyimpan nama file lokal
    } else {
        $local_file = $news['image'] ?? ''; // Gunakan data gambar lama jika tidak ada yang dipilih
    }

    // Update database
    $result = $collection->updateOne(
        ['_id' => $id],
        [
            '$set' => [
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'summary' => $_POST['summary'],
                'author' => $_POST['author'],
                'category' => $_POST['category'],
                'updated_at' => new MongoDB\BSON\UTCDateTime(),
                'image' => $local_file // Simpan nama file
            ]
        ]
    );
    $message = "Berita berhasil diupdate!";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Berita</title>
    <script>
        // Fungsi untuk menampilkan alert jika ada pesan
        function showMessage(message) {
            if (message) {
                alert(message);
            }
        }
    </script>
</head>

<body onload="showMessage('<?= $message ?>')">
    <h1>Edit Berita</h1>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $news['_id'] ?>">
        <label>Judul:</label><br>
        <input type="text" name="title" value="<?= htmlspecialchars($news['title'] ?? '') ?>" required><br>
        <label>Konten:</label><br>
        <textarea name="content" required><?= htmlspecialchars($news['content'] ?? '') ?></textarea><br>
        <label>Ringkasan:</label><br>
        <textarea name="summary" required><?= htmlspecialchars($news['summary'] ?? '') ?></textarea><br>
        <label>Penulis:</label><br>
        <input type="text" name="author" value="<?= htmlspecialchars($news['author'] ?? '') ?>" required><br>
        <label>Kategori:</label>
        <select class="form-select" id="category" name="category" required>
            <option value="">Pilih Kategori</option>
            <option value="politik" <?= $news['category'] === 'politik' ? 'selected' : '' ?>>Politik</option>
            <option value="bencana" <?= $news['category'] === 'bencana' ? 'selected' : '' ?>>Bencana</option>
            <option value="lalu-lintas" <?= $news['category'] === 'lalu-lintas' ? 'selected' : '' ?>>Lalu Lintas</option>
            <option value="pendidikan" <?= $news['category'] === 'pendidikan' ? 'selected' : '' ?>>Pendidikan</option>
        </select><br>
        <label>Gambar:</label>
        <input type="file" class="form-control" id="image" name="image" accept=".jpg, .jpeg, .png, .gif"><br>
        <button type="submit">Simpan</button>
    </form>
</body>

</html>

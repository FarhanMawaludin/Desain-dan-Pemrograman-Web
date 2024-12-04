<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$collection = $db->news;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = new MongoDB\BSON\ObjectId($_POST['id']);
    $collection->updateOne(
        ['_id' => $id],
        ['$set' => [
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'summary' => $_POST['summary'],
            'author' => $_POST['author'],
            'category' => $_POST['category'],
            'updated_at' => new MongoDB\BSON\UTCDateTime()
        ]]
    );
    header("Location: manage_news.php");
    exit();
}

$id = new MongoDB\BSON\ObjectId($_GET['id']);
$news = $collection->findOne(['_id' => $id]);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Berita</title>
</head>
<body>
    <h1>Edit Berita</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $news['_id'] ?>">
        <label>Judul:</label><br>
        <input type="text" name="title" value="<?= $news['title'] ?>" required><br>
        <label>Konten:</label><br>
        <textarea name="content" required><?= $news['content'] ?></textarea><br>
        <label>Ringkasan:</label><br>
        <textarea name="summary" required><?= $news['summary'] ?></textarea><br>
        <label>Penulis:</label><br>
        <input type="text" name="author" value="<?= $news['author'] ?>" required><br>
        <label>Kategori:</label><br>
        <input type="text" name="category" value="<?= $news['category'] ?>" required><br>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>

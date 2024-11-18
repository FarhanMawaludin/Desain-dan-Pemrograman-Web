<?php
require 'db.php';

// Get database connection and fetch posts
$db = getDB();
$posts = $db->posts->find();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Postingan Blog</title>
</head>
<body>
    <h1>Daftar Postingan Blog</h1>
    <a href="create.php">Buat Postingan Baru</a>
    <hr>
    <?php foreach($posts as $post): ?>
        <div class="post">
            <h2><?= htmlspecialchars($post['title']) ?></h2>
            <p>
                <?= nl2br(htmlspecialchars($post['content'])) ?>
            </p>
            <a href="edit.php?id=<?= $post['_id'] ?>">Edit</a>
            <a href="delete.php?id=<?= $post['_id'] ?>">Delete</a>
        </div>
        <hr>
    <?php endforeach; ?>
</body>
</html>
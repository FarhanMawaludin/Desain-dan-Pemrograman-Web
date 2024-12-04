<?php 
require 'db.php'; 
$db = getDB(); 
$collection = $db->posts; 
 
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) { 
    $id = new MongoDB\BSON\ObjectId($_GET['id']); 
    $post = $collection->findOne(['_id' => $id]); 
} 
 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) { 
    $id = new MongoDB\BSON\ObjectId($_POST['id']); 
    $collection->updateOne( 
        ['_id' => $id], 
        ['$set' => ['title' => $_POST['title'], 'content' => 
$_POST['content']]] 
    ); 
    header("Location: index.php"); 
    exit(); 
} 
?> 
 
<!DOCTYPE html> 
<html lang="id"> 
<head> 
    <meta charset="UTF-8"> 
    <title>Edit Postingan</title> 
    <link rel="stylesheet" href="style.css"> 
</head> 
<body> 
    <h1>Edit Postingan</h1> 
    <form method="post"> 
        <input type="hidden" name="id" value="<?php echo 
$post['_id']; ?>"> 
        <input type="text" name="title" value="<?php echo 
htmlspecialchars($post['title']); ?>" required> 
        <textarea name="content" required><?php echo 
htmlspecialchars($post['content']); ?></textarea> 
        <button type="submit">Perbarui</button> 
    </form> 
    <a href="index.php">Kembali ke Daftar Postingan</a> 
</body> 
</html> 
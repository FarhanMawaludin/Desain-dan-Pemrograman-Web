<?php 
require 'db.php'; 
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $db = getDB(); 
    $collection = $db->posts; 
 
    $insertResult = $collection->insertOne([ 
        'title' => $_POST['title'], 
        'content' => $_POST['content'], 
        'date' => new MongoDB\BSON\UTCDateTime() 
    ]); 
 
    header("Location: index.php"); 
    exit(); 
} 
?> 
 
<!DOCTYPE html> 
<html lang="id"> 
<head> 
    <meta charset="UTF-8"> 
    <title>Buat Postingan Baru</title> 
    <link rel="stylesheet" href="style.css"> 
</head> 
<body> 
    <h1>Buat Postingan Baru</h1> 
    <form method="post"> 
        <input type="text" name="title" placeholder="Judul" required> 
        <textarea name="content" placeholder="Konten" 
required></textarea> 
        <button type="submit">Buat</button> 
    </form> 
    <a href="index.php">Kembali ke Daftar Postingan</a> 
</body> 
</html>
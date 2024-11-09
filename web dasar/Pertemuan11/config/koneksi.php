<?php
date_default_timezone_set('Asia/Jakarta');
$koneksi = new mysqli('localhost', 'root', '', 'prakwebdb2');

if(mysqli_connect_errno()) {
    die("Gagal terhubung ke database: " . mysqli_connect_error());   
}
?>
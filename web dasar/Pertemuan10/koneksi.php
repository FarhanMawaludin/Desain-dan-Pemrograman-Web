<?php
$koneksi = mysqli_connect("localhost", "root", "", "prakwebdb");

if(mysqli_connect_errno()) {
    die("Gagal terhubung ke database: " . mysqli_connect_error());
}

?>
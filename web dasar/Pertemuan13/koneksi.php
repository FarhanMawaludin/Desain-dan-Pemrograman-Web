<?php
$host = "LAPTOP-CACRPO0M\SQLEXPRESS";
$connInfo = array("Database" => "prakwebdb", "UID" => "", "PWD" => ""); 
$koneksi = sqlsrv_connect($host, $connInfo); 

if ($koneksi) { 
    echo "Koneksi Berhasil. <br>";
}else{
    echo "Koneksi Gagal. <br>";
    die( print_r( sqlsrv_errors(), true));
}

?>
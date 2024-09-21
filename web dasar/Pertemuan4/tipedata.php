<?php
$a = 10;
$b = 5;
$c = $a + 5;
$d = $b + (10*5);
$e = $d - $c;
echo "variabel a: {$a} <br>";
echo "variabel b: {$b} <br>";
echo "variabel c: {$c} <br>";
echo "variabel d: {$d} <br>";
echo "variabel e: {$e} <br>";

var_dump($e);


$nilaiMatematika = 5.1;
$nilaiIpa = 6.7;
$nilaiBahasa = 9.3;

$rata = ($nilaiMatematika + $nilaiIpa + $nilaiBahasa)/3;
echo "<br><br> Matematika : {$nilaiMatematika} <br>";
echo "Ipa : {$nilaiIpa} <br>";
echo "Bahasa Indonesia : {$nilaiBahasa} <br>";
echo "Rata-rata : {$rata} <br>";
var_dump($rata);

$apakahSiswaLulus = true;
$apakahSiswaSudahUjian = false;
echo "<br><br>";
var_dump($apakahSiswaLulus);
echo "<br>";
var_dump($apakahSiswaSudahUjian);

$namaDepan = "ibnu";
$namaBelakang = "jakaria";

$namaLengkap = "{$namaDepan} {$namaBelakang}";
$namaLengkap2 = $namaDepan . ' ' . $namaBelakang;

echo "<br><br> Nama depan: {$namaDepan} <br>";
echo 'Nama Belakang: ' . $namaBelakang . '<br>';

echo $namaLengkap;

$listMahasiswa = ["Wahid abdullah","Elmo Bachtiar","Lendis Fabri"];
echo "<br><br>";
echo $listMahasiswa[0];
?>
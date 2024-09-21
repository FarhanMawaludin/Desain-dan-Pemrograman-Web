<?php
$a = 10;
$b = 5;

$hasilTambah = $a + $b;
$hasilKurang = $a - $b;
$hasilKali = $a * $b;
$hasilBagi = $a / $b;
$modulo = $a % $b;
$pangkat = $a ** $b;

echo "Hasil Tambah : $hasilTambah";
echo "<br>";
echo "Hasil Kurang : $hasilKurang";
echo "<br>";
echo "Hasil Kali : $hasilKali";
echo "<br>";
echo "Hasil Bagi : $hasilBagi";
echo "<br>";
echo "Hasil Modulo : $modulo";
echo "<br>";
echo "Hasil Pangkat : $pangkat";

echo "<br><br>";

$hasilSama = $a == $b;
$hasilTidakSama = $a != $b;
$hasilLebihKecil = $a < $b;
$hasilLebihBesar = $a > $b;
$kurangLebihKecilSama = $a <= $b;
$kurangLebihBesarSama = $a >= $b;

echo "hasil == : $hasilSama";
echo "<br>";
echo "hasil != : $hasilTidakSama";
echo "<br>";
echo "hasil < : $hasilLebihKecil";
echo "<br>";
echo "hasil > : $hasilLebihBesar";
echo "<br>";
echo "hasil <= : $kurangLebihKecilSama";
echo "<br>";
echo "hasil >= : $kurangLebihBesarSama";

echo "<br><br>";

$hasilAnd = $a && $b;
$hasilOr = $a || $b;
$hasilNotA = !$a;
$hasilNotB = !$b;

echo "Hasil AND : $hasilAnd";
echo "<br>";
echo "Hasil OR : $hasilOr";
echo "<br>";
echo "Hasil NOT A : $hasilNotA";
echo "<br>";
echo "Hasil NOT B : $hasilNotB";

echo "<br><br>";

$a += $b;
echo "hasil A += B = $a <br>";
$a -+ $b;
echo "hasil A -= B= $a <br>";
$a *= $b;
echo "hasil A *= B= $a <br>";
$a /= $b;
echo "hasil A /= B= $a <br>";
$a %= $b;
echo "hasil A %= B= $a <br>";

echo "<br>";

$hasilIdentik = $a === $b;
$hasilTidakIdentik = $a !== $b;
echo "Identik : $hasilIdentik <br>";
echo "kurang Identik : $hasilTidakIdentik <br>";




?>
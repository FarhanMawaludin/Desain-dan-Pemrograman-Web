<?php
$nilai = [85,92,78,64,90,75,88,79,70,96];

sort($nilai);

echo "Nilai terkecil ke-1: " . $nilai[0] . "<br>";
echo "Nilai terkecil ke-2: " . $nilai[1] . "<br>";
echo "Nilai terbesar ke-1: " . $nilai[count($nilai) - 1] . "<br>";
echo "Nilai terbesar ke-2: " . $nilai[count($nilai) - 2] . "<br>";


$nilai_filtered = array_slice($nilai, 2, -2);



$total_nilai = 0;
for ($i = 0; $i < count($nilai_filtered); $i++) {
    $total_nilai += $nilai_filtered[$i];
}

$rata_rata = $total_nilai / count($nilai_filtered);

echo "Rata-rata nilai setelah mengabaikan 2 nilai tertinggi dan terendah: " . $rata_rata;

?>
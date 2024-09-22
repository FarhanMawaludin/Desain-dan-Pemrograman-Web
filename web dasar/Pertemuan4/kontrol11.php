<?php
$nilai = [85,92,78,64,90,75,88,79,70,96];


$panjangnilai = 0;
foreach ($nilai as $n) {
    $panjangnilai++;
}


for ($i = 0; $i < $panjangnilai - 1; $i++) {
    for ($j = 0; $j < $panjangnilai - 1 - $i; $j++) {
        if ($nilai[$j] > $nilai[$j + 1]) {
            $temp = $nilai[$j];
            $nilai[$j] = $nilai[$j + 1];
            $nilai[$j + 1] = $temp;
        }
    }
}

echo "Nilai setelah diurutkan: ";
for ($i = 0; $i < $panjang_nilai; $i++) {
    echo $nilai[$i] . " ";
}

echo "<br>";

$totalnilai = 0;
echo "Nilai setelah dikeluarkan :";
for ($i = 2; $i < $panjang_nilai - 2; $i++) {
    echo $nilai[$i] . " ";
    $totalnilai += $nilai[$i];
}


echo "<br> Total Nilai: " . $totalnilai;

?>
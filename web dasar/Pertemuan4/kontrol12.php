<?php
$hargaBarang = 120000;
$diskon = 0.2;

if ($hargaBarang > 100000) {
    $diskon = $hargaBarang * 0.2;
    $hargaAkhir = $hargaBarang - $diskon;
    echo "Harga awal : Rp." . $hargaBarang . "<br>";
    echo "Harga Diskon : Rp." . $diskon . "<br>";
    echo "Harga setelah diskon: Rp." . $hargaAkhir;
}else{
    echo "Tidak ada diskon. Harga yang harus dibayar: Rp " . $hargaBarang;
}


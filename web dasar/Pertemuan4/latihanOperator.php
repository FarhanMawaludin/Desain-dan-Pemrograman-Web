<?php
$totKursi = 45;
$terisi = 28;
$kosong = $totKursi - $terisi;
$percentage = ($kosong/$totKursi) * 100;
echo "Total kursi         : $totKursi <br>";
echo "Kursi tersedia      : $kosong <br>";
echo "Percentage kosong   : $percentage %";
?>
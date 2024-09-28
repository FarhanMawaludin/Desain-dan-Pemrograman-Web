<?php
function perkenalan($nama,$salam="Assalamualaikum"){
    echo $salam . ", ";
    echo "Perkenalkan nama saya " . $nama . "<br>";
    echo "Senang berkenalan dengan anda <br>";
}

perkenalan("Farhan","Hallo");

echo "<hr>";

$saya = "Farhan";
$ucapan = "Assalamualaikum";

perkenalan($saya);

?>
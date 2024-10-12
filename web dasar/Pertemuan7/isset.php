<?php
$umur;
if(isset($umur) && $umur >=18) {
    echo "Anda sudah dewasa";
}else{
    echo "Anda belum dewasa atau variabel umur tidak ditemukan";
}

echo "<br>";

$data = array(
    "nama" => "parahan",
    "usia" => 19
);

if(isset($data["nama"])) {
    echo "nama : " . $data["nama"];
}else{
    echo "variabel data tidak ditemukan";
}

?>
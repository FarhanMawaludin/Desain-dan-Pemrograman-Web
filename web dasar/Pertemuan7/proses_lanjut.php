<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Buah yang dipilih
    $selectedBuah = $_POST['buah'];
    echo "Anda memilih buah: " . $selectedBuah . "<br>";

    // Warna favorit
    if (isset($_POST['warna'])) {
        $selectedWarna = $_POST['warna'];
    } else {
        $selectedWarna = [];
    }

    // Jenis kelamin
    $selectedJenisKelamin = $_POST['jenis_kelamin'];

    // Menampilkan warna yang dipilih
    if (empty($selectedWarna)) {
        echo "Anda tidak memilih warna favorit.<br>";
    } else {
        echo "Warna favorit Anda: " . implode(", ", $selectedWarna) . "<br>";
    }

    // Menampilkan jenis kelamin
    echo "Jenis kelamin Anda: " . $selectedJenisKelamin . "<br>";
}
?>

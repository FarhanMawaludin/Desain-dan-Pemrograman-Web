<!DOCTYPE html>
<html>
<head>
    <title>Contoh Form dengan PHP</title>
</head>
<body>
    <h3>Form Contoh</h3>
    <form method="POST" action="proses_lanjut.php">
        <!-- Buah Section -->
        <label for="buah">Pilih Buah:</label><br>
        <select name="buah" id="buah">
            <option value="apel">Apel</option>
            <option value="mangga">Mangga</option>
            <option value="jeruk">Jeruk</option>
        </select><br><br>

        <!-- Warna Section -->
        <label>Pilih Warna Favorit:</label><br>
        <input type="checkbox" name="warna[]" value="merah"> Merah<br>
        <input type="checkbox" name="warna[]" value="biru"> Biru<br>
        <input type="checkbox" name="warna[]" value="hijau"> Hijau<br><br>

        <!-- Jenis Kelamin Section -->
        <label>Pilih Jenis Kelamin:</label><br>
        <input type="radio" name="jenis_kelamin" value="laki-laki"> Laki-laki<br>
        <input type="radio" name="jenis_kelamin" value="perempuan"> Perempuan<br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Contoh Form dengan PHP dan jQuery</title>
    <script src="jquery-3.7.1.js"></script>
</head>
<body>
    <h3>Form Contoh</h3>
    <form id="myForm">
        <!-- Pilih Buah -->
        <label for="buah">Pilih Buah:</label>
        <select name="buah" id="buah">
            <option value="apel">Apel</option>
            <option value="mangga">Mangga</option>
            <option value="jeruk">Jeruk</option>
        </select>
        <br><br>

        <!-- Pilih Warna Favorit -->
        <label>Pilih Warna Favorit:</label><br>
        <input type="checkbox" name="warna[]" value="merah"> Merah<br>
        <input type="checkbox" name="warna[]" value="biru"> Biru<br>
        <input type="checkbox" name="warna[]" value="hijau"> Hijau<br>
        <br>

        <!-- Pilih Jenis Kelamin -->
        <label>Pilih Jenis Kelamin:</label><br>
        <input type="radio" name="jenis_kelamin" value="laki-laki"> Laki-laki<br>
        <input type="radio" name="jenis_kelamin" value="perempuan"> Perempuan<br>
        <br>

        <input type="submit" value="Submit">
    </form>

    <div id="hasil">
    </div>

    <script>
        $(document).ready(function () {
            // Saat form disubmit
            $('#myForm').submit(function (e) {
                e.preventDefault(); // Mencegah pengiriman form secara default

                // Mengambil data form
                var formData = $(this).serialize();

                // Mengirim data ke server menggunakan AJAX
                $.ajax({
                    type: 'POST',
                    url: 'proses_lanjut.php', 
                    data: formData,
                    success: function (response) {
                        // Menampilkan hasil di div "hasil"
                        $('#hasil').html(response);
                    }
                });
            });
        });
    </script>
</body>
</html>

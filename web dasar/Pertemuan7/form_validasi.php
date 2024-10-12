<!DOCTYPE html>
<html>
<head>
    <title>Form Input dengan Validasi</title>
    <script src="jquery-3.7.1.js"></script>
</head>
<body>
    <form id="myForm" method="post" action="proses_validasi.php">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama">
        <span id="nama-error" style="color: red;"></span><br>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email">
        <span id="email-error" style="color: red;"></span><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <span id="password-error" style="color: red;"></span><br>

        <input type="submit" value="Submit">
    </form>

    <div id="result"></div>

    <script>
    $(document).ready(function() {
        $("#myForm").submit(function(event) {
            event.preventDefault(); // Mencegah pengiriman form secara default
            var nama = $("#nama").val();
            var email = $("#email").val();
            var password = $("#password").val();
            var valid = true;

            // Validasi Nama
            if (nama === "") {
                $("#nama-error").text("Nama harus diisi.");
                valid = false;
            } else {
                $("#nama-error").text("");
            }

            // Validasi Email
            if (email === "") {
                $("#email-error").text("Email harus diisi.");
                valid = false;
            } else {
                $("#email-error").text("");
            }

            // Validasi Password
            if (password.length < 8) {
                $("#password-error").text("Password harus terdiri dari minimal 8 karakter.");
                valid = false;
            } else {
                $("#password-error").text("");
            }

            // Jika validasi berhasil, kirim data dengan AJAX
            if (valid) {
                $.ajax({
                    url: 'proses_validasi.php',
                    type: 'POST',
                    data: {
                        nama: nama,
                        email: email,
                        password: password
                    },
                    success: function(response) {
                        $("#result").html(response); // Tampilkan hasil di div
                    }
                });
            }
        });
    });
    </script>
</body>
</html>

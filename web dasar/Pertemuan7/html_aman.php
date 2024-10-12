
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['nama'])) {
            $nama = $_POST['nama'];
            $nama = htmlspecialchars($nama, ENT_QUOTES, 'UTF-8');
            echo "Nama: " . $nama . "<br>";
        }

        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Email: " . htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
            } else {
                echo "Email tidak valid.";
            }
        }
    }
    ?>

   

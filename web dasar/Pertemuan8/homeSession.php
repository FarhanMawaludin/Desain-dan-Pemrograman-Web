<html>
    <head>
        <title>Halaman Home</title>
    </head>
    <body>
        <?php
        session_start();
        if($_SESSION['status'] == 'login') {
            echo "Selamat datang " . $_SESSION['username'];
            echo "<br>";
            echo "<a href='sessionLogout.php'>Logout</a>";
        } else {
            echo "Anda belum login, silakan ";
            echo "<a href='sessionLoginForm.html'>Login</a>";
        }
        ?>
    </body>
</html>


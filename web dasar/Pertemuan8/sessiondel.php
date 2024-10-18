<?php
session_start();
?>

<!DOCTYPE html>
<html>
<body>
  <?php
    // Menghapus semua variabel session
    session_unset();

    // Menghancurkan session
    session_destroy();

    // Menampilkan pesan bahwa session telah dihancurkan
    echo "All session variables are now removed, and the session is destroyed.";
  ?>
</body>
</html>

<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <h2>
            Array Terindeks
        </h2>
        <?php
            $Listdosen=["Elok Nur Hamdana","Unggul Pamenang","Bagas Nugraha"];
            // dengan memanggil indeks
            echo "Memanggil indeks <br>";
            echo $Listdosen[2] . "<br>";
            echo $Listdosen[0] . "<br>";
            echo $Listdosen[1] . "<br><br>";

            //Menggunakan Looping
            echo "Menggunakan Looping <br>";
            foreach($Listdosen as $dosen){
                echo $dosen . "<br>";
            }

        ?>
    </body>
</html>
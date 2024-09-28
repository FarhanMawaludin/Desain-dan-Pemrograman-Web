<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style/style.css">
    </head>
    <body>
        <h2>Array Multidimensi</h2>
        <table>
            <tr>
                <th>Judul Film</th>
                <th>Tahun</th>
                <th>Rating</th>
            </tr>
            <?php
                $movie=array(
                    array("Avengers: invinity war",2018,8.7),
                    array("The avengers",2012,8.1),
                    array("Guardian",2008,7.9),
                    array("Ironman",2008,7.9)
                );

                echo "<tr>";
                    echo "<td>" . $movie[0][0] . "</td>";
                    echo "<td>" . $movie[0][1] . "</td>";
                    echo "<td>" . $movie[0][2] . "</td>";
                echo "</tr>";   

                echo "<tr>";
                    echo "<td>" . $movie[1][0] . "</td>";
                    echo "<td>" . $movie[1][1] . "</td>";
                    echo "<td>" . $movie[1][2] . "</td>";
                echo "</tr>";

                echo "<tr>";
                    echo "<td>" . $movie[2][0] . "</td>";
                    echo "<td>" . $movie[2][1] . "</td>";
                    echo "<td>" . $movie[2][2] . "</td>";
                echo "</tr>";

                echo "<tr>";
                    echo "<td>" . $movie[3][0] . "</td>";
                    echo "<td>" . $movie[3][1] . "</td>";
                    echo "<td>" . $movie[3][2] . "</td>";
                echo "</tr>";
                
            ?>
        </table>
    </body>
</html>
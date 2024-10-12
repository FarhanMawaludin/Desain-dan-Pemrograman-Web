<?php
$myArray = array();

if(empty($myArray)){
    echo "array kosong";
}else{
    echo "array ada";
}

echo "<br>";

if(empty($nonExistentVar)){
    echo "Variabel tidak terdefinisi atau kosong";
} else{
    echo "variabel terdefinisi dan tidak kosong";
}
?>
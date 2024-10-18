<?php
$targetDirectory = "images/";

if(!file_exists($targetDirectory)){
    mkdir($targetDirectory, 0777, true);
}

if($_FILES['files']['name'][0]){
    $totalFiles = count($_FILES['files']['name']);

    for($i = 0; $i < $totalFiles; $i++){
        $fileName = $_FILES['files']['name'][$i];
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);

        // Mengecek apakah file yang diunggah adalah gambar
        if(in_array($fileExt, array('jpg', 'jpeg', 'png', 'gif'))){
            $targetFile = $targetDirectory . $fileName;

            if(move_uploaded_file($_FILES['files']['tmp_name'][$i], $targetFile)){
                echo "File $fileName uploaded successfully<br>";
            } else {
                echo "Error uploading file $fileName<br>";
            }
        } else {
            echo "File $fileName bukan gambar<br>";
        }
    }
}else{
    echo "No files uploaded";
}
?>
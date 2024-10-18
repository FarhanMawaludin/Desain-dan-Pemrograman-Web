<?php
if(isset($_POST["submit"])){
    $targetdir = "uploads/";
    $targetfile = $targetdir . basename($_FILES["myfile"]["name"]);
    $filetype = strtolower(pathinfo($targetfile,PATHINFO_EXTENSION));

    $allowedExtensions = array("txt","pdf","doc","docx");
    $maxsize = 3*1024*1024;

    if(in_array($filetype, $allowedExtensions) && $_FILES["myfile"]["size"] <= $maxsize){
        if(move_uploaded_file($_FILES["myfile"]["tmp_name"], $targetfile)){
            echo "File uploaded successfully";
        } else {
            echo "Error uploading file";
        }

    }else{
        echo "File type not allowed or file too large";
    }
}
?>
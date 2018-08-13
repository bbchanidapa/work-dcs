<?php
    include('connect.php');

    $size = $_POST["size"];
    $width = $_POST["width"];
    $height = $_POST["height"];
    $path = $_POST["path"];
    $image_resolution = $width.",".$height;

    $sql = "insert into floorplans values (null,'$path','$image_resolution',1)";
    $query = mysql_query($sql);

    if ($query) {
    $message = "Insert Successful";
    echo "<script type='text/javascript'>alert('$message');</script>";
/*    echo "<SCRIPT LANGUAGE='JavaScript'>
         window.location.href='/js/overview.php';
         </SCRIPT>";*/
    }


?>
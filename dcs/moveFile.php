<?php

    $label = $_POST["label"];
    $temp = explode(".", $_FILES["file"]["name"]);
    $extension = end($temp);
    $filename = $image.$_FILES["file"]["name"];
    move_uploaded_file($image.$_FILES["file"]["tmp_name"],
        "img/".$filename);
    $path = "img/" . $filename;
    list($width, $height) = getimagesize($path);
	$data = array('pathFile'=> $path,'width'=> $width, 'height'=> $height);
	echo json_encode($data);

?>
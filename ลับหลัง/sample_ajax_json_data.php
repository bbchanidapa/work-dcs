<?php

$data = array(
    "students" => array(
        array("name"=>"peter","id"=>12),
        array("name"=>"ray","id"=>15),
        array("name"=>"emma","id"=>23),
    ),
);

if(isset($_GET['class'])) {
    $data["class"] = $_GET['class'];
    $data["request_method"] = "get";
}

if(isset($_POST['class'])) {
    $data["class"] = $_POST['class'];
    $data["request_method"] = "post";
}

echo json_encode($data);

?>
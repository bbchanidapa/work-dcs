<?php
    include('connect.php');
    $code = $_POST["code"];
    $json = json_decode($code);

   /* foreach($json as $item) {
            $floor_coordinate = $item['top'].','.$item['left'];
            $sql = "insert into seats values (uuid(),'{$item['id']}',null,1,'$floor_coordinate')";
            $query = mysql_query($sql);
    }*/

    // if (isset($query)) {
    // $message = "Insert Successful";
    // echo "<script type='text/javascript'>alert('$message');</script>";
    // }

/*
$jsonStr =  '[{"id":"A0","top":108,"left":106},{"id":"A1","top":121,"left":245},{"id":"A2","top":108,"left":367}]';*/



echo json_encode($json);




?>
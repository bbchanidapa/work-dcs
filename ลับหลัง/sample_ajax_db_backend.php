<?php

function dbQuery($sql, $return=false) {
    $user = 'root'; $pass = 'password';
    $dsn = 'mysql:host=127.0.0.1;dbname=basicphp';
    $options = array(
      PDO::ATTR_PERSISTENT=>true,
      PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION
    );
    try {
	  $dbh = new PDO($dsn,$user,$pass,$options);
      $stmt = $dbh->prepare($sql);
      if($return) {
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
      }
      else {
        $stmt->execute();
		return $dbh->lastInsertId();
      }
    } catch(PDOException $e) {
      $error = $e->getMessage();
      return $error;
    }
}




if (isset($_POST['add']) && $_POST['add']=='products') {
    if(isset($_POST['name']) && isset($_POST['price'])) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $result = dbQuery("INSERT INTO products(name,price) VALUE('$name','$price')");
        if($result) {
			echo json_encode(array("id"=>$result));
		}
    }
}
else if(isset($_GET['list']) && $_GET['list']=='products') {
    if(isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];
        $products = dbQuery("SELECT * FROM products WHERE id='$id'", true);
    }
    else {
        $products = dbQuery("select * from products", true);
    }
    echo json_encode($products);
}

?>
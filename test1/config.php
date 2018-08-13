<?php
session_start();
$db_host="localhost";
$db_username = "root";
$db_password = "1234";
$db_name = "test";

$db_connect = mysqli_connect($db_host,$db_username,$db_password,$db_name);
 ?>

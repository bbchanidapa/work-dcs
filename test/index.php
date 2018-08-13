<?php
session_start();
if($_SESSION['username']== NULL){
	echo $_SESSION['username'];
}
	//include("connect.php");

/*	if($_SESSION['username'] ==  NULL){
		?><a href="register.php">Register</a>
		  <a href="login.php">Login</a><?
	}else{
		echo "Username  ".$_SESSION['username'];
	}*/
?>


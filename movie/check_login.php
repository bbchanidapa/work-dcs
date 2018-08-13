<?php
session_start();
	include("connect.php");
	$sql = "SELECT * FROM login WHERE username = '".$_POST['username']."' and password = '".$_POST['password']."'";
	$query = mysql_query($sql);
	$result = mysql_fetch_array($query);
	if (!$result) {
	echo "error";
	}
	else{
			$_SESSION['username'] = $result['username'];
			header("location:index.php");
	}
?>

<?php
	include("connect.php");
	if(isset($_POST['submit'])){

		$username = $_POST['username'];
	 	$password = $_POST['password'];
	 	$sql = "SELECT * FROM customer WHERE username = '".$_POST['username']."' and password = '".$_POST['password']."' ";
		$query = mysql_query($sql);
		$result = mysql_fetch_array($query);

		if($username == $result['username']) {
			$_SESSION['username'] = $username;
			echo "<SCRIPT LANGUAGE='JavaScript'>
			 window.location.href='index.php';
				</SCRIPT>";
		}

	}else{

	}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="#" method="post">
		username: <input type="text" name="username">
		password: <input type="password" name="password">
		<input type="submit" name="submit">
	</form>
</body>
</html>


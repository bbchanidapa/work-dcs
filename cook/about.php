<?php  
/*	include('connect.php');
	$sql = "select * from user";
	$query = mysql_query($sql);
	$result = mysql_fetch_array($query);*/
if(!isset($_COOKIE['username'])){  
	echo '<form action="" method="POST">';  
	echo 'Username :<input name="username" type="text"><br />';  
	echo 'Password :<input name="password" type="password"><br />';  
	echo '<input name="submit" type="submit" value="Submit"><br />';  
	echo '</form>'; 	
}  
if(isset($_POST['submit'])){  

	$username = $_POST['username'];  
	$password = $_POST['password'];  

		if ($username == "test" && $password == "test"){  
			setcookie("username", $username, time()+3600);  
			setcookie("password", $password, time()+3600);  
			echo 'logged in<br />';  
			echo 'Click <a href="out.php">here</a> to log out'; 

	  	}else {  
			echo 'Log in failed';  
		}  
} 

if(isset($_COOKIE['username']) || $_COOKIE['password']){  
	$username = $_COOKIE['username'];  
	$password = $_COOKIE['password'];  

	if ($username == "test" && $password == "test"){  
		echo 'cookie logged in<br />';  
		echo 'Click <a href="out.php">here</a> to log out';  
	}  
}  


?>
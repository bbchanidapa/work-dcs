<?php  
/*	include('connect.php');
	$sql = "select * from user";
	$query = mysql_query($sql);
	$result = mysql_fetch_array($query);*/
if(!isset($_COOKIE['user'])){  
	echo '<form action="" method="POST">';  
	echo 'Username :<input name="username" type="text"><br />';  
	echo 'Password :<input name="password" type="password"><br />';  
	echo '<input name="submit" type="submit" value="Submit"><br />';  
	echo '</form>'; 	
}  
if(isset($_POST['submit'])){  

	$user = $_POST['username'];  
	$pass = $_POST['password'];  

		if ($user == "bb" && $pass == "bb"){  
			setcookie("user", $username, time()+3600);  
			setcookie("pass", $password, time()+3600);  
			echo 'logged in<br />';  
			echo 'Click <a href="out.php">here</a> to log out'; 

	  	}else {  
			echo 'Log in failed';  
		}  
} 
 
if(isset($_COOKIE['user']) || $_COOKIE['pass']){  
	$user = $_COOKIE['user'];  
	$pass = $_COOKIE['pass'];  

	if ($user == "bb" && $pass == "bb"){  
		echo 'cookie logged in<br />';  
		echo 'Click <a href="out.php">here</a> to log out';  
	}  
} 


?>
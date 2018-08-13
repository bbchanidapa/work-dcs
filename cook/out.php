<?php
/*	session_start();
	session_destroy();*/
if(isset($_COOKIE['user'])){  
	unset($_COOKIE['user']);
	unset($_COOKIE['pass']);
	setcookie("user", "", time()-3600);  
	setcookie("pass", "", time()-3600);
	
	header("Location: about.php"); 
	//return ture;
	} 
?>
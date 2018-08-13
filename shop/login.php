<?
 	session_start();
	include("connect.php");

	if ($_POST['submit'] == 'submit') {
		$user = $_POST['username'];
	 	$pass = $_POST['password'];  
	

	/*pass_word = SHA1(  'bb:bb' ) */
		$sql = "SELECT * FROM member WHERE UserName = '".$_POST['username']."' and pass_word = SHA1('$user'.':'.'$pass') ";
		$query = mysql_query($sql);
		$result = mysql_fetch_array($query);
		
		if($user == $result['UserName']) {
			$_SESSION['username'] = $user;
			$_SESSION['memberid'] = $result['MemberID'];
			$_SESSION['sum'] = 0;
			echo "<SCRIPT LANGUAGE='JavaScript'>
			 window.location.href='index.php';
				</SCRIPT>";
		}
	}

?>

<html>
<head>
	<title>Login</title>
</head>
<body>
<form action="#" method="POST">
	<input type="text" name="username">
	<input type="password" name="password">
	<input type="submit" name="submit" value="submit">
</form>

</body>
</html>

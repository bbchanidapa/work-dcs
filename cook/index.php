<?
	session_start();
	if ($_SESSION['login'=='yes']) {
		?>
		<html>
		<head>
			<meta charset="UTF-8">
		</head>
		
		<body>
			<table width="80%">
				<form method="post" action="logout.php" >
						<tr>
							<td><input type="submit" value="ออกจากระบบ"></input></td>
						</tr>
				</form>
			</table>
		</body><?

	}else{ 
	?>
		<body>
		<meta charset="UTF-8">
		
				<form method="post" action="login.php"  >
					<table>
						<tr>
					<td align="right">Username :</td>
						<td><input type="text" name="username" size="20"></input></td>
					</tr>
					<tr>
					<td align="right">Password :</td>
						<td><input type="password" name="password" size="20"></input></td>
					</tr>
					<tr>
						<td><input type="submit" value="เข้าสู่ระบบ"></input></td>
						<td><input type="reset" value="ล้างข้อมูล"></input> <a href="register.php">สมัครสมาชิก</a></td>
					</tr>

					</table>
				</form>
			
		</body>
	<?}?>


	
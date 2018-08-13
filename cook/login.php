<?
session_start();
include('connect.php');

	$user = $_POST['username'];
	$pass = $_POST['password'];
	$sql = "select * from user";
	$query = mysql_query($sql);
	while ($col = mysql_fetch_array($query)) {

		if ($col[0]==$user && $col[1]==$pass) {
			$_SESSION['username']=$user;
			//setcookie('cookie', $check,time() 3600*24*356));
	
			$valid = 'yes';
			break;
		}else{
			$valid = 'no';
		}

	}//while
	if ($valid=='yes') {?>
		<script type="text/javascript">
			window.location = 'home.php';
		</script>
	<?}else{
		session_destroy();
		?>
			<script type="text/javascript">
				window.location = 'index.php';
			</script>
		<?
	}
	mysql_close($link);
?>
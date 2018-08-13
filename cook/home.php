<?
	session_start();
	if (isset($_SESSION['username'])) {
		include('header.php');
?>		
			<html>
			<head>
				<title>Home</title>
				<meta charset="UTF-8">
			</head>
			<body align="center">
			<form method="POST" action="#">
			<br><br>
			<b>Welcome... User </b>
			
				<?= $_SESSION['username'];//show user จาก DB ?>
				<br> 
				<?include('product.php');?>
			</form>
			</body>
			</html>
		

	<?}else{?>
		
			<script type="text/javascript">
				window.location = 'index.php';
			</script>
		
<?	}?>


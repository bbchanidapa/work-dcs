<?
session_start();
	if (isset($_SESSION['username'])) {
		
		?>

			
<center>
			<meta charset="UTF-8">
			<a href="home.php" >Home</a>
			<a href="product.php">Product</a>
			<a href="about.php">About</a>
			<a href="logout.php">Logout</a>
		<?

	}else{
		?>
		    <script type="text/javascript">
				window.location = 'index.php';
			</script>
			<?
	}
?>
<!-- <meta name="author" content="kacha chansilp">
			<meta http-equiv="content-Type" content="text/html; charset=tis-620">
			<meta http-equiv="Content-Language" content="th"> -->
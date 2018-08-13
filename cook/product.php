<?
	session_start();
	if (isset($_SESSION['username'])) {
?>	
<html>
<head>
	<title></title>
	<meta charset="UTF-8">
</head>
<body>
<center>
	<table align="center" border="1">
		<tr>
			<td>Name</td>
			<td>Price</td>
			<td>Detail</td>
		</tr>
		<tr>
			<td><img src="cup.png"></td>
			<td>500฿</td>
			<td>รส สตอเบอร์รี่</td>
		</tr>

	</table>

</body>
</html>
<?}else{?>
		
			<script type="text/javascript">
				window.location = 'index.php';
			</script>
		
<?	}?>
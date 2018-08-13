<?
		@session_start();
		include('connect.php');

			
			if ($_SESSION['username']=null) {
				echo "<SCRIPT LANGUAGE='JavaScript'>
					   window.location.href='login.php';
					  </SCRIPT>";
			}else{
			$sql = "SELECT * FROM Product ";
			$query = mysql_query($sql);

			}
?>
<html>
<head>
	<title>Home</title>  
	<meta charset="UTF-8">

</head>
<body>
<form method="POST" action="#">
<table border="1">
<tr>
<td>ID</td>
<td>Name Product</td>
<td>Price</td>

</tr>
<?  
while ($result = mysql_fetch_array($query)){
	$check = $result['Quantity'];

	if($check > 0){
		echo "<tr>";
			echo "<td>".$result['ProductID']."</td>";
			echo "<td>".$result['ProductName']."</td>";
			echo "<td>".$result['Price']."</td>";
		  echo "<td><a href= 'buy.php?id=".$result['ProductID']." '>Buy</a></td>";
		  echo "</tr>";
		}
		}

echo "Sum : ".$_SESSION['sum']."<br>"; 
echo "UserID :".$_SESSION['memberid']; ?>
</table> 
</form>
<a href="logout.php">Logout</a>
<a href="report.php" onmouseover="window.status = 'Click Di'; return true "onMouseout="window.status="">Report</a>
</body>
</html>

 

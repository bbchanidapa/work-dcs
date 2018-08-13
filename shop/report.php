<?
	session_start();
	include('connect.php');
	if ($_SESSION['username']=null) {
				echo "<SCRIPT LANGUAGE='JavaScript'>
					   window.location.href='login.php';
					  </SCRIPT>";
			}else{
			$id = $_SESSION['memberid'];	
			$sql = "SELECT buy.date,pd.ProductName,pd.price FROM buy JOIN product pd  ON  buy.ProductID = pd.ProductID WHERE MemberID = '$id' ;";
			$query = mysql_query($sql);
			
			}
?>
<html>
<head>
	<title></title>
</head>
<body>
<form method="POST" action="#">
<a href="index.php">Home</a>
	<table border="1">
	<tr>
		<td>No.</td>
		<td>Date</td>
		<td>Product</td>
		<td>Price</td>
	</tr>
<?while($result = mysql_fetch_array($query)){
		echo "<tr>";
		$count = $count+1;
		echo "<td>".$count."</td>";
		echo "<td>".$result['date']."</td>";
		echo "<td>".$result['ProductName']."</td>";
		echo "<td>".$result['price']."</td>";
		echo "</tr>";
		}
?>
	</table>
</form>
<img src="">
</body>
</html>

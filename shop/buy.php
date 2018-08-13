<?
		session_start();
		include('connect.php');
	date_default_timezone_set('Asia/Bangkok');					
			$id = $_GET['id'];
			$sql = "SELECT * FROM Product WHERE ProductID = '$id'";
			$query = mysql_query($sql);
			$result = mysql_fetch_array($query);
			$product = $result['ProductID'];
			$date = date("d-M-Y H:i:s: a");
			$memberid = $_SESSION['memberid'];
			$quantity = $result['Quantity'];

	if(isset($_POST['submit']) && $_POST['submit'] == 'submit'){
	$resultnum = $result['Quantity'] - 1 ;
		$sql = "insert into buy values (null,'$date','$product',$memberid)"; 
		$query = mysql_query($sql);
		/*----------------------------------------------*/
		$update = "UPDATE product SET Quantity = '$resultnum' WHERE ProductID = '$product'";
	    $queryup = mysql_query($update);
			if ($query) {
				$message = "Insert Successful";
				echo "<script type='text/javascript'>alert('$message');</script>";
				echo "<SCRIPT LANGUAGE='JavaScript'>
					   window.location.href='index.php';
					  </SCRIPT>";
				}
				
	}else {
		$_SESSION['sum'] = $_SESSION['sum']+$result['Price'];
		  
		 
	}
?>
<html>
<head>
	<title>Home</title>  
	<meta charset="UTF-8">

</head>
<body>
<form method="POST" action="#">
<table border="1"><tr>
<td>ID </td><td>Name</td><td>Price</td><td>UserID</td><td>Quantity</td></tr><tr>
<?     
		echo "<td>".$result['ProductID']."</td>";
		echo "<td>".$result['ProductName']."</td>";
        echo "<td>".$result['Price']."</td>";	 
     	echo "<td>".$memberid."</td>";
     	echo "<td>".$result['Quantity']."</td>";
     		?>

		</tr>

</table>
<input type="submit" name="submit" value="submit">
</form>

</body>
</html>
<?
	
?>


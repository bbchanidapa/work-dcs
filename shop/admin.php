<?
		session_start();
		include('connect.php');

			$sql = "SELECT * FROM Product";
			$query = mysql_query($sql);
			
?>
<html>
<head>
	<title>Home</title>  
	<meta charset="UTF-8">

</head>
<body>
<form method="POST" action="update.php">
 
<?  

while ($result = mysql_fetch_array($query)){
			echo "<br>"."ID =".$result['ProductID']."<br>";
			echo "Name =".$result['ProductName']."<br>";
			echo "Price =".$result['Price']."<br>";
			
			
  echo "<a href= 'update.php?id=".$result['ProductID']." '>Add</a>";
		
		
		} ?>

</form>
</body>
</html>

 

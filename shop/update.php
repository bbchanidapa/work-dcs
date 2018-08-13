<?
	@session_start();
	include("connect.php");
	$id = $_GET['id'];
	$sql = "SELECT * FROM Product WHERE ProductID = '$id'";
	$query = mysql_query($sql);
	$result = mysql_fetch_array($query);

	
	
?>
<meta charset="UTF-8">
<form method="POST" action="#">

	Name:<input type="text" name="productname" value="<?echo $result['ProductName']; ?>"><br>
	 <img src="img/<? echo $result['image'];?>" height = "20%"><br>
	Price :<input type="text" name="price" value="<?echo $result['Price']; ?>"><br>				      
	Quantitay :<input type="text" name="quantity">
	<input type="submit" name="submit" value="ok">

</form>
<?
if ($_POST['submit']=='ok') {
	$quantity = $result['Quantity'];
	$quantity += $_POST['quantity'];
		$update = "UPDATE product SET Quantity = '$quantity' WHERE ProductID = '$id' ";
		$query1 = mysql_query($update);
	}
	 
?>
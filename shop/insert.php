<?
	@session_start();
	include("connect.php");


		if($_POST['submit'] == 'insert'){
			$productname = $_POST["productname"]; 
			$image = $_POST["image"];
			$price = $_POST["price"];
			$quantity = $_POST['quantity']; 
		
			$imgData = $_FILES['image']['name']; 
			if(copy($_FILES['image']['tmp_name'],"img/".$_FILES['image']['name'])){
				
			$sql = "insert into product values (null,'$productname','$imgData','$price','$quantity')"; 
			$query = mysql_query($sql);
			
			if ($query) {
				$message = "Insert Successful";
				echo "<script type='text/javascript'>alert('$message');</script>";
				echo "<SCRIPT LANGUAGE='JavaScript'>
					   window.location.href='admin.php';
					  </SCRIPT>";
				}
		}
	}
?>
<html>
<head>

	<title>Insert</title>  

</head>
<body>
 
	<form method="post" action="#" enctype="multipart/form-data">

			 <input name="productname" type="text"><br>	
			 <input name="image" type="file"><br>
			 <input name="price" type="text"><br>
			 <input name="quantity" type="text"><br>
			  
			<button type="submit" name="submit" value="insert">Confirm</button>			
			</form>
		  
		  
	</form>
   

</body>
</html>


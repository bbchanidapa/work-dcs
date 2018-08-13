<html>
<head></head>
<body>
	<form method="post" action="#" enctype="multipart/form-data">
		<input name="image" type="file">
		<button type="submit" name="submit" value="insert">Confirm
		</button>
	</form>
</body>
</html>
<?php
	if($_POST['submit'] == 'insert'){
		print_r($_FILES);
		$image = $_POST["image"];
		$imgData = $_FILES['image']['name'];
		if(move_uploaded_file($_FILES['image']['tmp_name'],"img/".$_FILES['image']['name'])){
			echo $imgData;
		}//if
	}//if

?>


<html>
<body>

 <?php
if ($_SESSION['memid'] == NULL){ ?>

<form method="post" action="#">
	Username :
	<input type="text" name="username" placeholder="Username" required>
	Password :
	<input type="password" name="password" placeholder="Password" required>
	<input type="submit" name="submit">
</form>
<?php
if ($_POST){

$username = $_POST["username"];
$password = $_POST["password"];


$sql = ' SELECT * FROM customer WHERE username = "'.$username.'" and password = "'.$password.'" ';
$checksql = mysqli_query($db_connect,$sql);
$login = mysqli_fetch_array($checksql);

if ($login){
$_SESSION['username'] = $login['username'];
$_SESSION['memid'] = $login['id'];
$_SESSION['email'] = $login['email'];
echo $_SESSION['memid'];
header('location:index.php');

}

else {

  echo "ไอดี หรือ รหัสผ่านผิดพลาด";
  header('location:index.php');
}



}




}
else {

header('location:index.php');

}

 ?>


 </body>
 </html>

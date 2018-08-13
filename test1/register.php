<html>
<body>

<?php

if ($_POST){

if ($_POST["password"] == $_POST["cpassword"]){

$username = $_POST["username"];
$password = $_POST["password"];
$email = $_POST["email"];
$tel = $_POST["tel"];

$sql = 'INSERT INTO membertest VALUES ("","'.$username.'","'.$password.'","'.$email.'","'.$tel.'")  ';
$check = mysqli_query($db_connect,$sql);
if ($check){

  echo "สมัครข้อมูลเสร็จเรียบร้อย<br>";
  echo "<a href='index.php'> กลับหน้าแรก</a>";
}
else {
  echo "สมัครข้อมูลผิดพลาด";
}

}
else {

  echo "รหัสผ่านไม่ตรงกัน";
}

}



 ?>
<form method="post">
สมัครสมาชิก !<br>
Username : <input type="text" name="username" placeholder="Username"><br>
Password : <input type="password" name="password" placeholder="Password"> <br>
Confirm Password : <input type="password" name="cpassword" placeholder="Confirm Password"> <br>
Email : <input type="email" name="email" placeholder="E-mail"> <br>
Telephone : <input type="tel" name="tel" placeholder="Telephone"> <br>
<input type="submit" name="submit">
</form>




</body>
</html>

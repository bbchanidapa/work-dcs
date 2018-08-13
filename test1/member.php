<html>
<body>

<?php

if ($_POST){

 if ($_POST['password']==$_POST['cpassword']){




 }

 else {
   echo "รหัสผ่านไม่ตรงกัน<br>";
 }




}









 ?>

ข้อมูลสมาชิก <br>
Username : [<?php echo $_SESSION['username'];?>]<br>
<form method="post">
เปลี่ยนรหัสผ่าน : <input type="password" name="password" placeholder="Password" value="asdasd"><br>
ยืนยันรหัสผ่าน : <input type="password" name="cpassword" placeholder="Confirm Password"><br>
ชื่อ : <input type="text" name="name" placeholder="ชื่อ"><br>
นามสกุล : <input type="text" name="cname" placeholder="นามสกุล" ><br>
<input type="submit" name="submit"><br>
</form>



 </body>
 </html>

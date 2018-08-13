<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>

ยินดีต้อนรับเข้าสู่เว็บไซต์ <br>
<?php

if ($_SESSION['memid']==NULL){



echo "hi,";
echo $_SESSION["username"]." ";
echo '| <a href="customer.php?page=member">แก้ไขข้อมูล</a> ';
echo '| <a href="logout.php">ออกจากระบบ</a>';
}

else { ?>

  <a href="customer.php?page=login"> Login </a>| <a href="customer.php?page=register">Register </a>
  <?php
}

   ?>





</body>
</html>

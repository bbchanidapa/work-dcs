<?
include('connect.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<center><table width="661" height="84" border="1">
  <tr>
    <th scope="col"><blockquote><a href="bbmain.php">หน้าหลัก</a></blockquote></th>
    <th scope="col"><blockquote>รายการสินค้า</blockquote></th>
    <th scope="col"><blockquote>ตรวจสอบสินค้า</blockquote></th>
  </tr></table>
<?php


$strSQL = "INSERT INTO `khay_khong`.`member` (`MemberID`, `MemberName`, `Address`, `Tel`, `UserName`, `pass_word`) VALUES (NULL,'".$_POST["name"]."','".$_POST["address"]."','".$_POST["tel"]."','".$_POST["userN"]."','".$_POST["pass"]."')";
		
		
	$objQuery = mysql_query($strSQL);

if(!$objQuery)

{

	echo "Error Save [".mysql_error()."]";

}
else
{
	echo "เพืมข้อมูลสำเร็จ";
}

?>

</body>
</html>
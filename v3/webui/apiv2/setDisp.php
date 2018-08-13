<?php 
include("../db.inc.php");
if(!isset($_POST['uname']) || !isset($_POST['upass']))
{
	$json_buffer = '{
		"code":302,
		"data":""
	}';
	echo $json_buffer;
	exit();
}

$uname = $_POST['uname'];
$upass = $_POST['upass'];

$select_user_text = "select * from user where uname='".$uname."' and  upass='".$upass."'";
$result_user = mysql_query($select_user_text);

if (mysql_num_rows($result_user) == 0)
{
	$json_buffer = '{
		"code":404,
		"data":""
	}';
	echo $json_buffer;
	exit();
}

$user_array = mysql_fetch_array($result_user);

$target_path = "upload/"; 
if(move_uploaded_file($_FILES['disp']['tmp_name'], $target_path.$user_array['uid']. ".png"))
{ 
	$json_buffer = '{
		"code":200,
		"data":""
	}';
	echo $json_buffer;
} 
else 
{
	$json_buffer = '{
		"code":500,
		"data":""
	}';
	echo $json_buffer; 
} 
?>
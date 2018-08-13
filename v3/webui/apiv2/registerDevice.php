<?php
include("../db.inc.php");
if(!isset($_POST['email']) || !isset($_POST['dev_token']))
{
	$json_buffer = '{
		"code":302,
		"data":""
	}';
	echo $json_buffer;
	exit();
}

$email = $_POST['email'];

$select_user_text = "select * from user where email='".$email."'";
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

include("../function.api.inc.php");

$var_parameter_dev_token= $_POST['dev_token'];
$select_token_text = "select * from device_push where pd_devicetoken = '".$var_parameter_dev_token."'";
$result = mysql_query($select_token_text);
if(!mysql_num_rows($result))
{
	$insert_token_text = "insert into device_push (uid,pd_devicetoken,pd_badge) VALUES ('". $user_array['uid'] ."','".$var_parameter_dev_token."',0)";
	mysql_query($insert_token_text);
	mysql_close();
	$json_buffer = '{"code":"200"}';
	echo $json_buffer;
	exit();
}
else
{
	$update_token_text = "update device_push set pd_badge=0 uid=". $user_array['uid'] ." where pd_devicetoken='".$var_parameter_dev_token."'";
	@mysql_query($update_token_text);

}
$json_buffer = '{"code":200}';
	echo $json_buffer;
	exit();
?>
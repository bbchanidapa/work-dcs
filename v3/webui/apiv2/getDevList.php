<?php
include("../db.inc.php");
if(!isset($_POST['email']))
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


$select_device_info_text = "select de_id,de_hostname,de_ipaddr,de_retire,de_uplink_ifindex,de_isFW from device";
$result_device_info = mysql_query($select_device_info_text);

if(!mysql_num_rows($result_device_info))
{
	$json_buffer = '{"code":"404"}';
	echo $json_buffer;
	exit();
}

$dev_num = 0;
while($dev_array = mysql_fetch_array($result_device_info))
{
	$arraydev[$dev_num] = $dev_array;
	$dev_num=$dev_num+1;
}

//$dataBuffer['widget1'] = $msgBuffer;

$json_buffer = '{
		"code":200,
		"data":' . json_encode($arraydev) .'
	}';
	echo $json_buffer;


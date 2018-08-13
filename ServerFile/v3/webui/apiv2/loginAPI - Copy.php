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

$select_group_text = "SELECT * FROM `group` WHERE gid = '".$user_array['groupid']."'";
$result_group = mysql_query($select_group_text);
$group_array = mysql_fetch_array($result_group);

$dataBuffer['displayname'] = $user_array['displayname'];
$dataBuffer['displaypic'] = $user_array['uid']. ".png";
$dataBuffer['gname'] = $group_array['gname'];
$dataBuffer['email'] = $user_array['email'];

$json_buffer = '{
		"code":200,
		"data":' . json_encode($dataBuffer) .'
	}';
	echo $json_buffer;
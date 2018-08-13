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

$select_group_text = "SELECT * FROM `group` WHERE gid = '".$user_array['groupid']."'";
$result_group = mysql_query($select_group_text);
$group_array = mysql_fetch_array($result_group);

//$dataBuffer['displayname'] = $user_array['displayname'];
//$dataBuffer['displaypic'] = $user_array['uid']. ".png";

$dataBuffer['gname'] = $group_array['gname'];
$dataBuffer['gaccess'] = $group_array['access'];
//$dataBuffer['email'] = $user_array['email'];

$json_buffer = '{
		"code":200,
		"data":' . json_encode($dataBuffer) .'
	}';
	echo $json_buffer;
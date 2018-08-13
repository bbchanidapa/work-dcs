<?php
include("../db.inc.php");
if(!isset($_POST['email']) || !isset($_POST['action']))
{
	$json_buffer = '{
		"code":302,
		"data":""
	}';
	echo $json_buffer;
	exit();
}

$email = $_POST['email'];
$action = $_POST['action'];

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

if($action == "get")
{
	$arraydev['notificationStatus'] = $user_array['setting_notification'];
	$arraydev['emailStatus'] = $user_array['setting_email'];
	$result_setting = mysql_query("select value from system_settings where variable='alertover'");
	if(mysql_num_rows($result_setting))
	{
		$setting_array = mysql_fetch_array($result_setting);
		$arraydev['alertover'] = $setting_array['value'];
	}
	else
	{
		$arraydev['alertover'] = "";
	}
	$json_buffer = '{
		"code":200,
		"data":' . json_encode($arraydev) .'
	}';
	echo $json_buffer;
}
else if($action == "set")
{
	if(!isset($_POST['variable']) || !isset($_POST['value']))
	{
		$json_buffer = '{
			"code":302,
			"data":""
		}';
		echo $json_buffer;
		exit();
	}
	$xVariable = $_POST['variable'];
	$xValue = $_POST['value'];
	if($xVariable == "notification")
	{
		mysql_query("update user set setting_notification=".$xValue." where email='".$user_array['email']."'");
		$json_buffer = '{
			"code":200,
			"data":""
		}';
		echo $json_buffer;
	}
	if($xVariable == "email")
	{
		mysql_query("update user set setting_email=".$xValue." where email='".$user_array['email']."'");
		$json_buffer = '{
			"code":200,
			"data":""
		}';
		echo $json_buffer;
	}
	elseif($xVariable == "alertover")
	{
		mysql_query("update system_settings set value=".$xValue." where variable='alertover'");
		$json_buffer = '{
			"code":200,
			"data":""
		}';
		echo $json_buffer;

	}
}

/*$select_group_text = "SELECT * FROM `group` WHERE gid = '".$user_array['groupid']."'";
$result_group = mysql_query($select_group_text);
$group_array = mysql_fetch_array($result_group);

$dataBuffer['displayname'] = $user_array['displayname'];
$dataBuffer['displaypic'] = $user_array['displaypic'];
$dataBuffer['gname'] = $group_array['gname'];

$json_buffer = '{
		"code":200,
		"data":' . json_encode($dataBuffer) .'
	}';
	echo $json_buffer;*/
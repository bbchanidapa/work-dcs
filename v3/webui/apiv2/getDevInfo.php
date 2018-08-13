<?php
include("../db.inc.php");
if(!isset($_POST['email']) || !isset($_POST['de_id']))
{
	$json_buffer = '{
		"code":302,
		"data":""
	}';
	echo $json_buffer;
	exit();
}

$email = $_POST['email'];
$de_id = $_POST['de_id'];

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

$select_device_info_text = "select * from device where de_id=".$de_id."";
$result_device_info = mysql_query($select_device_info_text);
if(!mysql_num_rows($result_device_info))
{
	$json_buffer = '{"code":"401"}';
	echo $json_buffer;
	exit();
}
$array_device_info = mysql_fetch_array($result_device_info);

$select_device_usage_text = "select * from device_usage where de_id=" . $de_id . " order by du_id desc LIMIT 0,1";
$result_device_usage = mysql_query($select_device_usage_text);
if(!mysql_num_rows($result_device_usage))
{
	$var_cpu = 0;
	$var_mem = 0;
	$var_temp = "Unknow";
	$var_uptime = "Unknow";
	$final_mem = 0;
	$var_ping = 0;
}
else
{
	$array_device_usage = mysql_fetch_array($result_device_usage);
	$var_cpu = $array_device_usage['du_cpu'];
	$var_mem = $array_device_usage['du_memory'];
	$var_temp = $array_device_usage['du_temp'];
	$var_uptime = $array_device_usage['du_uptime'];

	$final_mem = round(($var_mem * 100) / $array_device_info['de_memory']);
	$var_ping = number_format((float)$array_device_usage['du_ping'],3);

}

$arraydev['de_hostname'] = $array_device_info['de_hostname'];
$arraydev['de_model'] = $array_device_info['de_model'];
$arraydev['de_version'] = $array_device_info['de_version'];
$arraydev['de_description'] = $array_device_info['de_description'];
$arraydev['de_ipaddr'] = $array_device_info['de_ipaddr'];
$arraydev['de_retire'] = $array_device_info['de_retire'];
$arraydev['de_uplink_ifindex'] = $array_device_info['de_uplink_ifindex'];
$arraydev['de_isfw'] = $array_device_info['de_isfw'];


$arraydev['du_cpu'] = $var_cpu;
$arraydev['du_memory'] = $final_mem;
$arraydev['du_temp'] = $var_temp;
$arraydev['du_uptime'] = $var_uptime;
$arraydev['du_ping'] = $var_ping;


$json_buffer = '{
		"code":200,
		"data":' . json_encode($arraydev) .'
	}';
	echo $json_buffer;

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
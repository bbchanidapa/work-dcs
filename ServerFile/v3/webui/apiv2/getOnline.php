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

$current_datetime = new DateTime(date("Y-m-d H:i:s", time()));

$select_dhcp_text = "SELECT * FROM dhcp_wiredonline where p_date = '" . $current_datetime->format("Y-m-d") . "'";
$result_dhcp = mysql_query($select_dhcp_text);
$devBuffer['device_count'] = mysql_num_rows($result_dhcp);

if(mysql_num_rows($result_dhcp))
{
	$arrRunner = 0;
	while($dev_array = mysql_fetch_array($result_dhcp))
	{
		$event['p_date'] = $dev_array['p_date'];
		$event['p_ip'] = $dev_array['p_ipaddr'];
		$event['p_mac'] = $dev_array['p_mac'];
		$event['p_hostname'] = $dev_array['p_hostname'];
		$event['p_room'] = $dev_array['p_room'];
		

		$dataBuffer[$arrRunner] = $event;
		$arrRunner = $arrRunner + 1;
	}
	
	$json_buffer = '{
		"code":200,
		"data":' . json_encode($dataBuffer,JSON_UNESCAPED_UNICODE) .'
	}';
	echo $json_buffer;


}
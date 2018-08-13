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

$ifindex = array();
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
	$ifindex[$dev_num] = $dev_array['de_uplink_ifindex'];
	$dev_num=$dev_num+1;
	
}

//$dataBuffer['widget1'] = $msgBuffer;

$select_device_traffic_text = "select * from device_iftraffic where dt_id=(select dt_id from device_time order by dt_id desc LIMIT 0,1) order by de_id asc";
	$result_device_traffic = mysql_query($select_device_traffic_text);
	$traffic_count = 0;
	while($array_device_traffic = mysql_fetch_array($result_device_traffic))
	{
		

		for($i = 1;$i<=7;$i++)
		{
			if($array_device_traffic['de_id'] == $i && $array_device_traffic['di_ifid'] == $ifindex[$i-1])
			{
				//echo $array_device_traffic['df_avgin'] ."<br>";
				$array_in_ocet[$traffic_count] = round(($array_device_traffic['df_avgin']/5)/60);
				$array_out_ocet[$traffic_count] = round(($array_device_traffic['df_avgout']/5)/60);
				$traffic_count++;

			}

		}
		
	}
$total_traffic = 0;
$i = 0;
for($i = 0;$i<7;$i++)
{
	if($i != 0 && $i != 6 && $i !=1)
	{
		$total_traffic = $total_traffic + (((int)$array_in_ocet[$i]) + ((int)$array_out_ocet[$i]));
		//echo $i . " ---- " . (((int)$array_in_ocet[$i]) + ((int)$array_out_ocet[$i])) . "<br>";
	}
	elseif ($i == 1)
	{
		$total_traffic = $total_traffic + (((int)$array_in_ocet[$i] + (int)$array_out_ocet[$i]) - ((int)$array_in_ocet[2] + (int)$array_out_ocet[2]));
		//echo $i . " ---- " . (((int)$array_in_ocet[$i]) + ((int)$array_out_ocet[$i])) . "<br>";
	}
}
$i = 0;
for($i = 0;$i<7;$i++)
{
	$temparray = $arraydev[$i];
	if($i == 0 || $i == 6)
	{
		$temparray['ratio'] = "----";
	}
	elseif ($i == 1)
	{
		$temparray['ratio'] = number_format((float)(((((int)$array_in_ocet[$i] + (int)$array_out_ocet[$i]) - ((int)$array_in_ocet[2] + (int)$array_out_ocet[2]))*100)/$total_traffic),2);
	}
	else
	{
		$temparray['ratio'] = number_format((float)((((int)$array_in_ocet[$i] + (int)$array_out_ocet[$i])*100)/$total_traffic),2);
		
	}
	$arraydev[$i] = $temparray;
}

$json_buffer = '{
		"code":200,
		"data":' . json_encode($arraydev) .'
	}';
	echo $json_buffer;


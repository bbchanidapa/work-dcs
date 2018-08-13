<?php
	include("../db.inc.php");
	include("../function.api.inc.php");
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

$downlist = "";
$status = 0;

$ifindex = array();
$array_in_ocet = array();
$array_out_ocet = array();

$select_device_info_text = "select * from device";
$result_device_info = mysql_query($select_device_info_text);
if(!mysql_num_rows($result_device_info))
{
	for($i=0;$i<6;$i++)
	{
		$line[$i] = 0;
	}
}
else
{
	for($i=0;$i<6;$i++)
	{
		$line[$i] = 1;
	}
	$var_counter = 0;
	while($array_device_info = mysql_fetch_array($result_device_info))
	{
		if($array_device_info['de_retire'] != 0)
		{
			$downlist = $downlist . $array_device_info['de_hostname'] . " ";
			$status = 1;
		}

		if($array_device_info['de_id'] == 1 && $array_device_info['de_retire'] != 0)
		{
			$line[0] = 0;
			$line[1] = 0;
			$line[2] = 0;
			$line[3] = 0;
			$line[4] = 0;
			$line[5] = 0;
		}
		else if($array_device_info['de_id'] == 2 && $array_device_info['de_retire'] != 0)
		{
			$line[1] = 0;
			$line[5] = 0;
		}
		else if($array_device_info['de_id'] == 3 && $array_device_info['de_retire'] != 0)
		{
			$line[5] = 0;
		}
		else if($array_device_info['de_id'] == 4 && $array_device_info['de_retire'] != 0)
		{
			$line[2] = 0;
		}
		else if($array_device_info['de_id'] == 5 && $array_device_info['de_retire'] != 0)
		{
			$line[3] = 0;
		}
		else if($array_device_info['de_id'] == 6 && $array_device_info['de_retire'] != 0)
		{
			$line[4] = 0;
		}
		else if($array_device_info['de_id'] == 7 && $array_device_info['de_retire'] != 0)
		{
			$line[0] = 0;
		}
		
		$ifindex[$var_counter] = $array_device_info['de_uplink_ifindex'];
		$var_counter = $var_counter + 1;

	}


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
	

	
}


		$var_scale_text =  UnitConvert($array_out_ocet,$array_in_ocet);


		$arraydev['df_avgout'] = $array_out_ocet;
		$arraydev['df_avgin'] = $array_in_ocet;
		$arraydev['df_avgoutunit'] = $var_scale_text;
		$arraydev['state_line'] = $line;
		$arraydev['status'] = $status;
		$arraydev['downlist'] = $downlist;

		
		
		$json_buffer = '{"code":200,"data":' . json_encode($arraydev) . '}';
		echo $json_buffer;

?>
<?php
	include("../db.inc.php");
	include("../function.api.inc.php");

	if(!isset($_GET['email']) || !isset($_GET['de_id']))
{
	$json_buffer = '{
		"code":302,
		"data":""
	}';
	echo $json_buffer;
	exit();
}

$email = $_GET['email'];
$de_id = $_GET['de_id'];

$var_parameter_de_id = $de_id;

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

	$select_device_interface_join_device_iftraffic_text ="select device_interface.di_ifid,device_interface.di_ifname,device_interface.di_ifstatus,device_iftraffic.df_avgin,device_iftraffic.df_avgout from 
					(select * from device_interface where de_id=".$de_id.") as device_interface join
					(select * from device_iftraffic where de_id=".$de_id." and dt_id=
					(select dt_id from device_time order by dt_id desc LIMIT 0,1)) as device_iftraffic on 
					device_interface.di_ifid = device_iftraffic.di_ifid order by (device_iftraffic.df_avgin+device_iftraffic.df_avgout) desc";

	$result_device_interface_join_device_iftraffic = mysql_query($select_device_interface_join_device_iftraffic_text);
	if(!mysql_num_rows($result_device_interface_join_device_iftraffic))
	{
		$json_buffer = '{"code":"404"}';
		echo $json_buffer;
		exit();
	}

	$dev_num = 0;
	while($array_device_interface_join = mysql_fetch_array($result_device_interface_join_device_iftraffic))
	{
		$tmparray['di_ifid'] = $array_device_interface_join['di_ifid'];
		$tmparray['di_ifname'] = $array_device_interface_join['di_ifname'];
		$tmparray['di_ifstatus'] = $array_device_interface_join['di_ifstatus'];

		$avg_in_per_sec = round(($array_device_interface_join['df_avgin']/5)/60);
		$avg_out_per_sec = round(($array_device_interface_join['df_avgout']/5)/60);

		$tmpUnit = UnitConvertVarNoSec($avg_out_per_sec);
		$tmpUnit2 = UnitConvertVarNoSec($avg_in_per_sec);
		
		$tmparray['df_avgout'] = number_format($avg_out_per_sec,2);
		$tmparray['df_avgoutunit'] = $tmpUnit;

		$tmpUnit = UnitConvertVar($avg_in_per_sec);
		$tmparray['df_avgin'] = number_format($avg_in_per_sec,2);
		$tmparray['df_avginunit'] = $tmpUnit2;


		$arraydev[$dev_num] = $tmparray;
		$dev_num=$dev_num+1;
	}


	$json_buffer = '{"code":200,"data":' . json_encode($arraydev) . '}';
	echo $json_buffer;


?>
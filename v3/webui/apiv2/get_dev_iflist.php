<?php
	include("../db.inc.php");
	include("../function.api.inc.php");
	if(!isset($_GET['de_id']))
	{
		$json_buffer = '{"code":"302"}';
		echo $json_buffer;
		exit();
	}
	$select_device_interface_text = "select di_ifid,di_ifname,di_ifspeed,di_ifstatus,di_ipaddr,di_subnet,di_vlanid from device_interface where de_id=".$_GET['de_id'];
	$result_device_interface = mysql_query($select_device_interface_text);
	
	if(!mysql_num_rows($result_device_interface))
	{
		$json_buffer = '{"code":"404"}';
		echo $json_buffer;
		exit();
	}
	$dev_num = 0;
	while($dev_array = mysql_fetch_array($result_device_interface))
	{
		$arraydev[$dev_num] = $dev_array;
		$dev_num=$dev_num+1;
	}


	$json_buffer = '{"code":"200","content":' . json_encode($arraydev) . '}';
	echo $json_buffer;


?>
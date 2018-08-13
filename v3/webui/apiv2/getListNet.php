<?php
include("../db.inc.php");
include("../function.api.inc.php");
include("../ip2net.inc.php");
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

$select_many_join_text = "select TfRate.dv_vlanid,TfRate.de_id,TfRate.dv_vlanname ,device_interface.di_ipaddr,device_interface.di_subnet from device_interface join (select Tfdata.df_avgin,Tfdata.df_avgout,device_vlan.dv_vlanid,Tfdata.de_id,device_vlan.dv_vlanname ,Tfdata.totaltraffic from (select sum(device_iftraffic.df_avgin) as df_avgin,sum(device_iftraffic.df_avgout) as df_avgout,sum(device_iftraffic.df_avgin)+sum(device_iftraffic.df_avgout) as totaltraffic,device_iftraffic.de_id,device_interface.di_vlanid from device_iftraffic join device_interface on device_iftraffic.de_id = device_interface.de_id and device_iftraffic.di_ifid = device_interface.di_ifid and  dt_id=(select dt_id from device_time order by dt_id desc LIMIT 0,1) GROUP BY device_interface.di_vlanid) as Tfdata join device_vlan on device_vlan.dv_vlanid = Tfdata.di_vlanid and device_vlan.dv_vlanid != 0 and device_vlan.dv_vlanid != 99 and device_vlan.dv_vlanid != 1) as TfRate on device_interface.de_id = TfRate.de_id and device_interface.di_ifid = TfRate.dv_vlanid order by TfRate.dv_vlanid";

$result_many_join = mysql_query($select_many_join_text);
if(!mysql_num_rows($result_many_join))
{
	echo "Please wait while data updating and try again later";
	exit();
}

$array_slot = 0;
while($array_many_join = mysql_fetch_array($result_many_join))
{
	/*if($array_many_join['di_ipaddr'] == "" || $array_many_join['di_subnet'] == "")
	{
		$array_netid[$array_slot] = "";
	}
	else
	{
		$array_netid[$array_slot] = ip2net($array_many_join['di_ipaddr'],$array_many_join['di_subnet']);
	}
	$array_vlanid[$array_slot] = $array_many_join['dv_vlanid'];
	$array_vlanname[$array_slot] = $array_many_join['dv_vlanname'];
	$array_label[$array_slot] = $array_many_join['dv_vlanname'] ;
	$array_slot = $array_slot + 1;*/


	$tmp_array['netid'] = "";
	if($array_many_join['di_ipaddr'] == "" || $array_many_join['di_subnet'] == "")
	{
		$tmp_array['netid'] = "Not Assigned.";
	}
	else
	{
		$tmp_array['netid'] = ip2net($array_many_join['di_ipaddr'],$array_many_join['di_subnet']);
	}
	$tmp_array['vlanid'] = $array_many_join['dv_vlanid'];
	$tmp_array['vlanname'] = $array_many_join['dv_vlanname'];
	$array_total[$array_slot] = $tmp_array;
	$array_slot = $array_slot + 1;



}



		/*$arraydev['df_label'] = $array_label;
		$arraydev['df_vlanid'] = $array_vlanid;
		$arraydev['df_netid'] = $array_netid;*/
		
		$json_buffer = '{"code":200,"data":' . json_encode($array_total) . '}';
		echo $json_buffer;


?>
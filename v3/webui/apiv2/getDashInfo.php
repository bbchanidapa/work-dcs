<?php
include("../db.inc.php");
include("../function.api.inc.php");
if(!isset($_REQUEST['email']))
{
	$json_buffer = '{
		"code":302,
		"data":""
	}';
	echo $json_buffer;
	exit();
}

$email = $_REQUEST['email'];

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

$select_evtid_text = "SELECT * FROM `device_event` WHERE devt_id > " . $user_array['devt_id'] ." ORDER BY devt_id DESC";

$result_evtid = mysql_query($select_evtid_text);

$msgBuffer['msg_count'] = mysql_num_rows($result_evtid);

if(mysql_num_rows($result_evtid))
{
	if(mysql_num_rows($result_evtid) > 4) $max_num = 4;
	else $max_num = mysql_num_rows($result_evtid);
	for($i = 0;$i < $max_num;$i++)
	{
		$devt_array = mysql_fetch_array($result_evtid);

		$msgDateTime = new DateTime($devt_array['devt_dtime']);
		$tmpmsg = $msgDateTime->format("[m/d H:i] ");
		$tmpmsg = $tmpmsg . $devt_array['devt_message'];

		$msgArray[$i] = $tmpmsg;
		
	}
	$msgBuffer['msg'] = $msgArray;
}
else
{
	$msgBuffer['msg'] = "";
}

$dataBuffer['widget1'] = $msgBuffer;


// ====================================== WIDGET 2 =======================================
$dataBuffer['widget2'] = "";

$var_parameter_de_id = 7;
$var_parameter_ifid = 3;

$select_device_info_text = "select * from device where de_id=".$var_parameter_de_id."";
$result_device_info = mysql_query($select_device_info_text);

$dev_array = mysql_fetch_array($result_device_info);
$select_device_interface_text = "select * from device_interface where de_id=".$var_parameter_de_id." and di_ifid=".$var_parameter_ifid."";
$result_device_interface = mysql_query($select_device_interface_text);

$if_array = mysql_fetch_array($result_device_interface);
$select_device_time_text = "select * from device_time LIMIT 0,1";
$result_device_time = mysql_query($select_device_time_text);

$array_device_time = mysql_fetch_array($result_device_time);
$var_start_datetime = new DateTime($array_device_time['dt_stime']);

$select_device_time_text = "select * from device_time order by dt_id desc LIMIT 0,1";
$result_device_time = mysql_query($select_device_time_text);

$array_device_time = mysql_fetch_array($result_device_time);
$var_end_datetime = new DateTime($array_device_time['dt_etime']);


$var_form_sy = $var_start_datetime->format("Y");
$var_form_sm = $var_start_datetime->format("m");
$var_form_sd = $var_start_datetime->format("d");
$var_form_sh = $var_start_datetime->format("H");
$var_form_si = $var_start_datetime->format("i");

$array_device_interface = mysql_fetch_array($result_device_interface);
			$select_device_traffic_text = "select * from (select * from device_iftraffic where de_id=" . $var_parameter_de_id ." and di_ifid=".$var_parameter_ifid." order by dt_id desc LIMIT 0,7) as test order by dt_id asc";


$result_device_traffic = mysql_query($select_device_traffic_text);

if(mysql_num_rows($result_device_traffic) < 2 )
{

}
else
{
	$var_counter = 0;
	while($array_device_traffic = mysql_fetch_array($result_device_traffic))
	{
		$select_device_time_text = "select * from device_time where dt_id=".$array_device_traffic['dt_id']."";
		$result_device_time = mysql_query($select_device_time_text);
		$array_device_time = mysql_fetch_array($result_device_time);

		$array_in_ocet[$var_counter] = round(($array_device_traffic['df_avgin']/5)/60);
		$array_out_ocet[$var_counter] = round(($array_device_traffic['df_avgout']/5)/60);

		$tempdate = new DateTime($array_device_time['dt_etime']);
		$array_label[$var_counter] = $tempdate->format("H:i");
		$var_counter = $var_counter + 1;

	}
}

$var_scale_text =  UnitConvert($array_out_ocet,$array_in_ocet);
$select_device_time_text = "select * from device_time LIMIT 0,1";
$result_device_time = mysql_query($select_device_time_text);
$array_device_time = mysql_fetch_array($result_device_time);
$var_start_datetime = new DateTime($array_device_time['dt_stime']);
$select_device_time_text = "select * from device_time order by dt_id desc LIMIT 0,1";
$result_device_time = mysql_query($select_device_time_text);
$array_device_time = mysql_fetch_array($result_device_time);
$var_end_datetime = new DateTime($array_device_time['dt_etime']);



$arraydev['in_min'] = number_format(min($array_in_ocet),2,'.','');
$arraydev['in_max'] = number_format(max($array_in_ocet),2,'.','');
$arraydev['in_avg'] = number_format(array_sum($array_in_ocet)/count($array_in_ocet),2,'.','');
$arraydev['in_cur'] = number_format($array_in_ocet[count($array_in_ocet)-1],2,'.','');

//echo number_format(preg_replace('/[\$,]/', '', min($array_out_ocet)),2);

$arraydev['out_min'] = min($array_out_ocet);
$arraydev['out_max'] = max($array_out_ocet);
$arraydev['out_avg'] = number_format(array_sum($array_out_ocet)/count($array_out_ocet),2,'.','');
$arraydev['out_cur'] = number_format($array_out_ocet[count($array_out_ocet)-1],2,'.','');

$arraydev['devunit'] = $var_scale_text;

$dataBuffer['widget2'] = $arraydev;




//======================= WIDGET 3 ==============================

$user_array = mysql_fetch_array($result_user);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://10.4.15.101/fitmmon/v3/webui/asdm_curl.php');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);

curl_close($ch);


if($result == "")
{
	echo "ASDM_CONNECTION_FAILED";
	exit();
}
$array_string = explode('<top-hosts type="receive-byte" rate_interval="3600">',$result);
$array_string2 = explode('</top-hosts>',$array_string[1]);

$xml   = simplexml_load_string("<top10>" . $array_string2[0] . "</top10>");
$json = json_encode($xml);
$array = json_decode($json,TRUE);

$array_identify = array();

for($i = 0;$i<3;$i++)
{
	$array_ip[$i] = $array['host'][$i]['ip-addr'];
	$array_totalocet[$i] = $array['host'][$i]['total'];
	$array_currentocet[$i] = ($array['host'][$i]['current']/60);

	//echo 'http://202.44.47.47/unifi/user?ip='.$array_ip[$i];
	$temp = curl_init();
	//curl_setopt($temp, CURLOPT_URL, 'http://202.44.47.47/unifi/user?ip='.$array_ip[$i]);
	curl_setopt($temp, CURLOPT_URL, 'http://202.44.47.47/unifi/user-for-netmon?ip='.$array_ip[$i]);
	curl_setopt($temp, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($temp, CURLOPT_HEADER, 0);
	curl_setopt($temp, CURLOPT_BINARYTRANSFER, 1);
	curl_setopt($temp, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($temp);
	curl_close($temp);
	$temp_array = (array)json_decode($result);

	if($temp_array['code'] == "200")
	{
		$temp_data_x = (array)$temp_array['data'];
		$temp_data = (array)$temp_data_x[0];
		$array_mode[$i] = 2;

		if (array_key_exists('name', $temp_data)) 
			$array_identify[$i] = $temp_data['name'];
		else if (array_key_exists('email', $temp_data))
			$array_identify[$i] = $temp_data['email'];
		else if (array_key_exists('hostname', $temp_data))
			$array_identify[$i] = $temp_data['hostname'];
		else
			$array_identify[$i] = $array_ip[$i];
	}
	if($temp_array['code'] == "201")
	{
		$temp_data_x = (array)$temp_array['data'];
		$temp_data = (array)$temp_data_x[0];
		$array_mode[$i] = 2;

		if (array_key_exists('name', $temp_data)) 
			$array_identify[$i] = $temp_data['name'];
		else if (array_key_exists('email', $temp_data))
			$array_identify[$i] = $temp_data['email'];
		else if (array_key_exists('hostname', $temp_data))
			$array_identify[$i] = $temp_data['hostname'];
		else
			$array_identify[$i] = $array_ip[$i];
	}
	else if($temp_array['code'] == "404")
	{
		$temp = curl_init();
		curl_setopt($temp, CURLOPT_URL, 'http://10.4.15.60/dhcpv2/api/getInfobyIP.php?ip_address='.$array_ip[$i]);
		curl_setopt($temp, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($temp, CURLOPT_HEADER, 0);
		curl_setopt($temp, CURLOPT_BINARYTRANSFER, 1);
		curl_setopt($temp, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($temp, CURLOPT_CONNECTTIMEOUT_MS,2000);
		$result = curl_exec($temp);
		curl_close($temp);
		
		
		$temp_array = @(array)json_decode(str_replace('<meta http-equiv="Content-Type" content="text/html; charset=utf-8">','',$result));
		if(@$temp_array['code'] == "200")
		{
			$temp_data = (array)$temp_array['data'];
			$array_mode[$i] = 1;
			if (array_key_exists('hostname', $temp_data))
				$array_identify[$i] = $temp_data['hostname'];
			else if (array_key_exists('computer_id', $temp_data))
				$array_identify[$i] = $temp_data['computer_id'];
			else
				$array_identify[$i] = $array_ip[$i];

		}
		else
		{
			$array_identify[$i] = $array_ip[$i];
		}
	}
}
	$var_scale_text = UnitConvertOneNoSec($array_totalocet);
	$arraywidget3['identifier'] = $array_identify;
	$arraywidget3['totalocet'] = $array_totalocet;
	$arraywidget3['unit'] = $var_scale_text;
	$dataBuffer['widget3'] = $arraywidget3;

$json_buffer = '{
		"code":200,
		"data":' . json_encode($dataBuffer) .'
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
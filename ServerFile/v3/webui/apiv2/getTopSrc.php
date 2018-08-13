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


$select_outbound_query = "select * from device_topip_outbound where dt_id = (select dt_id from device_time order by dt_id desc LIMIT 0,1) LIMIT 0,10";
$result_outbound_query = mysql_query($select_outbound_query);

$array_mode = array();
$array_email = array();
$array_hostname = array();
$array_mac = array();
$array_comid = array();
$array_room = array();
$array_name = array();
$array_ip = array();
$array_totalocet = array();
$array_currentocet = array();

$dataCount = 0;
while($array_outbound_query = mysql_fetch_array($result_outbound_query))
{
	$array_mode[$dataCount] = $array_outbound_query['tout_mode'];
	$array_email[$dataCount] = $array_outbound_query['tout_email'];
	$array_hostname[$dataCount] = $array_outbound_query['tout_hostname'];
	$array_mac[$dataCount] = $array_outbound_query['tout_mac'];
	$array_comid[$dataCount] = $array_outbound_query['tout_cid'];
	$array_room[$dataCount] = $array_outbound_query['tout_room'];
	$array_name[$dataCount] = $array_outbound_query['tout_name'];
	$array_ip[$dataCount] = $array_outbound_query['tout_ip'];
	$array_totalocet[$dataCount] = $array_outbound_query['tout_totalusage'];
	$array_currentocet[$dataCount] = $array_outbound_query['tout_current'];
	$dataCount++;

}


$var_scale_text = UnitConvertOneNoSec($array_totalocet);
$var_scale_text2 = UnitConvertOne($array_currentocet);


		$arraydev['ip'] = $array_ip;
		$arraydev['totalocet'] = $array_totalocet;
		$arraydev['totalunit'] = $var_scale_text;
		$arraydev['currentocet'] = $array_currentocet;
		$arraydev['currentunit'] = $var_scale_text2;
		$arraydev['ip_mode'] = $array_mode;
		$arraydev['ip_email'] = $array_email;
		$arraydev['ip_hostname'] = $array_hostname;
		$arraydev['ip_mac'] = $array_mac;
		$arraydev['ip_comid'] = $array_comid;
		$arraydev['ip_room'] = $array_room;
		$arraydev['name'] = $array_name;
		$json_buffer = '{"code":200,"data":' . json_encode($arraydev) . '}';
		echo $json_buffer;
/*$user_array = mysql_fetch_array($result_user);
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
$array_string = explode('<top-hosts type="send-byte" rate_interval="3600">',$result);
$array_string2 = explode('</top-hosts>',$array_string[1]);

$xml   = simplexml_load_string("<top10>" . $array_string2[0] . "</top10>");
$json = json_encode($xml);
$array = json_decode($json,TRUE);


for($i = 0;$i<count($array['host']);$i++)
{

	$array_ip[$i] = $array['host'][$i]['ip-addr'];
	$array_totalocet[$i] = $array['host'][$i]['total'];
	$array_currentocet[$i] = ($array['host'][$i]['current']/60);

	//echo 'http://202.44.47.47/unifi/user?ip='.$array_ip[$i];
	$temp = curl_init();
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
			if (array_key_exists('email', $temp_data)) $array_email[$i] = $temp_data['email'];
			else $array_email[$i] = "";
			if (array_key_exists('hostname', $temp_data)) $array_hostname[$i] = $temp_data['hostname'];
			else $array_hostname[$i] = "";
			if (array_key_exists('mac', $temp_data)) $array_mac[$i] = $temp_data['mac'];
			else $array_mac[$i] = "";
			if (array_key_exists('name', $temp_data)) $array_name[$i] = $temp_data['name'];
			else $array_name[$i] = "";

			$array_comid[$i] = "";
			$array_room[$i] = "";
		
	}
	else if($temp_array['code'] == "201")
	{
		
			
			$temp_data_x = (array)$temp_array['data'];
			$temp_data = (array)$temp_data_x[0];
			$array_mode[$i] = 2;
			if (array_key_exists('email', $temp_data)) $array_email[$i] = $temp_data['email'];
			else $array_email[$i] = "";
			if (array_key_exists('hostname', $temp_data)) $array_hostname[$i] = $temp_data['hostname'];
			else $array_hostname[$i] = "";
			if (array_key_exists('mac', $temp_data)) $array_mac[$i] = $temp_data['mac'];
			else $array_mac[$i] = "";
			if (array_key_exists('name', $temp_data)) $array_name[$i] = $temp_data['name'];
			else $array_name[$i] = "";

			$array_comid[$i] = "";
			$array_room[$i] = "";
		
	}
	else if($temp_array['code'] == "404")
	{
		$temp = curl_init();
		curl_setopt($temp, CURLOPT_URL, 'http://10.4.15.60/dhcpv2/api/getInfobyIP.php?ip_address='.$array_ip[$i]);
		curl_setopt($temp, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($temp, CURLOPT_HEADER, 0);
		curl_setopt($temp, CURLOPT_BINARYTRANSFER, 1);
		curl_setopt($temp, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($temp);
		curl_close($temp);
		
		
		$temp_array = @(array)json_decode(str_replace('<meta http-equiv="Content-Type" content="text/html; charset=utf-8">','',$result));
		//print_r($temp_array);
		if(@$temp_array['code'] == "200")
		{
			$temp_data = (array)$temp_array['data'];
			$array_mode[$i] = 1;
			$array_email[$i] = "";
			$array_name[$i] = "";
			if (array_key_exists('hostname', $temp_data)) $array_hostname[$i] = $temp_data['hostname'];
			else $array_hostname[$i] = "";
			if (array_key_exists('mac_address', $temp_data)) $array_mac[$i] = str_replace("-",":",$temp_data['mac_address']);
			else $array_mac[$i] = "";
			if (array_key_exists('device_id', $temp_data)) $array_comid[$i] = $temp_data['device_id'];
			else $array_comid[$i] = "";
			if (array_key_exists('room', $temp_data)) $array_room[$i] = $temp_data['room'];
			else $array_room[$i] = "";
			if (array_key_exists('name', $temp_data)) $array_name[$i] = $temp_data['name'];
			else $array_name[$i] = "";

		}
		else
		{
			$temp = curl_init();
			curl_setopt($temp, CURLOPT_URL, 'http://202.44.47.47/fitmmon/v3/webui/apiv2/getWhois.php?ip='.$array_ip[$i]);
			curl_setopt($temp, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($temp, CURLOPT_HEADER, 0);
			curl_setopt($temp, CURLOPT_BINARYTRANSFER, 1);
			curl_setopt($temp, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec($temp);
			curl_close($temp);

			$temp_array = (array)json_decode($result);

			if($temp_array['code'] == "200")
			{
		
			
			//$temp_data_x = (array)$temp_array['data'];
			//$temp_data = (array)$temp_data_x[0];
			

				$array_mode[$i] = 0;
				$array_email[$i] = "";
				$array_hostname[$i] = $temp_array['data'];
				$array_mac[$i] = "";
				$array_comid[$i] = "";
				$array_room[$i] = "";
				$array_name[$i] = "";
		
			}
			else
			{
				$array_mode[$i] = 0;
				$array_email[$i] = "";
				$array_hostname[$i] = "";
				$array_mac[$i] = "";
				$array_comid[$i] = "";
				$array_room[$i] = "";
				$array_name[$i] = "";
			}
		}
	}
	
}

$var_scale_text = UnitConvertOneNoSec($array_totalocet);
$var_scale_text2 = UnitConvertOne($array_currentocet);


		$arraydev['ip'] = $array_ip;
		$arraydev['totalocet'] = $array_totalocet;
		$arraydev['totalunit'] = $var_scale_text;
		$arraydev['currentocet'] = $array_currentocet;
		$arraydev['currentunit'] = $var_scale_text2;
		$arraydev['ip_mode'] = $array_mode;
		$arraydev['ip_email'] = $array_email;
		$arraydev['ip_hostname'] = $array_hostname;
		$arraydev['ip_mac'] = $array_mac;
		$arraydev['ip_comid'] = $array_comid;
		$arraydev['ip_room'] = $array_room;
		$arraydev['name'] = $array_name;
		$json_buffer = '{"code":200,"data":' . json_encode($arraydev) . '}';
		echo $json_buffer;*/

?>


			
		



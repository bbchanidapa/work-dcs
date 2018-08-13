<?php
include("dbi.inc.php");
include("function.api.inc.php");

header("content-type:text/javascript;charset=utf-8");   
date_default_timezone_set('Asia/Bangkok');



$current_datetime = new DateTime(date("Y-m-d H:i:s", time()));
$unixtime = strtotime($current_datetime->format("Y-m-d H:i:s"));
$yesterday = strtotime('-1 day', $unixtime);
$yesterday_datetime = new DateTime(date("Y-m-d H:i:s", $yesterday));
$yesterday_datetime->setTime ( 21 , 0, 0 );
$yesterdayunix = strtotime($yesterday_datetime->format("Y-m-d H:i:s"));

$arrayhost = array();

for($i=0;$i<9;$i++)
{
	
	$temp_datetime = new DateTime(date("Y-m-d H:i:s", $yesterdayunix));
	echo strtotime($temp_datetime->format("Y-m-d H:i:s")) . "\r\n";
	$temp = curl_init();
	curl_setopt($temp, CURLOPT_URL, 'http://10.4.15.60/sumlog/getUserNetMon.php?unixTime='.strtotime($temp_datetime->format("Y-m-d H:i:s")));
	curl_setopt($temp, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($temp, CURLOPT_HEADER, 0);
	curl_setopt($temp, CURLOPT_BINARYTRANSFER, 1);
	curl_setopt($temp, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($temp);
	curl_close($temp);

	$temp_array = json_decode($result,1);

	
	if(array_key_exists("code",$temp_array))
	{
		if($temp_array['code'] == "200")
		{
			for($j=0;$j<count($temp_array['data']);$j++)
			{
				$temp_array2['mac'] = $temp_array['data'][$j]['mac'];
				$temp_array2['ip'] = $temp_array['data'][$j]['ip_addr'];
				$temp_array2['hostname'] = $temp_array['data'][$j]['hostname'];
				$temp_array2['room'] = $temp_array['data'][$j]['room'];

				$arrayhost[$temp_array['data'][$j]['ip_addr']] = $temp_array2;
			}
		}
	}
	$yesterdayunix = strtotime('1 hours', $yesterdayunix);
}


print_r($arrayhost);

$query_text = "";
$tempzero = 0;

foreach($arrayhost as $key => $value)
{
	
	if ($tempzero == 0)
	{
		$tempzero = 1;
		$query_text = "insert into dhcp_wiredonline (p_date,p_ipaddr,p_mac,p_hostname,p_room) VALUES ('" . $current_datetime->format("Y-m-d") . "','" . $value['ip'] . "','" . $value['mac'] . "','" . $value['hostname'] . "','" . $value['room'] . "')";
	}
	else
	{
		$query_text = $query_text . ",('" . $current_datetime->format("Y-m-d") . "','" . $value['ip'] . "','" . $value['mac'] . "','" . $value['hostname'] . "','" . $value['room'] . "')";
	}

}

mysql_query($query_text);
//echo $query_text;

?>
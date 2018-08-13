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
	$json_buffer = '{"code":"500"}';
	echo $json_buffer;
	exit();
}
$array_string = explode('<top-services type="receive-byte" rate_interval="3600">',$result);
$array_string2 = explode('</top-services>',$array_string[1]);

$xml   = simplexml_load_string("<top10>" . $array_string2[0] . "</top10>");
$json = json_encode($xml);
$array = json_decode($json,TRUE);


for($i = 0;$i<count($array['service']);$i++)
{
	$array_ip[$i] = $array['service'][$i]['port'];
	$array_totalocet[$i] = $array['service'][$i]['total'];
	$array_currentocet[$i] = ($array['service'][$i]['current']/60);
}

$var_scale_text = UnitConvertOneNoSec($array_totalocet);
$var_scale_text2 = UnitConvertOne($array_currentocet);


		$arraydev['service'] = $array_ip;
		$arraydev['totalocet'] = $array_totalocet;
		$arraydev['totalunit'] = $var_scale_text;
		$arraydev['currentocet'] = $array_currentocet;
		$arraydev['currentunit'] = $var_scale_text2;
		
		$json_buffer = '{"code":200,"data":' . json_encode($arraydev) . '}';
		echo $json_buffer;

?>


			
		



<?php

include("db.inc.php");
include("function.api.inc.php");

date_default_timezone_set('Asia/Bangkok');
$var_start_datetime = new DateTime(date("Y-m-d H:i:s", time()));
$var_StartYear = $var_start_datetime->format("Y");
$var_StartMonth = $var_start_datetime->format("m");
$var_StartDay = $var_start_datetime->format("d")-1;


$date_start = strtotime($var_StartYear."-".$var_StartMonth."-".$var_StartDay." 00:00");
$date_end = $date_start + 86400;

$select_device_join_text = "select * from device_event where devt_dtime >= '".date('Y-m-d H:i:s',$date_start)."' and devt_dtime <= '". date('Y-m-d H:i:s',$date_end) ."'";

$result_device_join = mysql_query($select_device_join_text);


$html = "";
if(!mysql_num_rows($result_device_join))
{
	//RECORD_NOT_FOUND
	$html = "No Event.<br>";
	
}

while($array_event = mysql_fetch_array($result_device_join))
{
	$html = $html . $array_event['devt_dtime'] . " - " . $array_event['devt_message'] . "<br>";
}

////////////////////////// TOP IP ANALYZER //////////////////////

$di_ifid = 3;
$de_id = 7;


$select_device_info_text = "select * from device where de_id=".$de_id."";
$result_device_info = mysql_query($select_device_info_text);
if(!mysql_num_rows($result_device_info))
{
	//DEVICE_NOT_FOUND
	exit();
}

$dev_array = mysql_fetch_array($result_device_info);

$select_device_interface_text = "select * from device_interface where de_id=".$de_id." and di_ifid=".$di_ifid."";
$result_device_interface = mysql_query($select_device_interface_text);
if(!mysql_num_rows($result_device_interface))
{
	//INTERFACE_NOT_FOUND
	exit();
}

$if_array = mysql_fetch_array($result_device_interface);

$select_device_time_text = "select * from device_time LIMIT 0,1";
$result_device_time = mysql_query($select_device_time_text);
if(!mysql_num_rows($result_device_time))
{
	//DEVICE_TIME_NOT_FOUND
	exit();
}

$array_device_time = mysql_fetch_array($result_device_time);
date_default_timezone_set('Asia/Bangkok');
$var_start_datetime = new DateTime(date("Y-m-d H:i:s", time()));


/*$select_device_time_text = "select * from device_time order by dt_id desc LIMIT 0,1";
$result_device_time = mysql_query($select_device_time_text);
if(!mysql_num_rows($result_device_time))
{
	//START_TIME_NOT_FOUND
	exit();
}*/


$array_device_interface = mysql_fetch_array($result_device_interface);

$date_start = strtotime($var_StartYear."-".$var_StartMonth."-".$var_StartDay." 00:00");
$date_end = $date_start + 86400;

$select_device_join_text = "select * from device_time join device_iftraffic on device_time.dt_id = device_iftraffic.dt_id where dt_etime >= '".date('Y-m-d H:i:s',$date_start)."' and dt_etime <= '". date('Y-m-d H:i:s',$date_end) ."' and de_id=".$de_id." and di_ifid=" . $di_ifid."";


$result_device_join = mysql_query($select_device_join_text);
if(!mysql_num_rows($result_device_join))
{
	//RECORD_NOT_FOUND
	exit();
}

$array_label[0]="";
$array_in_ocet[0]="";
$array_out_ocet[0]="";
$total_in=0;
$total_out=0;

$totalrecord = mysql_num_rows($result_device_join);
$precision = round($totalrecord/10);
$precision_count = 0;
$array_count = 1;
				
//Record 0
$array_device_join = mysql_fetch_array($result_device_join);
$fetch_date = new DateTime($array_device_join['dt_etime']);
$array_label[0] = $fetch_date->format("H:i");
$array_in_ocet[0] = round(($array_device_join['df_avgin']/5)/60);
$array_out_ocet[0] = round(($array_device_join['df_avgout']/5)/60);
$total_in=$total_in + round($array_device_join['df_totalin']);
$total_out=$total_out + round($array_device_join['df_totalout']);
				
while($array_device_join = mysql_fetch_array($result_device_join))
{
	$fetch_date = new DateTime($array_device_join['dt_etime']);
					
	if($precision_count == $precision)
	{
		$precision_count = 0;
		$array_label[$array_count] = $fetch_date->format("H:i");
		$array_in_ocet[$array_count] = round(($array_device_join['df_avgin']/5)/60);
		$array_out_ocet[$array_count] = round(($array_device_join['df_avgout']/5)/60);
		$total_in=$total_in + round($array_device_join['df_totalin']);
		$total_out=$total_out + round($array_device_join['df_totalout']);
	}
	else
	{
		$precision_count = $precision_count + 1;
		$array_label[$array_count] = $fetch_date->format("H:i");
		//$array_label[$array_count] = "";
		$array_in_ocet[$array_count] = round(($array_device_join['df_avgin']/5)/60);
		$array_out_ocet[$array_count] = round(($array_device_join['df_avgout']/5)/60);
		$total_in=$total_in + round($array_device_join['df_totalin']);
		$total_out=$total_out + round($array_device_join['df_totalout']);
	}
	$array_count = $array_count+1;
	
}
$inTime = array();
$inOcet = array();
$inCount = 0;
$outTime = array();
$outOcet = array();
$outCount = 0;



$in_avg_ocet = array_sum($array_in_ocet)/count($array_in_ocet);
$inPrevTraff = 0;
$inCanDisplay = 0;

$out_avg_ocet = array_sum($array_out_ocet)/count($array_out_ocet);
$outPrevTraff = 0;
$outCanDisplay = 0;
for($i=0;$i<count($array_in_ocet);$i++)
{	
	
	if ($array_in_ocet[$i] > $inPrevTraff)
	{
		$inPrevTraff = $array_in_ocet[$i];
		$inCanDisplay = 1;
	}
	else
	{
		if($inPrevTraff > $in_avg_ocet)
		{
			if ($inCanDisplay == 1)
			{
				$inTime[$inCount] = $array_label[$i-1];
				$inOcet[$inCount] = $array_in_ocet[$i-1];
				$inCount++;
				/*echo "IN_" .$array_label[$i-1] . " - ";
				echo $array_in_ocet[$i-1] . "<br>";*/

				$inCanDisplay = 0;
			}
			$inPrevTraff = $array_in_ocet[$i];
		}
		else
		{
			$inPrevTraff = $array_in_ocet[$i];
		}
	}

	if ($array_out_ocet[$i] > $outPrevTraff)
	{
		$outPrevTraff = $array_out_ocet[$i];
		$outCanDisplay = 1;
	}
	else
	{
		if($outPrevTraff > $out_avg_ocet)
		{
			if ($outCanDisplay == 1)
			{
				$outTime[$outCount] = $array_label[$i-1];
				$outOcet[$outCount] = $array_out_ocet[$i-1];
				$outCount++;
				$outCanDisplay = 0;
			}
			$outPrevTraff = $array_out_ocet[$i];
		}
		else
		{
			$outPrevTraff = $array_out_ocet[$i];
		}
	}
}


$in_query_text = "select * from device_time join device_topip_inbound on device_time.dt_id = device_topip_inbound.dt_id where tin_rank=0 and dt_etime = '";




for($i=0;$i<count($inTime);$i++)
{
	if($i == 0)
	{
		$in_query_text = $in_query_text . date('Y-m-d',$date_start). " " . $inTime[$i] ."'";
	}
	else
	{
		$in_query_text = $in_query_text ." OR tin_rank=0 and dt_etime = '". date('Y-m-d',$date_start). " " . $inTime[$i] ."'";
	}
}


$out_query_text = "select * from device_time join device_topip_outbound on device_time.dt_id = device_topip_outbound.dt_id where tout_rank=0 and dt_etime = '";

for($i=0;$i<count($outTime);$i++)
{
	if($i == 0)
	{
		$out_query_text = $out_query_text . date('Y-m-d',$date_start). " " . $inTime[$i] ."'";
	}
	else
	{
		$out_query_text = $out_query_text ." OR tout_rank=0 and dt_etime = '". date('Y-m-d',$date_start). " " . $outTime[$i] ."'";
	}
}
$inbound_peek_html = "";

$inbound_peek_html = $inbound_peek_html . "<h5>Inbound Traffic Peek Report (ASDM Destination) </h5><hr>";
$in_result = mysql_query($in_query_text);
while($in_array = mysql_fetch_array($in_result))
{
	$tmpOcet = $in_array['tin_totalusage'];
	$tmpUnit = UnitConvertVar($tmpOcet);
	$inbound_peek_html = $inbound_peek_html . "<strong><u>At Time ".$in_array['dt_etime'] . "</u><br></strong>";
	$inbound_peek_html = $inbound_peek_html . "IP Address : " . $in_array['tin_ip'] . "<br>";
	$inbound_peek_html = $inbound_peek_html . "Usage (1 Hour) :  "  . $tmpOcet . " " . $tmpUnit . "<br>";
	if($in_array['tin_mode'] == 0)
	{
		$inbound_peek_html = $inbound_peek_html . "Access Line : Unknow<br>";
		$inbound_peek_html = $inbound_peek_html . "Whois : " . $in_array['tin_hostname'] . "<br>";
	}
	else if($in_array['tin_mode'] == 1)
	{
		$inbound_peek_html = $inbound_peek_html . "Access Line : Wired Network (API Powered by DHCP Group)<br>";
		$inbound_peek_html = $inbound_peek_html . "Hostname : " . $in_array['tin_hostname'] . "<br>";
		$inbound_peek_html = $inbound_peek_html . "MAC Address : " . $in_array['tin_mac']. "<br>";
		$inbound_peek_html = $inbound_peek_html . "Computer ID : " . $in_array['tin_cid']. "<br>";
		$inbound_peek_html = $inbound_peek_html . "Name : " . $in_array['tin_name']. "<br>";
		$inbound_peek_html = $inbound_peek_html . "Room : " . $in_array['tin_room']. "<br>";
		//echo "Tin Name: " . $in_array['tin_cid'];
	}
	else if($in_array['tin_mode'] == 2)
	{
		$inbound_peek_html = $inbound_peek_html . "Access Line : Wi-Fi Network (API Powered by Watcharapong Group)<br>";
		$inbound_peek_html = $inbound_peek_html . "Hostname : " . $in_array['tin_hostname']. "<br>";
		$inbound_peek_html = $inbound_peek_html . "MAC Address : " . $in_array['tin_mac']. "<br>";
		$inbound_peek_html = $inbound_peek_html . "FITM E-Mail : " . $in_array['tin_email']. "<br>";
		$inbound_peek_html = $inbound_peek_html . "Name : " . $in_array['tin_name']. "<br>";
		//echo "Tin Name: " . $in_array['tin_cid'];
	}
	$inbound_peek_html = $inbound_peek_html . "<br>";

}


$outbound_peek_html = "";

$outbound_peek_html = $outbound_peek_html . "<h5>Outbound Traffic Peek Report (ASDM Source)</h5><hr>";
$out_result = mysql_query($out_query_text);
while($out_array = mysql_fetch_array($out_result))
{
	$tmpOcet = $out_array['tout_totalusage'];
	$tmpUnit = UnitConvertVar($tmpOcet);
	$outbound_peek_html = $outbound_peek_html . "<strong><u>At Time ".$out_array['dt_etime'] . "</u><br></strong>";
	$outbound_peek_html = $outbound_peek_html . "IP Address : " . $out_array['tout_ip'] . "<br>";
	$outbound_peek_html = $outbound_peek_html . "Usage (1 Hour) :  "  . $tmpOcet . " " . $tmpUnit . "<br>";
	if($out_array['tout_mode'] == 0)
	{
		$outbound_peek_html = $outbound_peek_html . "Access Line : Unknow<br>";
		$outbound_peek_html = $outbound_peek_html . "Whois : " . $out_array['tout_hostname'] . "<br>";
	}
	else if($out_array['tout_mode'] == 1)
	{
		$outbound_peek_html = $outbound_peek_html . "Access Line : Wired Network (API Powered by DHCP Group)<br>";
		$outbound_peek_html = $outbound_peek_html . "Hostname : " . $out_array['tout_hostname'] . "<br>";
		$outbound_peek_html = $outbound_peek_html . "MAC Address : " . $out_array['tout_mac']. "<br>";
		$outbound_peek_html = $outbound_peek_html . "Computer ID : " . $out_array['tout_cid']. "<br>";
		$outbound_peek_html = $outbound_peek_html . "Name : " . $out_array['tout_name']. "<br>";
		$outbound_peek_html = $outbound_peek_html . "Room : " . $out_array['tout_room']. "<br>";
		//echo "Tin Name: " . $in_array['tin_cid'];
	}
	else if($out_array['tout_mode'] == 2)
	{
		$outbound_peek_html = $outbound_peek_html . "Access Line : Wi-Fi Network (API Powered by Watcharapong Group)<br>";
		$outbound_peek_html = $outbound_peek_html . "Hostname : " . $out_array['tout_hostname']. "<br>";
		$outbound_peek_html = $outbound_peek_html . "MAC Address : " . $out_array['tout_mac']. "<br>";
		$outbound_peek_html = $outbound_peek_html . "FITM E-Mail : " . $out_array['tout_email']. "<br>";
		$outbound_peek_html = $outbound_peek_html . "Name : " . $out_array['tout_name']. "<br>";
		//echo "Tin Name: " . $in_array['tin_cid'];
	}
	$outbound_peek_html = $outbound_peek_html . "<br>";

}









require_once "class/class.phpmailer.php";

$mail = new PHPMailer();
$mail->CharSet = "utf-8";
$mail->IsHTML(true); 
$mail->IsSMTP();
$mail->SMTPAuth = true; 
$mail->Host = 'ssl://smtp.gmail.com:465'; 
$mail->Username = "speedxpz@gmail.com"; 
$mail->Password = "SyncSpz51243"; 
$mail->From = "speedxpz@gmail.com"; 
$mail->FromName = "FITMMONv2"; 
$mail->Subject = "FITMMON : Network Daily Report of " . $var_StartYear ."/" .$var_StartMonth."/".$var_StartDay;
$mail->Body = '
<html>
<head><link href="http://202.44.47.47/fitmmon/v3/webui/css/bootstrap.css" rel="stylesheet"></head>
<body style="padding: 20px;">

<img src="http://202.44.47.47/fitmmon/v3/webui/apiv2/mail/logo200.png"><br>
    <h4>Daily report of ' . $var_StartYear .'/' .$var_StartMonth.'/'.$var_StartDay .'</h4>
<hr>

    <h5>Firewall Interface Traffic</h5>
<br>
<img src="http://202.44.47.47/fitmmon/v3/webui/apiv2/graph/graph_line.php?startYear='.$var_StartYear.'&startMonth='.$var_StartMonth.'&startDay='.$var_StartDay.'"></img>
<br>
	<h5>Total Traffic Zone Ratio</h5>
<hr>
<br>
<img src="http://202.44.47.47/fitmmon/v3/webui/apiv2/graph/graph_pie.php?startYear='.$var_StartYear.'&startMonth='.$var_StartMonth.'&startDay='.$var_StartDay.'"></img>

<br>
	<h5>Daily System Event.</h5>
<hr>
' . $html . ' 
<br>
' . $inbound_peek_html . '
<br>
' . $outbound_peek_html. '


<br><br><br>
FITMMONv2

</body>
'; 







/*$recipients = array(
   'admin@4th.in.th' => 'EKAPOL',
   'speedxp@4th.in.th' => 'EKAPOL',
   'e22pla@4th.in.th' => 'EKAPOL'
   // .. 
);
foreach($recipients as $email => $name)
{
   $mail->AddCC($email, $name);
}*/

$select_user_text = "select * from user";
$result_select_user = mysql_query($select_user_text);
while($array_result_select_user = mysql_fetch_array($result_select_user))
{
	if($array_result_select_user['setting_email'] == 1)
	{
		$mail->AddCC($array_result_select_user['email'], "NET ADMIN");
	}
	//echo $array_result_select_user['email'];
}


$mail->Send(); 
echo $mail->Body;


	$select_token_text = "select value from system_settings where variable='fb_accesstoken'";
	$token_result = mysql_query($select_token_text);
	$token_array = mysql_fetch_array($token_result);

	$temp = curl_init();
	curl_setopt($temp, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($temp, CURLOPT_SSL_VERIFYHOST,  2);
	curl_setopt($temp, CURLOPT_URL, 'https://graph.facebook.com/oauth/access_token?grant_type=fb_exchange_token&client_id=582341538516887&client_secret=b1788911352f5e5274af5eac1395b686&fb_exchange_token=' . $token_array['value']);
	curl_setopt($temp, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($temp, CURLOPT_HEADER, 0);
	curl_setopt($temp, CURLOPT_BINARYTRANSFER, 1);
	curl_setopt($temp, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($temp);
	curl_close($temp);
	
	$new_token = explode("access_token=",$result);
	mysql_query("update system_settings set value='".$new_token[1]."' where variable='fb_accesstoken'");
	//echo $new_token[1];
	//$temp_array = (array)json_decode($result);
	//print_r($temp_array);


	$ch = curl_init();

?>  <!-- end of php tag-->
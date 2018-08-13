<?php
include("../../db.inc.php");
include("../../function.api.inc.php");
if(!isset($_GET['di_ifid']) || !isset($_GET['de_id']))
{
	$di_ifid = 3;
	$de_id = 7;
}
else
{
	$di_ifid = $_GET['di_ifid'];
	$de_id = $_GET['de_id'];
}



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

if(!isset($_GET['startYear']) || !isset($_GET['startMonth']) || !isset($_GET['startDay']))
{
	$var_StartYear = $var_start_datetime->format("Y");
	$var_StartMonth = $var_start_datetime->format("m");
	$var_StartDay = $var_start_datetime->format("d");
}
else
{
	$var_StartYear = $_GET['startYear'];
	$var_StartMonth = $_GET['startMonth'];
	$var_StartDay = $_GET['startDay'];
}

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
				/*echo "OUT_" . $array_label[$i-1] . " - ";
				echo $array_out_ocet[$i-1] . "<br>";*/
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

/*".date('Y-m-d H:i:s',$date_start). " ". 

$select_device_join_text = "select * from device_time join device_iftraffic on device_time.dt_id = device_iftraffic.dt_id where dt_etime >= '".date('Y-m-d',$date_start)." " . "' and dt_etime <= '". date('Y-m-d H:i:s',$date_end) ."' and de_id=".$de_id." and di_ifid=" . $di_ifid."";*/



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


$out_query_text = "select * from device_time join device_topip_outbound on device_time.dt_id = device_topip_outbound.dt_id where tin_rank=0 and dt_etime = '";

for($i=0;$i<count($outTime);$i++)
{
	if($i == 0)
	{
		$out_query_text = $out_query_text . date('Y-m-d',$date_start). " " . $inTime[$i] ."'";
	}
	else
	{
		$out_query_text = $out_query_text ." OR tin_rank=0 and dt_etime = '". date('Y-m-d',$date_start). " " . $outTime[$i] ."'";
	}
}

echo "<h2>Inbound Traffic Peek Report</h2><br><hr>";
$in_result = mysql_query($in_query_text);
while($in_array = mysql_fetch_array($in_result))
{
	$tmpOcet = $in_array['tin_totalusage'];
	$tmpUnit = UnitConvertVar($tmpOcet);
	echo "<strong>At Time ".$in_array['dt_etime'] . "<br><br></strong>";
	echo "IP Address : " . $in_array['tin_ip'] . "<br>";
	echo "Usage (1 Hour) :  "  . $tmpOcet . " " . $tmpUnit . "<br>";
	if($in_array['tin_mode'] == 0)
	{
		echo "Connect Mode : Unknow<br>";
	}
	else if($in_array['tin_mode'] == 1)
	{
		echo "Connect Mode : Wired Network (API Powered by DHCP Group)<br>";
		echo "Hostname : " . $in_array['tin_hostname'] . "<br>";
		echo "MAC Address : " . $in_array['tin_mac']. "<br>";
		echo "Computer ID : " . $in_array['tin_cid']. "<br>";
		echo "Room : " . $in_array['tin_room']. "<br>";
		//echo "Tin Name: " . $in_array['tin_cid'];
	}
	else if($in_array['tin_mode'] == 2)
	{
		echo "Connect Mode : Wi-Fi Network (API Powered by Watcharapong Group)<br>";
		echo "Hostname : " . $in_array['tin_hostname']. "<br>";
		echo "MAC Address : " . $in_array['tin_mac']. "<br>";
		echo "FITM E-Mail : " . $in_array['tin_email']. "<br>";
		//echo "Tin Name: " . $in_array['tin_cid'];
	}
	echo "<br><br>";

}


//echo "<br><br><br>" . number_format(array_sum($array_in_ocet)/count($array_in_ocet),2);

/*$var_scale_text =  UnitConvert($array_out_ocet,$array_in_ocet);

$unit_in = UnitConvertVar($total_in);

$unit_out = UnitConvertVar($total_out);


$arraydev['df_label'] = $array_label;
$arraydev['df_avgout'] = $array_out_ocet;
$arraydev['df_avgin'] = $array_in_ocet;
$arraydev['df_avgoutunit'] = $var_scale_text;

$arraydev['in_min'] = number_format(min($array_in_ocet),2);
$arraydev['in_max'] = number_format(max($array_in_ocet),2);
$arraydev['in_avg'] = number_format(array_sum($array_in_ocet)/count($array_in_ocet),2);
$arraydev['in_cur'] = number_format($array_in_ocet[count($array_in_ocet)-1],2);

$arraydev['out_min'] = number_format(min($array_out_ocet),2);
$arraydev['out_max'] = number_format(max($array_out_ocet),2);
$arraydev['out_avg'] = number_format(array_sum($array_out_ocet)/count($array_out_ocet),2);
$arraydev['out_cur'] = number_format($array_out_ocet[count($array_out_ocet)-1],2);
		
$arraydev['start_time'] = date('Y-m-d H:i:s',$date_start);
$arraydev['end_time'] = date('Y-m-d H:i:s',$date_end);

$json_buffer = '{"code":200,"data":' . json_encode($arraydev) . '}';*/


//Record 0
/*$array_device_join = mysql_fetch_array($result_device_join);
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
		$array_label[$array_count] = "";
		$array_in_ocet[$array_count] = round(($array_device_join['df_avgin']/5)/60);
		$array_out_ocet[$array_count] = round(($array_device_join['df_avgout']/5)/60);
		$total_in=$total_in + round($array_device_join['df_totalin']);
		$total_out=$total_out + round($array_device_join['df_totalout']);
	}
	$array_count = $array_count+1;
	
}*/





/*$select_device_interface_text = "select * from device_interface where de_id=".$de_id." and di_ifid=".$di_ifid."";
$result_device_interface = mysql_query($select_device_interface_text);
if(!mysql_num_rows($result_device_interface))
{
	$arraydev['di_ifname'] = "Interface";
			
}
else
{
	$array_device_interface = mysql_fetch_array($result_device_interface);
	$arraydev['di_ifname'] = $array_device_interface['di_ifname'];

}

$var_scale_text =  UnitConvert($array_out_ocet,$array_in_ocet);

$unit_in = UnitConvertVar($total_in);

$unit_out = UnitConvertVar($total_out);


$arraydev['df_label'] = $array_label;
$arraydev['df_avgout'] = $array_out_ocet;
$arraydev['df_avgin'] = $array_in_ocet;
$arraydev['df_avgoutunit'] = $var_scale_text;

$arraydev['in_min'] = number_format(min($array_in_ocet),2);
$arraydev['in_max'] = number_format(max($array_in_ocet),2);
$arraydev['in_avg'] = number_format(array_sum($array_in_ocet)/count($array_in_ocet),2);
$arraydev['in_cur'] = number_format($array_in_ocet[count($array_in_ocet)-1],2);

$arraydev['out_min'] = number_format(min($array_out_ocet),2);
$arraydev['out_max'] = number_format(max($array_out_ocet),2);
$arraydev['out_avg'] = number_format(array_sum($array_out_ocet)/count($array_out_ocet),2);
$arraydev['out_cur'] = number_format($array_out_ocet[count($array_out_ocet)-1],2);
		
$arraydev['start_time'] = date('Y-m-d H:i:s',$date_start);
$arraydev['end_time'] = date('Y-m-d H:i:s',$date_end);

$json_buffer = '{"code":200,"data":' . json_encode($arraydev) . '}';
echo $json_buffer;*/







?>
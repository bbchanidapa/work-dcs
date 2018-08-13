<?php

include("../../db.inc.php");
include("../../function.api.inc.php");


date_default_timezone_set('Asia/Bangkok');
$var_start_datetime = new DateTime(date("Y-m-d H:i:s", time()));

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



$date_start = strtotime($var_StartYear."-".$var_StartMonth."-".$var_StartDay." 00:00");
$date_end = $date_start + 86400;


$select_device_info_text = "select * from device";
$result_device_info = mysql_query($select_device_info_text);

$array_count = 0;

$total_traff[0]=0;

while($array_device_info = mysql_fetch_array($result_device_info))
{
	$de_id = $array_device_info['de_id'];
	if($de_id != 1 && $de_id != 7)
	{
		$select_device_traffic_text = "select * from (select device_iftraffic.*,device_time.dt_etime from device_iftraffic  join device_time on device_iftraffic.dt_id = device_time.dt_id where device_iftraffic.de_id=" . $de_id ." and device_iftraffic.di_ifid=".$array_device_info['de_uplink_ifindex']." and dt_etime >= '".date('Y-m-d H:i:s',$date_start)."' and dt_etime <= '". date('Y-m-d H:i:s',$date_end) ."') as test order by dt_id asc";
		
		$result_device_traffic = mysql_query($select_device_traffic_text);
		$total_traff[$array_count] = 0;
		while ($array_device_traffic = mysql_fetch_array($result_device_traffic))
		{

			$array_label_pie[$array_count] = $array_device_info['de_hostname'];
			$total_traff[$array_count] = $total_traff[$array_count] + round($array_device_traffic['df_totalin']) + round($array_device_traffic['df_totalout']);
		}
		//$array_traffic[$array_count] = round(($array_device_traffic['df_avgout']/5)/60) 
		//round(($array_device_traffic['df_avgin']/5)/60);

					
					
		$array_count = $array_count + 1;
	}


}
$chartscale = UnitConvertOneNoSec($total_traff);
$total_traff[0] = $total_traff[0] - $total_traff[1]; // FIX 124 to 101C Uplink


require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_pie.php');

// Some data
$data = $total_traff;

// Create the Pie Graph. 
$graph = new PieGraph(500,400);
$graph->SetShadow();


// Set A title for the plot
$graph->title->Set("Traffic Zone Ratio");
$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->subtitle->Set(date('Y/m/d',$date_start));
// Create
$p1 = new PiePlot($data);
$p1->SetLegends($array_label_pie);
$p1->value->SetFormat("%d " . $chartscale);
$p1->SetLabelType(1);
$graph->Add($p1);
$graph->Stroke();


?>
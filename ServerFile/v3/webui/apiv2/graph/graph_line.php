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
		$array_label[$array_count] = "";
		$array_in_ocet[$array_count] = round(($array_device_join['df_avgin']/5)/60);
		$array_out_ocet[$array_count] = round(($array_device_join['df_avgout']/5)/60);
		$total_in=$total_in + round($array_device_join['df_totalin']);
		$total_out=$total_out + round($array_device_join['df_totalout']);
	}
	$array_count = $array_count+1;
	
}





$select_device_interface_text = "select * from device_interface where de_id=".$de_id." and di_ifid=".$di_ifid."";
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
//echo $json_buffer;



require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');

$datay1 = $array_in_ocet;
$datay2 = $array_out_ocet;
//$datay3 = array(5,17,32,24);

// Setup the graph
$graph = new Graph(500,400);
$graph->SetScale("textlin");

$theme_class=new UniversalTheme;

$graph->SetTheme($theme_class);
$graph->img->SetAntiAliasing(false);
$graph->title->Set("Traffic of Interface : " . $arraydev['di_ifname']);
$graph->subtitle->Set(date('Y/m/d',$date_start));
$graph->xaxis->title->Set("Time");
$graph->yaxis->title->Set("Unit (".$arraydev['df_avgoutunit'].")");
/*$graph->footer->left->Set('Traffic Infomation ');
$graph->footer->left->SetFont(FF_COURIER,FS_ITALIC);*/
$graph->SetMargin(25,25,25,0);

$outTotalTxtLabel =new Text("Total Traffic : "); 
$outTotalTxtLabel->SetPos(90,325);
$outTotalTxtLabel->SetColor( "black"); 

$outTotalTxt =new Text($total_in . " " . $unit_out); 
$outTotalTxt->SetPos(170,325);
$outTotalTxt->SetColor( "black");

$inTotalTxt =new Text($total_out . " " . $unit_out); 
$inTotalTxt->SetPos(260,325);
$inTotalTxt->SetColor( "black"); 

$graph->AddText($inTotalTxt);
$graph->AddText($outTotalTxt);
$graph->AddText($outTotalTxtLabel);

$outLabTxT =new Text("Outbound : "); 
$outLabTxT->SetPos(35,365);
$outLabTxT->SetColor( "black"); 

$outMinTxT =new Text("Min : ".$arraydev['out_min']." ".$arraydev['df_avgoutunit'].""); 
$outMinTxT->SetPos(105,365);
$outMinTxT->SetColor( "black"); 

$outAvgTxT =new Text("Avg : ".$arraydev['out_avg']." ".$arraydev['df_avgoutunit'].""); 
$outAvgTxT->SetPos(235,365);
$outAvgTxT->SetColor( "black"); 

$outMaxTxT =new Text("Max : ".$arraydev['out_max']." ".$arraydev['df_avgoutunit'].""); 
$outMaxTxT->SetPos(355,365);
$outMaxTxT->SetColor( "black"); 


$inLabTxT =new Text("Inbound : "); 
$inLabTxT->SetPos(35,380);
$inLabTxT->SetColor( "black"); 

$inMinTxT =new Text("Min : ".$arraydev['in_min']." ".$arraydev['df_avgoutunit'].""); 
$inMinTxT->SetPos(105,380);
$inMinTxT->SetColor( "black"); 

$inAvgTxT =new Text("Avg : ".$arraydev['in_avg']." ".$arraydev['df_avgoutunit']."");
$inAvgTxT->SetPos(235,380);
$inAvgTxT->SetColor( "black"); 

$inMaxTxT =new Text("Max : ".$arraydev['in_max']." ".$arraydev['df_avgoutunit']."");
$inMaxTxT->SetPos(355,380);
$inMaxTxT->SetColor( "black"); 


$graph->AddText($outLabTxT);
$graph->AddText($outMinTxT);
$graph->AddText($outAvgTxT);
$graph->AddText($outMaxTxT);

$graph->AddText($inLabTxT);
$graph->AddText($inMinTxT);
$graph->AddText($inAvgTxT);
$graph->AddText($inMaxTxT);

$graph->SetBox(true);

$graph->img->SetAntiAliasing();

$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

$graph->xgrid->Show();
$graph->xgrid->SetLineStyle("solid");
$graph->xaxis->SetTickLabels($array_label);
$graph->xgrid->SetColor('#E3E3E3');
/* $graph->SetBackgroundImage("tiger_bkg.png",BGIMG_FILLPLOT); */

// Create the first line
$p1 = new LinePlot($datay1);
$graph->Add($p1);
$p1->SetColor("#B22222");
$p1->SetLegend('Inbound');
$p1->SetFillColor("red");
// Create the second line
$p2 = new LinePlot($datay2);
$graph->Add($p2);
$p2->SetColor("#22b222");
$p2->SetLegend('Outbound');
$p2->SetFillColor("green");

// Create the third line
/*$p3 = new LinePlot($datay3);
$graph->Add($p3);
$p3->SetColor("#FF1493");
$p3->SetLegend('Line 3');*/

$graph->legend->SetFrameWeight(1);

// Output line
$graph->Stroke();



?>
<?php
	include("../db.inc.php");
	include("../function.api.inc.php");
if(!isset($_POST['email']) || !isset($_POST['de_id']) || !isset($_POST['di_ifid']))
{
	$json_buffer = '{
		"code":302,
		"data":""
	}';
	echo $json_buffer;
	exit();
}

$email = $_POST['email'];
$de_id = $_POST['de_id'];
$di_ifid = $_POST['di_ifid'];

$var_parameter_de_id = $de_id;
$var_parameter_ifid = $di_ifid;

$select_user_text = "select * from user where email='".$email."'";
$result_user = mysql_query($select_user_text);
$var_api_start_datetime = "";
$var_api_end_datetime = "";
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

	


	$select_device_info_text = "select * from device where de_id=".$var_parameter_de_id."";
	$result_device_info = mysql_query($select_device_info_text);
	if(!mysql_num_rows($result_device_info))
	{
		$json_buffer = '{"code":"401"}';
		echo $json_buffer;
		exit();
	}

	$dev_array = mysql_fetch_array($result_device_info);

	$select_device_interface_text = "select * from device_interface where de_id=".$var_parameter_de_id." and di_ifid=".$var_parameter_ifid."";
	$result_device_interface = mysql_query($select_device_interface_text);
	if(!mysql_num_rows($result_device_interface))
	{
		$json_buffer = '{"code":"401"}';
		echo $json_buffer;
		exit();
	}

	$if_array = mysql_fetch_array($result_device_interface);

	
	$select_device_time_text = "select * from device_time LIMIT 0,1";
	$result_device_time = mysql_query($select_device_time_text);
	if(!mysql_num_rows($result_device_time))
	{
		$json_buffer = '{"code":"401"}';
		echo $json_buffer;
		exit();
	}

	$array_device_time = mysql_fetch_array($result_device_time);
	$var_start_datetime = new DateTime($array_device_time['dt_stime']);

	$select_device_time_text = "select * from device_time order by dt_id desc LIMIT 0,1";
	$result_device_time = mysql_query($select_device_time_text);
	if(!mysql_num_rows($result_device_time))
	{
		$json_buffer = '{"code":"401"}';
		echo $json_buffer;
		exit();
	}
	$array_device_time = mysql_fetch_array($result_device_time);
	$var_end_datetime = new DateTime($array_device_time['dt_etime']);
			

	if(!isset($_POST['sy']) || !isset($_POST['sm']) || !isset($_POST['sd']) || !isset($_POST['sh']) || !isset($_POST['si'])
			|| !isset($_POST['emode']) )
	{
		$var_form_sy = $var_start_datetime->format("Y");
		$var_form_sm = $var_start_datetime->format("m");
		$var_form_sd = $var_start_datetime->format("d");
		$var_form_sh = $var_start_datetime->format("H");
		$var_form_si = $var_start_datetime->format("i");

		/*$var_form_ey = $var_end_datetime->format("Y");
		$var_form_em = $var_end_datetime->format("m");
		$var_form_ed = $var_end_datetime->format("d");
		$var_form_eh = $var_end_datetime->format("H");
		$var_form_ei = $var_end_datetime->format("i");*/
	}
	else
	{
		$var_form_sy = $_POST['sy'];
		$var_form_sm = $_POST['sm'];
		$var_form_sd = $_POST['sd'];
		$var_form_sh = $_POST['sh'];
		$var_form_si = $_POST['si'];

		$var_form_emode = $_POST['emode'];
		/*$var_form_ey = $_POST['ey'];
		$var_form_em = $_POST['em'];
		$var_form_ed = $_POST['ed'];
		$var_form_eh = $_POST['eh'];
		$var_form_ei = $_POST['ei'];*/
				
	}


	if(!isset($_POST['sy']) || !isset($_POST['sm']) || !isset($_POST['sd']) || !isset($_POST['sh']) || !isset($_POST['si'])
		|| !isset($_POST['emode']) )
		{
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
				$result_time_api = mysql_query("select * from (select * from device_time order by dt_id desc LIMIT 0,7) as test order by dt_id asc");
				if(!mysql_num_rows($result_time_api))
				{

				}
				else
				{
					$var_api_counter = 0;
					while($array_api = mysql_fetch_array($result_time_api))
					{
						if($var_api_counter == 0) $var_api_start_datetime = new DateTime($array_api['dt_etime']);
						$var_api_end_datetime = new DateTime($array_api['dt_etime']);
						$var_api_counter++;
					}
				}
			}
		}
		else
		{
			
			$date_start = strtotime($var_form_sy."-".$var_form_sm."-".$var_form_sd." ".$var_form_sh.":".$var_form_si);

			$range_start_datetime = strtotime($var_start_datetime->format("Y-m-d H:i:s"));
			$range_end_datetime = strtotime($var_end_datetime->format("Y-m-d H:i:s"));

			if($var_form_emode == 0) $date_end = $date_start + 86400;
			else if($var_form_emode == 1) $date_end = $date_start + 604800;
			else if($var_form_emode == 2) $date_end = $date_start + 2419200;


			$var_api_start_datetime = new DateTime(date('Y-m-d H:i',$date_start));
			$var_api_end_datetime = new DateTime(date('Y-m-d H:i',$date_end));
			if($date_start < $range_start_datetime)
			{
				$json_buffer = '{"code":"500"}'; // Please select date between
				echo $json_buffer;
				exit();
			}
			else if($date_start > $range_end_datetime)
			{
					$json_buffer = '{"code":"501"}'; // Please select date between
					echo $json_buffer;
					exit();
			}

			$select_device_join_text = "select * from device_time join device_iftraffic on device_time.dt_id = device_iftraffic.dt_id where dt_etime >= '".date('Y-m-d H:i:s',$date_start)."' and dt_etime <= '". date('Y-m-d H:i:s',$date_end) ."' and de_id=".$var_parameter_de_id." and di_ifid=" . $var_parameter_ifid."";


			$result_device_join = mysql_query($select_device_join_text);
			if(!mysql_num_rows($result_device_join))
			{
				$json_buffer = '{"code":"401"}'; // Please select date between
				echo $json_buffer;
				exit();
			}

			$array_label[0]="";
			$array_in_ocet[0]="";
			$array_out_ocet[0]="";
			
			if($var_form_emode == 0)
			{
				$totalrecord = mysql_num_rows($result_device_join);
				$precision = round($totalrecord/6);
				$precision_count = 0;
				$array_count = 1;

				//Record 0
				$array_device_join = mysql_fetch_array($result_device_join);
				$fetch_date = new DateTime($array_device_join['dt_etime']);
				$array_label[0] = $fetch_date->format("H:i");
				$array_in_ocet[0] = round(($array_device_join['df_avgin']/5)/60);
				$array_out_ocet[0] = round(($array_device_join['df_avgout']/5)/60);
				
				while($array_device_join = mysql_fetch_array($result_device_join))
				{
					$fetch_date = new DateTime($array_device_join['dt_etime']);
					
					if($precision_count == $precision)
					{
						$precision_count = 0;
						$array_label[$array_count] = $fetch_date->format("H:i");
						$array_in_ocet[$array_count] = round(($array_device_join['df_avgin']/5)/60);
						$array_out_ocet[$array_count] = round(($array_device_join['df_avgout']/5)/60);
					}
					else
					{
						$precision_count = $precision_count + 1;
						$array_label[$array_count] = "";
						$array_in_ocet[$array_count] = round(($array_device_join['df_avgin']/5)/60);
						$array_out_ocet[$array_count] = round(($array_device_join['df_avgout']/5)/60);
					}
					$array_count = $array_count+1;
				}
			}
			else if($var_form_emode == 1)
			{
				$totalrecord = mysql_num_rows($result_device_join);
				$precision = round($totalrecord/4);
				$precision_count = 0;
				$array_count = 1;

				//Record 0
				$array_device_join = mysql_fetch_array($result_device_join);
				$fetch_date = new DateTime($array_device_join['dt_etime']);
				$array_label[0] = $fetch_date->format("m-d");
				$array_in_ocet[0] = round(($array_device_join['df_avgin']/5)/60);
				$array_out_ocet[0] = round(($array_device_join['df_avgout']/5)/60);
				
				while($array_device_join = mysql_fetch_array($result_device_join))
				{
					$fetch_date = new DateTime($array_device_join['dt_etime']);
					if($precision_count == $precision)
					{
						$precision_count = 0;
						$array_label[$array_count] = $fetch_date->format("m-d");
						$array_in_ocet[$array_count] = round(($array_device_join['df_avgin']/5)/60);
						$array_out_ocet[$array_count] = round(($array_device_join['df_avgout']/5)/60);
					}
					else
					{
						$precision_count = $precision_count + 1;
						$array_label[$array_count] = "";
						$array_in_ocet[$array_count] = round(($array_device_join['df_avgin']/5)/60);
						$array_out_ocet[$array_count] = round(($array_device_join['df_avgout']/5)/60);
					}
					$array_count = $array_count+1;
				}
			}
			else if($var_form_emode == 2)
			{
				$totalrecord = mysql_num_rows($result_device_join);
				$precision = round($totalrecord/4);
				$precision_count = 0;
				$array_count = 1;

				//Record 0
				$array_device_join = mysql_fetch_array($result_device_join);
				$fetch_date = new DateTime($array_device_join['dt_etime']);
				$array_label[0] = $fetch_date->format("Y-m-d");
				$array_in_ocet[0] = round(($array_device_join['df_avgin']/5)/60);
				$array_out_ocet[0] = round(($array_device_join['df_avgout']/5)/60);
				
				while($array_device_join = mysql_fetch_array($result_device_join))
				{
					$fetch_date = new DateTime($array_device_join['dt_etime']);
					if($precision_count == $precision)
					{
						$precision_count = 0;
						$array_label[$array_count] = $fetch_date->format("Y-m-d");
						$array_in_ocet[$array_count] = round(($array_device_join['df_avgin']/5)/60);
						$array_out_ocet[$array_count] = round(($array_device_join['df_avgout']/5)/60);
					}
					else
					{
						$precision_count = $precision_count + 1;
						$array_label[$array_count] = "";
						$array_in_ocet[$array_count] = round(($array_device_join['df_avgin']/5)/60);
						$array_out_ocet[$array_count] = round(($array_device_join['df_avgout']/5)/60);
					}
					$array_count = $array_count+1;
				}
			}

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
		
		$select_device_time_text = "select * from device_time LIMIT 0,1";
		$result_device_time = mysql_query($select_device_time_text);
		$array_device_time = mysql_fetch_array($result_device_time);
		$var_start_datetime = new DateTime($array_device_time['dt_stime']);


		
		$select_device_time_text = "select * from device_time order by dt_id desc LIMIT 0,1";
		$result_device_time = mysql_query($select_device_time_text);
		$array_device_time = mysql_fetch_array($result_device_time);
		$var_end_datetime = new DateTime($array_device_time['dt_etime']);
		
		

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
		
		$arraydev['start_time'] = $var_api_start_datetime->format("Y-m-d H:i:s");
		$arraydev['end_time'] = $var_api_end_datetime->format("Y-m-d H:i:s");

		$arraydev['data_start'] = $var_start_datetime->format("Y-m-d H:i:s");
		$arraydev['data_end'] = $var_end_datetime->format("Y-m-d H:i:s");

		$json_buffer = '{"code":200,"data":' . json_encode($arraydev) . '}';
		echo $json_buffer;

						

		


?>
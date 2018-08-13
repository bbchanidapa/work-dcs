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



$select_device_info_text = "select * from device where de_id=".$de_id."";
	$result_device_info = mysql_query($select_device_info_text);
	if(!mysql_num_rows($result_device_info))
	{
		$json_buffer = '{"code":"401"}';
		echo $json_buffer;
		exit();
	}

	$dev_array = mysql_fetch_array($result_device_info);

	$select_device_interface_text = "select * from device_interface where de_id=".$de_id." and di_ifid=".$di_ifid."";
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
			

	if(!isset($_GET['sy']) || !isset($_GET['sm']) || !isset($_GET['sd']) || !isset($_GET['sh']) || !isset($_GET['si'])
			|| !isset($_GET['ey']) || !isset($_GET['em'])  || !isset($_GET['ed']) || !isset($_GET['eh']) || !isset($_GET['ei']) )
	{
		$var_form_sy = $var_start_datetime->format("Y");
		$var_form_sm = $var_start_datetime->format("m");
		$var_form_sd = $var_start_datetime->format("d");
		$var_form_sh = $var_start_datetime->format("H");
		$var_form_si = $var_start_datetime->format("i");

		$var_form_ey = $var_end_datetime->format("Y");
		$var_form_em = $var_end_datetime->format("m");
		$var_form_ed = $var_end_datetime->format("d");
		$var_form_eh = $var_end_datetime->format("H");
		$var_form_ei = $var_end_datetime->format("i");
	}
	else
	{
		$var_form_sy = $_GET['sy'];
		$var_form_sm = $_GET['sm'];
		$var_form_sd = $_GET['sd'];
		$var_form_sh = $_GET['sh'];
		$var_form_si = $_GET['si'];

		$var_form_ey = $_GET['ey'];
		$var_form_em = $_GET['em'];
		$var_form_ed = $_GET['ed'];
		$var_form_eh = $_GET['eh'];
		$var_form_ei = $_GET['ei'];
				
	}


	if(!isset($_GET['sy']) || !isset($_GET['sm']) || !isset($_GET['sd']) || !isset($_GET['sh']) || !isset($_GET['si'])
		|| !isset($_GET['ey']) || !isset($_GET['em'])  || !isset($_GET['ed']) || !isset($_GET['eh']) || !isset($_GET['ei']) )
		{
			$array_device_interface = mysql_fetch_array($result_device_interface);
			$select_device_traffic_text = "select * from (select * from device_iftraffic where de_id=" . $de_id ." and di_ifid=".$di_ifid." order by dt_id desc LIMIT 0,5) as test order by dt_id asc";

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
		}
		else
		{
			$date_start = strtotime($var_form_sy."-".$var_form_sm."-".$var_form_sd." ".$var_form_sh.":".$var_form_si);
			$date_end = strtotime($var_form_ey."-".$var_form_em."-".$var_form_ed." ".$var_form_eh.":".$var_form_ei);

			$range_start_datetime = strtotime($var_start_datetime->format("Y-m-d H:i:s"));
			$range_end_datetime = strtotime($var_end_datetime->format("Y-m-d H:i:s"));

			if($date_end < $date_start)
			{
				$json_buffer = '{"code":"500"}'; // Invalid Date Select
				echo $json_buffer;
				exit();
			}
			else if($date_start < $range_start_datetime)
			{
				$json_buffer = '{"code":"501"}'; // Please select date between
				echo $json_buffer;
				exit();
			}
			else if($date_end > $range_end_datetime)
			{
					$json_buffer = '{"code":"501"}'; // Please select date between
					echo $json_buffer;
					exit();
			}

			$select_device_join_text = "select * from device_time join device_iftraffic on device_time.dt_id = device_iftraffic.dt_id where dt_etime >= '".date('Y-m-d H:i:s',$date_start)."' and dt_etime <= '". date('Y-m-d H:i:s',$date_end) ."' and de_id=".$de_id." and di_ifid=" . $di_ifid."";
							
			$result_device_join = mysql_query($select_device_join_text);
			if(!mysql_num_rows($result_device_join))
			{
				$json_buffer = '{"code":"401"}'; // Please select date between
				echo $json_buffer;
				exit();
			}

			if(($date_end-$date_start) > (29030400*2))
			{
				$var_array_count = 0;
				$var_current_year = 0;
				$array_device_join = mysql_fetch_array($result_device_join);
				$array_label[$var_array_count] = $array_device_join['dt_etime'];
				$array_in_ocet[$var_array_count] = round(($array_device_join['df_avgin']/5)/60);
				$array_out_ocet[$var_array_count] = round(($array_device_join['df_avgout']/5)/60);
				$fetch_date = new DateTime($array_device_join['dt_etime']);
				$var_current_year = $fetch_date->format("Y");

				while($array_device_join = mysql_fetch_array($result_device_join))
				{
					$fetch_date = new DateTime($array_device_join['dt_etime']);

					if($var_current_year != $fetch_date->format("Y"))
					{
						$arrayslot = $arrayslot +1;
						$var_array_count = 0;
						$array_label[$var_array_count] = $fetch_date->format("Y");
						$array_in_ocet[$var_array_count] = round(($array_device_join['df_avgin']/5)/60);
						$array_out_ocet[$var_array_count] = round(($array_device_join['df_avgout']/5)/60);
					}
					else
					{
						$array_in_ocet[$var_array_count] = round(($array_in_ocet[$var_array_count] + (($array_device_join['df_avgin']/5)/60))/2);

						$array_out_ocet[$var_array_count] = round(($array_in_ocet[$var_array_count]+(($array_device_join['df_avgout']/5)/60))/2);


					}
					$var_current_year = $fetch_date->format("Y");
				}
			}
			else if(($date_end-$date_start) > (2419200*2)) //Month*2
			{
				if(($date_end-$date_start) > (2419200*10)) $var_max_count = 2;
				else if(($date_end-$date_start) > (2419200*20)) $var_max_count = 3;		
				else $var_max_count = 1;

				$var_array_count = 0;
				$var_array_count = 0;
				$array_device_join = mysql_fetch_array($result_device_join);
				$fetch_date = new DateTime($result_device_join['dt_etime']);
				$temp_array_label[$var_array_count] = $fetch_date->format("Y-m");
				$temp_array_in_ocet[$var_array_count] = round(($array_device_join['df_avgin']/5)/60);
				$temp_array_out_ocet[$var_array_count] = round(($array_device_join['df_avgout']/5)/60);
				$var_current_month = $fetch_date->format("m");

				while($array_device_join = mysql_fetch_array($result_device_join))
				{
					$fetch_date = new DateTime($result_device_join['dt_etime']);

					if($var_current_month != $fetch_date->format("m"))
					{
						$var_array_count = $var_array_count + 1;
						$temp_array_label[$var_array_count] = $fetch_date->format("Y-m");
						$temp_array_in_ocet[$var_array_count] = round(($array_device_join['df_avgin']/5)/60);
						$temp_array_out_ocet[$var_array_count] = round(($array_device_join['df_avgout']/5)/60);
					}
					else
					{
						$temp_array_in_ocet[$var_array_count] = round(($temp_array_in_ocet[$var_array_count] + (($array_device_join['df_avgin']/5)/60))/2);
						$temp_array_out_ocet[$var_array_count] = round(($temp_array_out_ocet[$var_array_count]+(($array_device_join['df_avgout']/5)/60))/2);
					}
					$var_current_month = $fetch_date->format("m");
				}
				$var_number_counter = 0;
				$var_array_count = 0;
				$array_label[$var_array_count] = $temp_array_label[0];
				$array_in_ocet[$var_array_count] = $temp_array_in_ocet[0];
				$array_out_ocet[$var_array_count] = $temp_array_out_ocet[0];

				$var_number_counter = 1;
				for($i=1;$i<count($temp_array_label);$i++)
				{
					if($var_number_counter == $var_max_count)
					{
						$var_array_count = $var_array_count + 1;
						$array_label[$var_array_count] = $temp_array_label[$i];
						$array_in_ocet[$var_array_count] = $temp_array_in_ocet[$i];
						$array_out_ocet[$var_array_count] = $temp_array_out_ocet[$i];
						$var_number_counter = 0;
					}
					else
					{
						$array_in_ocet[$var_array_count] = round(($array_in_ocet[$var_array_count] + $temp_array_in_ocet[$i])/2);
						$array_out_ocet[$var_array_count] = round(($array_out_ocet[$var_array_count] + $temp_array_out_ocet[$i])/2);
						$var_number_counter = $var_number_counter + 1;
					}
				}
			}
			else if(($date_end-$date_start) > (86400*2)) //Day*2
			{
				if(($date_end-$date_start) > (86400*10)) $var_max_count = 2;
				else if(($date_end-$date_start) > (86400*20)) $var_max_count = 3;		
				else if(($date_end-$date_start) > (86400*30)) $var_max_count = 4;
				else if(($date_end-$date_start) > (86400*40)) $var_max_count = 5;
				else if(($date_end-$date_start) > (86400*50)) $var_max_count = 6;
				else $var_max_count = 1;

				$var_array_count = 0;
				$var_current_day = 0;
				$array_device_join = mysql_fetch_array($result_device_join);
				$fetch_date = new DateTime($array_device_join['dt_etime']);
				$temp_array_label[$var_array_count] = $fetch_date->format("Y-m-d");
				$temp_array_in_ocet[$var_array_count] = round(($array_device_join['df_avgin']/5)/60);
				$temp_array_out_ocet[$var_array_count] = round(($array_device_join['df_avgout']/5)/60);
				$var_current_day = $fetch_date->format("d");
				while($array_device_join = mysql_fetch_array($result_device_join))
				{
					$fetch_date = new DateTime($array_device_join['dt_etime']);

					if($var_current_day != $fetch_date->format("d"))
					{
						$var_array_count = $var_array_count +1;
						$temp_array_label[$var_array_count] = $fetch_date->format("Y-m-d");
						$temp_array_in_ocet[$var_array_count] = round(($array_device_join['df_avgin']/5)/60);
						$temp_array_out_ocet[$var_array_count] = round(($array_device_join['df_avgout']/5)/60);
					}
					else
					{
						$temp_array_in_ocet[$var_array_count] = round(($temp_array_in_ocet[$var_array_count] + (($array_device_join['df_avgin']/5)/60))/2);
						$temp_array_out_ocet[$var_array_count] = round(($temp_array_out_ocet[$var_array_count]+(($array_device_join['df_avgout']/5)/60))/2);

					}
					$var_current_day = $fetch_date->format("d");
				}

				$var_number_counter = 0;
				$var_array_count = 0;
				$array_label[$var_array_count] = $temp_array_label[0];
				$array_in_ocet[$var_array_count] = $temp_array_in_ocet[0];
				$array_out_ocet[$var_array_count] = $temp_array_out_ocet[0];
				$var_number_counter = 1;
				for($i=1;$i<count($temp_array_label);$i++)
				{
					if($var_number_counter == $var_max_count)
					{
						$var_array_count = $var_array_count + 1;
						$array_label[$var_array_count] = $temp_array_label[$i];
						$array_in_ocet[$var_array_count] = $temp_array_in_ocet[$i];
						$array_out_ocet[$var_array_count] = $temp_array_out_ocet[$i];
						$var_number_counter = 1;
					}
					else
					{
						$array_in_ocet[$var_array_count] = round(($array_in_ocet[$var_array_count] + $temp_array_in_ocet[$i])/2);
						$array_out_ocet[$var_array_count] = round(($array_out_ocet[$var_array_count] + $temp_array_out_ocet[$i])/2);
						$var_number_counter = $var_number_counter + 1;
					}
				}
			}
			else if(($date_end-$date_start) > (3600*5)) //Hour*5
			{
				if(($date_end-$date_start) > (3600*10)) $var_max_count = 2;
				else if(($date_end-$date_start) > (3600*20)) $var_max_count = 3;		
				else if(($date_end-$date_start) > (3600*30)) $var_max_count = 4;
				else if(($date_end-$date_start) > (3600*40)) $var_max_count = 5;
				else $var_max_count = 1;

				$var_array_count = 0;
				$var_current_hour = 0;
				$array_device_join = mysql_fetch_array($result_device_join);
				$fetch_date = new DateTime($array_device_join['dt_etime']);
				$temp_array_label[$var_array_count] = $fetch_date->format("m-d H:i");
				$temp_array_in_ocet[$var_array_count] = round(($array_device_join['df_avgin']/5)/60);
				$temp_array_out_ocet[$var_array_count] = round(($array_device_join['df_avgout']/5)/60);
				$var_current_hour = $fetch_date->format("H");

				while($array_device_join = mysql_fetch_array($result_device_join))
				{
					$fetch_date = new DateTime($array_device_join['dt_etime']);

					if($var_current_hour != $fetch_date->format("H"))
					{
						$var_array_count = $var_array_count + 1;
						$temp_array_label[$var_array_count] = $fetch_date->format("m-d H:i");
						$temp_array_in_ocet[$var_array_count] = round(($array_device_join['df_avgin']/5)/60);
						$temp_array_out_ocet[$var_array_count] = round(($array_device_join['df_avgout']/5)/60);
					}
					else
					{
						$temp_array_in_ocet[$var_array_count] = round(($temp_array_in_ocet[$var_array_count] + (($array_device_join['df_avgin']/5)/60))/2);
						$temp_array_out_ocet[$var_array_count] = round(($temp_array_out_ocet[$var_array_count]+(($array_device_join['df_avgout']/5)/60))/2);
					}
					$var_current_hour = $fetch_date->format("H");
				}

				$var_number_counter = 0;
				$var_array_count = 0;
				$array_label[$var_array_count] = $temp_array_label[0];
				$array_in_ocet[$var_array_count] = $temp_array_in_ocet[0];
				$array_out_ocet[$var_array_count] = $temp_array_out_ocet[0];

				$var_number_counter = 1;
				for($i=1;$i<count($temp_array_label);$i++)
				{
					if($var_number_counter == $var_max_count)
					{
						$var_array_count = $var_array_count + 1;
						$array_label[$var_array_count] = $temp_array_label[$i];
						$array_in_ocet[$var_array_count] = $temp_array_in_ocet[$i];
						$array_out_ocet[$var_array_count] = $temp_array_out_ocet[$i];
						$var_number_counter = 1;
					}
					else
					{
						$array_in_ocet[$var_array_count] = round(($array_in_ocet[$var_array_count] + $temp_array_in_ocet[$i])/2);
						$array_out_ocet[$var_array_count] = round(($array_out_ocet[$var_array_count] + $temp_array_out_ocet[$i])/2);
						$var_number_counter = $var_number_counter + 1;
					}
				}
			}
			else
			{
				$var_array_count = 0;
						
				while($array_device_join = mysql_fetch_array($result_device_join))
				{
					$array_label[$var_array_count] = $array_device_join['dt_etime'];
					$array_in_ocet[$var_array_count] = round(($array_device_join['df_avgin']/5)/60);
					$array_out_ocet[$var_array_count] = round(($array_device_join['df_avgout']/5)/60);
					$var_array_count = $var_array_count + 1;

				}
			}
		}


		
		

		$var_scale_text =  UnitConvert($array_out_ocet,$array_in_ocet);
		

		$arraydev['df_label'] = $array_label;
		$arraydev['df_avgout'] = $array_out_ocet;
		$arraydev['df_avgin'] = $array_in_ocet;
		$arraydev['df_avgoutunit'] = $var_scale_text;

		$arraydev['in_min'] = min($array_in_ocet);
		$arraydev['in_max'] = max($array_in_ocet);
		$arraydev['in_avg'] = number_format(array_sum($array_in_ocet)/count($array_in_ocet),2);

		$arraydev['out_min'] = min($array_out_ocet);
		$arraydev['out_max'] = max($array_out_ocet);
		$arraydev['out_avg'] = number_format(array_sum($array_out_ocet)/count($array_out_ocet),2);


$json_buffer = '{
		"code":200,
		"data":' . json_encode($arraydev) .'
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
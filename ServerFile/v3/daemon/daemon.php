<?php
include("dbi.inc.php");
include("function.api.inc.php");
include_once("facebook.php"); //include facebook SDK


function send_notification($applmsg)
{
$passphrase = '?vv,lbo';
	
$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'E:\\web\\htdocs\\public\\fitmmon\\v3\\daemon\\ck2.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
$fp = stream_socket_client(
	'ssl://gateway.sandbox.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);

echo 'Connected to APNS' . PHP_EOL;

// Create the payload body

$select_device_token = "select * from device_push join user on device_push.uid = user.uid";
$query_result = mysql_query($select_device_token);
if(!mysql_num_rows($query_result))
{
	echo "No Device Registed";
	exit();
}

while($push_device_array = mysql_fetch_array($query_result))
{
	if($push_device_array['setting_notification'] == 1)
	{
		$badge = $push_device_array['pd_badge']+1;
		$body['aps'] = array(
			'alert' => $applmsg,
			'sound' => 'default',
			'badge' => $badge
			);

		// Encode the payload as JSON
		$payload = json_encode($body);

		// Build the binary notification
		$msg = chr(0) . pack('n', 32) . pack('H*', $push_device_array['pd_devicetoken']) . pack('n', strlen($payload)) . $payload;
		// Send it to the server
		$result = fwrite($fp, $msg, strlen($msg));

		$update_push_device = "update push_device set pd_badge=".$badge." where pd_devicetoken='".$push_device_array['pd_devicetoken']."'";
		@mysql_query($update_push_device);
	}
}

/*if (!$result)
	echo 'Message not delivered' . PHP_EOL;
else
	echo 'Message successfully delivered' . PHP_EOL;*/

// Close the connection to the server
fclose($fp);

}

$var_mode_isinsert = 0;
$var_session_timeid = 0;

$select_device_time_text = "select * from device_time order by dt_id DESC LIMIT 0,1";
$result_device_time = mysql_query($select_device_time_text);

if (mysql_num_rows($result_device_time) == 0) // time_id not found
{
	$current_datetime = new DateTime(date("Y-m-d H:i:s", time()));
	if($current_datetime->format("i") >= 30) $current_datetime->setTime ( $current_datetime->format("H"), 30, 0 );
	else $current_datetime->setTime ( $current_datetime->format("H"), 0, 0 );

	$insert_device_time_text = "insert into device_time (dt_stime,dt_etime) 
								VALUES ('" . $current_datetime->format('Y-m-d H:i:s') . "','" . 
								$current_datetime->format('Y-m-d H:i:s') . "')";
	mysql_query($insert_device_time_text);

	$select_device_time_text = "select * from device_time order by dt_id DESC LIMIT 0,1";
	$result_device_time = mysql_query("select * from device_time order by dt_id DESC LIMIT 0,1");
	$array_device_time = mysql_fetch_array($result_device_time);
	$var_session_timeid = $array_device_time['dt_id'];
	$var_mode_isinsert = 1;
}
else
{
	$array_device_time = mysql_fetch_array($result_device_time);
	$var_datetime_device_time = new DateTime(date("Y-m-d H:i:s", strtotime($array_device_time['dt_stime'])));
	$var_time_device_time = strtotime($var_datetime_device_time->format("Y-m-d H:i:s"));
	$var_time_device_time = $var_time_device_time + 1800; // 30 Minute Plus

	$current_datetime = new DateTime(date("Y-m-d H:i:s", time()));
	$current_datetime->setTime ( $current_datetime->format("H"), $current_datetime->format("i"), 0 );
	$current_time = strtotime($current_datetime->format("Y-m-d H:i:s"));

	if($current_time > $var_time_device_time) // Pass Over 30 Minute Create New Record
	{
		if($current_datetime->format("i") >= 30) $current_datetime->setTime ( $current_datetime->format("H"), 30, 0 );
		else $current_datetime->setTime ( $current_datetime->format("H"), 00, 0 );

		$current_datetime2 = new DateTime(date("Y-m-d H:i:s", time()));
		$current_datetime2->setTime ( $current_datetime2->format("H"), $current_datetime2->format("i"), 0 );


		$insert_device_time_text = "insert into device_time (dt_stime,dt_etime) 
									VALUES ('" . $current_datetime->format('Y-m-d H:i:s') . 
										"','" . $current_datetime2->format('Y-m-d H:i:s') . "')";

		mysql_query($insert_device_time_text);

		$select_device_time_text = "select * from device_time order by dt_id DESC LIMIT 0,1";

		$result_device_time = mysql_query($select_device_time_text);
		$array_device_time = mysql_fetch_array($result_device_time);
		$var_session_timeid = $array_device_time['dt_id'];
		$var_mode_isinsert = 1;
	}
	else
	{
		$var_session_timeid = $array_device_time['dt_id'];
		$current_datetime->setTime ( $current_datetime->format("H"), $current_datetime->format("i"), 0 );
		$update_device_time_text = "update device_time set dt_etime='". $current_datetime->format("Y-m-d H:i:s") . 
									"' where dt_id = " . $var_session_timeid . "" ;
		mysql_query($update_device_time_text);
		$var_mode_isinsert = 0;
	}
}


$select_device_text = "select * from device";
$result_device = mysql_query($select_device_text);
while ($array_device = mysql_fetch_array($result_device))
{
	$de_id = $array_device['de_id'];
	echo $de_id."<br><hr><br>";
	//echo $array_device['de_ipaddr'] . "<br>";
	// Check Host Avaliable
	exec("regedit -v -s bin_regedit.reg");
	unset($ping_output); // Clear Output Buffer
	exec("bin_hrping.exe -n 1 -w 2000 " . $array_device['de_ipaddr'],$ping_output);
	
	$array_ping_result = explode("=",explode(",",$ping_output[8])[1]);
	if($array_ping_result[1] == 0)
	{

	}
	else
	{
	
		$var_device_ping = explode(" / ",$ping_output[9])[1];

		$result_snmp_cpu = snmp2_get( $array_device['de_ipaddr'], 'public', '1.3.6.1.4.1.9.9.109.1.1.1.1.5.1');
		$result_explode_cpu = explode( ": ", $result_snmp_cpu );
		$result_cpu = trim($result_explode_cpu[1]);

		$result_snmp_mem = snmp2_get($array_device['de_ipaddr'], 'public', '1.3.6.1.4.1.9.9.48.1.1.1.5.1');
		$result_explode_mem = explode( ": ", $result_snmp_mem );
		$result_mem = trim($result_explode_mem[1]);

		$result_snmp_uptime = snmp2_get($array_device['de_ipaddr'], 'public', '1.3.6.1.2.1.1.3.0');
		$result_explode_uptime = explode( ": ", $result_snmp_uptime );
		$result2_explode_uptime = explode( ")", $result_explode_uptime[1] );
		$result_uptime = trim($result2_explode_uptime[1]);

		if($de_id != 7)
		{
			$result_snmp_temp = snmp2_walk($array_device['de_ipaddr'], 'public', '1.3.6.1.4.1.9.9.13.1.3.1.3');
			$result_explode_temp = explode( ":", $result_snmp_temp[0] );
			$result_temp = trim($result_explode_temp[1]);
		}
		else
		{
			$result_temp = 0;
		}

		$select_device_usage_text = "select * from device_usage where dt_id=".$var_session_timeid." and de_id=".$de_id;
		$result_device_usage = mysql_query($select_device_usage_text);
		

		/*$insert_device_event_text = "insert into device_event 
					(devt_dtime,devt_message,devt_line1,devt_line2,devt_line3,devt_line4,devt_line5) 
					VALUES (NOW(),'[Alert] " . $array_ip[$i] ." use bandwidth over ". $tmpOver ."MB in last 1 hour.','IP : " . $array_ip[$i] ."','Hourly Usage : " . $tmpOcet ." ". $tmpUnit . "','Whois : ". $array_hostname[$i] ."','','');";
					mysql_query($insert_device_event_text);

					send_notification("[Alert] " . $array_hostname[$i] . " (" . $array_ip[$i] .") use bandwidth ". $tmpOcet ." ". $tmpUnit ." in last 1 hour.");*/
	
		if($array_device['de_cpualert'] == 0 && $result_cpu >= 90)
		{
			$insert_device_event_text = "insert into device_event 
					(devt_dtime,devt_message,devt_line1,devt_line2,devt_line3,devt_line4,devt_line5) 
					VALUES (NOW(),'[Alert] " . $array_device['de_hostname'] ." have cpu usage ". $result_cpu ."%','','','','','');";
			mysql_query($insert_device_event_text);

			send_notification("[Alert] " . $array_device['de_hostname'] ." have cpu usage ". $result_cpu ."%");

			mysql_query("update device set de_cpualert = 1 where de_id = ".$de_id);

		}
		else if($result_cpu < 90 && $array_device['de_cpualert'] == 1)
		{
			mysql_query("update device set de_cpualert = 0 where de_id = ".$de_id);
		}
		
		if($var_mode_isinsert == 1 || !mysql_num_rows($result_device_usage))
		{
			$insert_device_usage_text = "insert into device_usage (dt_id,de_id,du_cpu,du_memory,du_uptime,du_temp,du_ping) VALUES (".$var_session_timeid.",".$de_id.",".$result_cpu.",".$result_mem.",'" . $result_uptime . "',".$result_temp.",".$var_device_ping.")";
			mysql_query($insert_device_usage_text);
		}
		else
		{
			
			
			$array_device_usage = mysql_fetch_array($result_device_usage);
			$update_device_usage_text = "update device_usage set 
			du_cpu = ".round(($result_cpu+$array_device_usage['du_cpu'])/2).",
			du_memory=".round(($result_mem+$array_device_usage['du_memory'])/2).",
			du_uptime='".$result_uptime."',
			du_temp=".round(($result_temp+$array_device_usage['du_temp'])/2).",
			du_ping=".(($var_device_ping+$array_device_usage['du_ping'])/2)."
			where dt_id=".$var_session_timeid." and 
			de_id=".$de_id."";

			mysql_query($update_device_usage_text);
		}


		mysql_query("DELETE from device_vlan where de_id=".$de_id);
		mysql_query("DELETE from device_interface where de_id=".$de_id);

			// CREATE VLAN DATA
		if ($de_id != 7)
		{
			$result_snmp_vlanindex = snmpwalk($array_device['de_ipaddr'], 'public', '1.3.6.1.4.1.9.9.46.1.3.1.1.18');
			$result_snmp_vlanname = snmpwalk($array_device['de_ipaddr'], 'public', '1.3.6.1.4.1.9.9.46.1.3.1.1.4');
			
			$tempzero = 0;
			for($i=0;$i<count($result_snmp_vlanindex);$i++)
			{
				$array_snmp_vlanindex = explode(": ",$result_snmp_vlanindex[$i]);
				$array_snmp_vlanname = explode(": ",$result_snmp_vlanname[$i]);


				$var_snmp_vlanindex = trim($array_snmp_vlanindex[1]);
				$var_snmp_vlanname = trim($array_snmp_vlanname[1]);


				$var_snmp_vlanname = str_replace("\"","",$var_snmp_vlanname);
				if($var_snmp_vlanindex != 0)
				{
					if ($tempzero == 0)
					{
						$tempzero = 1;
						$insert_device_vlan_text = "insert into device_vlan (de_id,dv_vlanid,dv_vlanname) VALUES (" . $de_id . "," . $var_snmp_vlanindex . ",'" . $var_snmp_vlanname . "')";
					}
					else
					{
						$insert_device_vlan_text = $insert_device_vlan_text . ",(" . $de_id . "," . $var_snmp_vlanindex . ",'" . $var_snmp_vlanname . "')";
					}
				}
			}
			echo  "<hr><h2>VLAN DEVICE INTERFACE</h2> " .$insert_device_vlan_text . "<br><hr><br>";
			mysql_query($insert_device_vlan_text);
		}


		// CREATE INTERFACE DATA
		

		$result_snmp_ifindex = snmpwalk($array_device['de_ipaddr'], 'public', '1.3.6.1.2.1.2.2.1.1');
		$result_snmp_ifdescr = snmpwalk($array_device['de_ipaddr'], 'public', '1.3.6.1.2.1.2.2.1.2');
		$result_snmp_ifspeed = snmpwalk($array_device['de_ipaddr'], 'public', '1.3.6.1.2.1.2.2.1.5');
		$result_snmp_ifoper = snmpwalk($array_device['de_ipaddr'], 'public', '1.3.6.1.2.1.2.2.1.8');

		$result_snmp_ipaddr = snmpwalk($array_device['de_ipaddr'], 'public', '1.3.6.1.2.1.4.20.1.1');
		$result_snmp_subnet = snmpwalk($array_device['de_ipaddr'], 'public', '1.3.6.1.2.1.4.20.1.3');
		
		$result_snmp_ipifindex = snmpwalk($array_device['de_ipaddr'], 'public', '1.3.6.1.2.1.4.20.1.2');
		
		$tempfirst = 0;
		for($i=0;$i<count($result_snmp_ifindex);$i++)
		{

			
			
			$temp_result_snmp_ipaddr = "";
			$temp_result_snmp_subnet = "";


			for($j=0;$j<count($result_snmp_ipaddr);$j++)
			{
				//echo $result_snmp_ifindex[$i] . " == ". $result_snmp_ipifindex[$j];
				if($result_snmp_ifindex[$i] == $result_snmp_ipifindex[$j])
				{
					$temp_result_snmp_ipaddr = $result_snmp_ipaddr[$j];
					$temp_result_snmp_subnet = $result_snmp_subnet[$j];
				}

			}
			

			$array_snmp_ifindex = explode(": ",$result_snmp_ifindex[$i]);
			$array_snmp_ifdescr = explode(": ",$result_snmp_ifdescr[$i]);
			$array_snmp_ifspeed = explode(": ",$result_snmp_ifspeed[$i]);
			$array_snmp_ifoper = explode(": ",$result_snmp_ifoper[$i]);
			$array_snmp_ipaddr = explode(": ",$temp_result_snmp_ipaddr);
			$array_snmp_subnet = explode(": ",$temp_result_snmp_subnet);
			
			
			count($array_snmp_ifindex)>=2?$var_snmp_ifindex = trim($array_snmp_ifindex[1]):$var_snmp_ifindex="";
			count($array_snmp_ifdescr)>=2?$var_snmp_ifdescr = trim($array_snmp_ifdescr[1]):$var_snmp_ifdescr="";
			count($array_snmp_ifspeed)>=2?$var_snmp_ifspeed = trim($array_snmp_ifspeed[1]):$var_snmp_ifspeed="";
			count($array_snmp_ifoper)>=2?$var_snmp_ifoper = trim($array_snmp_ifoper[1]):$var_snmp_ifoper="";
			count($array_snmp_ipaddr)>=2?$var_snmp_ipaddr = trim($array_snmp_ipaddr[1]):$var_snmp_ipaddr="";
			count($array_snmp_subnet)>=2?$var_snmp_subnet = trim($array_snmp_subnet[1]):$var_snmp_subnet="";
			
			
			$var_snmp_ifdescr = str_replace("\"","",$var_snmp_ifdescr);
			$var_snmp_ifdescr = str_replace("'","",$var_snmp_ifdescr);

			if($de_id == 7)
			{
				$var_snmp_ifdescr = str_replace("Adaptive Security Appliance ","",$var_snmp_ifdescr);
				$var_snmp_ifdescr = str_replace(" interface","",$var_snmp_ifdescr);
			}
			


			$result_snmp_vlanid = @snmpwalk($array_device['de_ipaddr'], 'public', '1.3.6.1.4.1.9.9.68.1.2.2.1.2.' . $var_snmp_ifindex);

			$array_snmp_vlanid = @explode(": ",$result_snmp_vlanid[0]);

			count($array_snmp_vlanid)>=2?$var_snmp_vlanid = trim($array_snmp_vlanid[1]):$var_snmp_vlanid="";
			
			if($var_snmp_ifoper == "up(1)") $var_snmp_ifoper = 1;
			else if($var_snmp_ifoper == "down(2)") $var_snmp_ifoper = 2;

			if($var_snmp_vlanid == "")
			{
				if ($tempfirst == 0)
				{
						$insert_device_interface_text = "insert into device_interface (de_id,di_ifid,di_ifname,di_ifspeed,di_ifstatus,di_ipaddr,di_subnet,di_vlanid)
					 VALUES (" . $de_id . "," . $var_snmp_ifindex . ",'" . $var_snmp_ifdescr . "'," . $var_snmp_ifspeed . "," . $var_snmp_ifoper . ",'" . $var_snmp_ipaddr . "','" . $var_snmp_subnet . "',NULL)";
					$tempfirst = 1;
				}
				else
				{

					$insert_device_interface_text = $insert_device_interface_text  . ",(" . $de_id . "," . $var_snmp_ifindex . ",'" . $var_snmp_ifdescr . "'," . $var_snmp_ifspeed . "," . $var_snmp_ifoper . ",'" . $var_snmp_ipaddr . "','" . $var_snmp_subnet . "',NULL)";

				}
			// echo "1-".$insert_device_interface_text . "\n";
			}
			else
			{
				if ($tempfirst == 0)
				{
							$insert_device_interface_text = "insert into device_interface (de_id,di_ifid,di_ifname,di_ifspeed,di_ifstatus,di_ipaddr,di_subnet,di_vlanid)
					 VALUES (" . $de_id . "," . $var_snmp_ifindex . ",'" . $var_snmp_ifdescr . "'," . $var_snmp_ifspeed . "," . $var_snmp_ifoper . ",'" . $var_snmp_ipaddr . "','" . $var_snmp_subnet . "'," . $var_snmp_vlanid . ")";
					 $tempfirst = 1;
				}
				else
				{
					$insert_device_interface_text = $insert_device_interface_text  . ",(" . $de_id . "," . $var_snmp_ifindex . ",'" . $var_snmp_ifdescr . "'," . $var_snmp_ifspeed . "," . $var_snmp_ifoper . ",'" . $var_snmp_ipaddr . "','" . $var_snmp_subnet . "'," . $var_snmp_vlanid . ")";

				}
			
			}
			 
		}
		echo  "<hr><h2>INSERT DEVICE INTERFACE</h2> " .$insert_device_interface_text . "<br><hr><br>";
		$tmpresult = mysql_query($insert_device_interface_text);
		//if($tmpresult) echo "<br>SUCCESS";
		//else echo "<br>FAILED";



		//TRAFFIC CAPTURE
		$result_snmp_ifindex = snmpwalk($array_device['de_ipaddr'], 'public', '1.3.6.1.2.1.2.2.1.1');
		$result_snmp_ifOut = snmpwalk($array_device['de_ipaddr'], 'public', '1.3.6.1.2.1.2.2.1.16');
		$result_snmp_ifIn = snmpwalk($array_device['de_ipaddr'], 'public', '1.3.6.1.2.1.2.2.1.10');
		
		$var_lastin = 0;
		$var_lastout = 0;
		$var_avgin = 0;
		$var_avgout = 0;
		$var_maxcounter = pow(2, (32));
		for($m=0;$m<count($result_snmp_ifOut);$m++)
		{

			/*$array_snmp_ifindex = @explode(": ",$result_snmp_ifindex[$m]);
			$array_snmp_ifOut = @explode(": ",$result_snmp_ifOut[$m]);
			$array_snmp_ifIn = @explode(": ",$result_snmp_ifIn[$m]);*/

			

			/*count($array_snmp_ifindex)>=2?$var_snmp_ifindex = trim($array_snmp_ifindex[1]):$var_snmp_ifindex="";
			count($array_snmp_ifOut)>=2?$var_snmp_ifOut = trim($array_snmp_ifOut[1]):$var_snmp_ifOut="";
			count($array_snmp_ifIn)>=2?$var_snmp_ifIn = trim($array_snmp_ifIn[1]):$var_snmp_ifIn="";*/
		}
	

		$select_device_iftraffic_text = "select * from device_iftraffic where dt_id=".$var_session_timeid." and de_id=".$de_id."";
		$result_device_iftraffic = mysql_query($select_device_iftraffic_text);

		if($var_mode_isinsert == 1 || !mysql_num_rows($result_device_iftraffic))
		{
			$select_device_iftraffic_text = "select * from device_iftraffic where de_id=" . $de_id . " and dt_id=" . ($var_session_timeid-1) . "";
			$result_device_iftraffic = mysql_query($select_device_iftraffic_text);
			if (mysql_num_rows($result_device_iftraffic) == 0)
			{
				// LOOP INSERT BY SNMP
				$tempquery = 0;
				for($m=0;$m<count($result_snmp_ifOut);$m++)
				{
					$array_snmp_ifindex = explode(": ",$result_snmp_ifindex[$m]);
					$array_snmp_ifOut = explode(": ",$result_snmp_ifOut[$m]);
					$array_snmp_ifIn = explode(": ",$result_snmp_ifIn[$m]);

					count($array_snmp_ifindex)>=2?$var_snmp_ifindex = trim($array_snmp_ifindex[1]):$var_snmp_ifindex="";
					count($array_snmp_ifOut)>=2?$var_snmp_ifOut = trim($array_snmp_ifOut[1]):$var_snmp_ifOut="";
					count($array_snmp_ifIn)>=2?$var_snmp_ifIn = trim($array_snmp_ifIn[1]):$var_snmp_ifIn="";

					if($tempquery == 0)
					{
						$insert_device_iftraffic_text = "insert into device_iftraffic (dt_id,de_id,di_ifid,df_lastin,df_lastout,df_avgin,df_avgout,df_totalin,df_totalout) VALUES (".$var_session_timeid.",". $de_id .",".$var_snmp_ifindex.",".$var_snmp_ifIn.",".$var_snmp_ifOut.",0,0,0,0)";
						$tempquery = 1;
					}
					else
					{
						$insert_device_iftraffic_text = $insert_device_iftraffic_text . ",(".$var_session_timeid.",". $de_id .",".$var_snmp_ifindex.",".$var_snmp_ifIn.",".$var_snmp_ifOut.",0,0,0,0)";
					}
				}
				mysql_query($insert_device_iftraffic_text);
				echo  "<hr><h2>INSERT 01 TRAFFIC</h2> " .$insert_device_iftraffic_text . "<br><hr><br>";

			}
			else
			{
				$arr_snmp_ifindex = array();
				$arr_snmp_ifOut = array();
				$arr_snmp_ifIn = array();
				for($m=0;$m<count($result_snmp_ifOut);$m++)
				{
						$array_snmp_ifindex = explode(": ",$result_snmp_ifindex[$m]);
						$array_snmp_ifOut = explode(": ",$result_snmp_ifOut[$m]);
						$array_snmp_ifIn = explode(": ",$result_snmp_ifIn[$m]);

						count($array_snmp_ifindex)>=2?$arr_snmp_ifindex[$m] = trim($array_snmp_ifindex[1]):$arr_snmp_ifindex[$m]="";
						count($array_snmp_ifOut)>=2?$arr_snmp_ifOut[$m] = trim($array_snmp_ifOut[1]):$arr_snmp_ifOut[$m]="";
						count($array_snmp_ifIn)>=2?$arr_snmp_ifIn[$m] = trim($array_snmp_ifIn[1]):$arr_snmp_ifIn[$m]="";
				}
				$tempInsertNow = 0;
				$insert_device_iftraffic_text = "";
				while($array_device_iftraffic = mysql_fetch_array($result_device_iftraffic))
				{
					$var_lastin = $array_device_iftraffic['df_lastin'];
					$var_lastout = $array_device_iftraffic['df_lastout'];
					
					
					$temp_index = array_search($array_device_iftraffic['di_ifid'], $arr_snmp_ifindex);
					
					
					if($arr_snmp_ifIn[$temp_index] < $var_lastin)
					{
						$var_traffin = ($var_maxcounter - $var_lastin) + $arr_snmp_ifIn[$temp_index];
					}
					else
					{
						$var_traffin =  $arr_snmp_ifIn[$temp_index] - $var_lastin;
					}

					if($arr_snmp_ifOut[$temp_index] < $var_lastout)
					{
						$var_traffout = ($var_maxcounter - $var_lastout) + $arr_snmp_ifOut[$temp_index];
					}
					else
					{
						$var_traffout =  $arr_snmp_ifOut[$temp_index] - $var_lastout;
					}
					
					if($tempInsertNow == 0)
					{
						$insert_device_iftraffic_text = "insert into device_iftraffic (dt_id,de_id,di_ifid,df_lastin,df_lastout,df_avgin,df_avgout,df_totalin,df_totalout) VALUES (".$var_session_timeid.",". $de_id .",".$arr_snmp_ifindex[$temp_index].",".$arr_snmp_ifIn[$temp_index].",".$arr_snmp_ifOut[$temp_index].",".$var_traffin.",".$var_traffout .",".$var_traffin.",".$var_traffout .")";
						$tempInsertNow = 1;
					}
					else
					{
						$insert_device_iftraffic_text = $insert_device_iftraffic_text . ",(".$var_session_timeid.",". $de_id .",".$arr_snmp_ifindex[$temp_index].",".$arr_snmp_ifIn[$temp_index].",".$arr_snmp_ifOut[$temp_index].",".$var_traffin.",".$var_traffout .",".$var_traffin.",".$var_traffout .")";
					}
				}
				mysql_query($insert_device_iftraffic_text);
				echo  "<hr><h2>INSERT 02 TRAFFIC</h2> " .$insert_device_iftraffic_text . "<br><hr><br>";
			}
		}
		else
		{
			$arr_snmp_ifindex = array();
			$arr_snmp_ifOut = array();
			$arr_snmp_ifIn = array();

			for($m=0;$m<count($result_snmp_ifOut);$m++)
			{
					$array_snmp_ifindex = explode(": ",$result_snmp_ifindex[$m]);
					$array_snmp_ifOut = explode(": ",$result_snmp_ifOut[$m]);
					$array_snmp_ifIn = explode(": ",$result_snmp_ifIn[$m]);

					count($array_snmp_ifindex)>=2?$arr_snmp_ifindex[$m] = trim($array_snmp_ifindex[1]):$arr_snmp_ifindex[$m]="";
					count($array_snmp_ifOut)>=2?$arr_snmp_ifOut[$m] = trim($array_snmp_ifOut[1]):$arr_snmp_ifOut[$m]="";
					count($array_snmp_ifIn)>=2?$arr_snmp_ifIn[$m] = trim($array_snmp_ifIn[1]):$arr_snmp_ifIn[$m]="";
			}

			$select_device_iftraffic_text = "select * from device_iftraffic where de_id=" . $de_id . " and dt_id=" . $var_session_timeid . "";
			$result_device_iftraffic = mysql_query($select_device_iftraffic_text);

			$tempUpdate = 0;
			$insert_device_iftraffic_text = "";
			while($array_device_iftraffic = mysql_fetch_array($result_device_iftraffic))
			{
				$var_lastin = $array_device_iftraffic['df_lastin'];
				$var_lastout = $array_device_iftraffic['df_lastout'];
				$var_avgin = $array_device_iftraffic['df_avgin'];
				$var_avgout = $array_device_iftraffic['df_avgout'];
				$var_totalin = $array_device_iftraffic['df_totalin'];
				$var_totalout = $array_device_iftraffic['df_totalout'];

				$temp_index = array_search($array_device_iftraffic['di_ifid'], $arr_snmp_ifindex);
					
					
					if($arr_snmp_ifIn[$temp_index] < $var_lastin)
					{
						$var_traffin = ($var_maxcounter - $var_lastin) + $arr_snmp_ifIn[$temp_index];
					}
					else
					{
						$var_traffin =  $arr_snmp_ifIn[$temp_index] - $var_lastin;
					}

					if($arr_snmp_ifOut[$temp_index] < $var_lastout)
					{
						$var_traffout = ($var_maxcounter - $var_lastout) + $arr_snmp_ifOut[$temp_index];
					}
					else
					{
						$var_traffout =  $arr_snmp_ifOut[$temp_index] - $var_lastout;
					}


					if($var_avgin == 0)
					{
						$var_traffavgin = $var_traffin;
					}
					else
					{
						$var_traffavgin = round(($var_avgin + $var_traffin) / 2);
					}

					if($var_avgout == 0)
					{
						$var_traffavgout = $var_traffout;
					}
					else
					{
						$var_traffavgout = round(($var_avgout + $var_traffout) / 2);
					}

					$var_totalin = $var_totalin + $var_traffin;
					$var_totalout = $var_totalout + $var_traffout;

				if($tempUpdate == 0)
				{
					
					$insert_device_iftraffic_text = "insert into device_iftraffic (dt_id,de_id,di_ifid,df_lastin,df_lastout,df_avgin,df_avgout,df_totalin,df_totalout) VALUES (".$var_session_timeid.",". $de_id .",".$arr_snmp_ifindex[$temp_index].",".$arr_snmp_ifIn[$temp_index].",".$arr_snmp_ifOut[$temp_index].",".$var_traffavgin.",".$var_traffavgout .",".$var_totalin.",".$var_totalout .")";

					$tempUpdate = 1;

				}
				else
				{
					$insert_device_iftraffic_text =  $insert_device_iftraffic_text . ",(".$var_session_timeid.",". $de_id .",".$arr_snmp_ifindex[$temp_index].",".$arr_snmp_ifIn[$temp_index].",".$arr_snmp_ifOut[$temp_index].",".$var_traffavgin.",".$var_traffavgout .",".$var_totalin.",".$var_totalout .")";

				}
					//$update_device_iftraffic_text
					/*$update_device_iftraffic_text = $update_device_iftraffic_text . "update device_iftraffic set df_lastin=".$arr_snmp_ifIn[$temp_index].",df_lastout=".$arr_snmp_ifOut[$temp_index].",df_avgin=".$var_traffavgin.",df_avgout=".$var_traffavgout." where de_id=" . $de_id . " and dt_id=" . $var_session_timeid . " and di_ifid=" . $arr_snmp_ifindex[$temp_index] . " LIMIT 1 ;";*/
			}
			mysql_query("DELETE FROM device_iftraffic where de_id=" . $de_id . " and dt_id=". $var_session_timeid ."");
			mysql_query($insert_device_iftraffic_text);
			//echo  . "<br><hr><br>";
			echo  "<hr><h2>INSERT 03 TRAFFIC</h2> " .$insert_device_iftraffic_text . "<br><hr><br>";
		



		}
	}
}


// FIREWALL ASDM

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
$array_name = array();
mysql_query("DELETE FROM device_topip_inbound where dt_id=". $var_session_timeid ."");
for($i = 0;$i<count($array['host']);$i++)
{
	$array_ip[$i] = $array['host'][$i]['ip-addr'];
	$array_totalocet[$i] = $array['host'][$i]['total'];
	$array_currentocet[$i] = ($array['host'][$i]['current']/60);
	$temp = curl_init();
	curl_setopt($temp, CURLOPT_URL, 'http://202.44.47.47/unifi/user-for-netmon?ip='.$array['host'][$i]['ip-addr']);
	curl_setopt($temp, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($temp, CURLOPT_HEADER, 0);
	curl_setopt($temp, CURLOPT_BINARYTRANSFER, 1);
	curl_setopt($temp, CURLOPT_RETURNTRANSFER, 1);
	$result_ip = curl_exec($temp);
	curl_close($temp);

	$temp_array = (array)json_decode($result_ip);
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
		curl_setopt($temp, CURLOPT_URL, 'http://10.4.15.60/dhcpv2/api/getInfobyIP.php?ip_address='.$array['host'][$i]['ip-addr']);
		curl_setopt($temp, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($temp, CURLOPT_HEADER, 0);
		curl_setopt($temp, CURLOPT_BINARYTRANSFER, 1);
		curl_setopt($temp, CURLOPT_RETURNTRANSFER, 1);
		$result_ip = curl_exec($temp);
		curl_close($temp);
		
		
		$temp_array = @(array)json_decode(str_replace('<meta http-equiv="Content-Type" content="text/html; charset=utf-8">','',$result_ip));
		if(@$temp_array['code'] == "200")
		{
			$temp_data = (array)$temp_array['data'];
			$array_mode[$i] = 1;
			$array_email[$i] = "";
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
	$inset_recv_text = "insert into device_topip_inbound (dt_id,tin_rank,tin_ip,tin_totalusage,tin_current,
	tin_hostname,tin_email,tin_mac,tin_cid,tin_room,tin_name,tin_mode) VALUES (".$var_session_timeid."," . $i .",'" .
		$array_ip[$i] . "','" . $array_totalocet[$i] . "','" . $array_currentocet[$i] . "','" .
		mysql_real_escape_string($array_hostname[$i]) . "','" . $array_email[$i] . "','" . $array_mac[$i] . "','" .
		$array_comid[$i] . "','" . $array_room[$i] . "','" . mysql_real_escape_string($array_name[$i]) . "'," . $array_mode[$i] . ")";
	mysql_query($inset_recv_text);
	echo $inset_recv_text;

	if($i == 0)
	{

		$search_query_test = "select value from system_settings where variable='last2gb'";
		$result_search = mysql_query($search_query_test);
		$lastip = "";
		if(!mysql_num_rows($result_search))
		{
			mysql_query("insert into system_settings (variable,value) VALUES ('last2gb','')");
			$lastip = "0.0.0.0";
		}
		else
		{
			$array_search = mysql_fetch_array($result_search);
			$lastip = $array_search['value'];
		}

		if($lastip != $array_ip[$i])
		{
			$tmpOver = 0;
			$tmpresult = mysql_query("select value from system_settings where variable='alertover'");
			if(!mysql_num_rows($tmpresult))
			{
				mysql_query("insert into system_settings (variable,value) VALUES ('alertover','2048')");
				$tmpOver = 2048;
			}
			else
			{
				$arrayTmp = mysql_fetch_array($tmpresult);
				$tmpOver = (int)$arrayTmp['value'];

			}
			
			if($array_totalocet[$i] >= ($tmpOver*1024*1024))
			{
				mysql_query("update system_settings set value='" . $array_ip[$i] . "' where variable='last2gb'");
				$tmpOcet = $array_totalocet[$i];
				$tmpUnit = UnitConvertVar($tmpOcet);
				
				######### edit details ##########
				$appId = '582341538516887'; //Facebook App ID
				$appSecret = 'b1788911352f5e5274af5eac1395b686'; // Facebook App Secret
				##################################

				//Call Facebook API
				$facebook = new Facebook(array(
				  'appId'  => $appId,
				  'secret' => $appSecret
				));

				$select_token_text = "select value from system_settings where variable='fb_accesstoken'";
				$token_result = mysql_query($select_token_text);
				$token_array = mysql_fetch_array($token_result);

				$temp = curl_init();
				curl_setopt($temp, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($temp, CURLOPT_SSL_VERIFYHOST,  2);
				curl_setopt($temp, CURLOPT_URL, 'https://graph.facebook.com/fitm2.0?fields=access_token&access_token=' . $token_array['value']);
				curl_setopt($temp, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($temp, CURLOPT_HEADER, 0);
				curl_setopt($temp, CURLOPT_BINARYTRANSFER, 1);
				curl_setopt($temp, CURLOPT_RETURNTRANSFER, 1);
				$result = curl_exec($temp);
				curl_close($temp);

				//echo $new_token[1];
				$temp_array = (array)json_decode($result);
				//print_r($temp_array);


				$ch = curl_init();
				$params = array();

				if($array_mode[$i] == 0)
				{
					$insert_device_event_text = "insert into device_event 
					(devt_dtime,devt_message,devt_line1,devt_line2,devt_line3,devt_line4,devt_line5) 
					VALUES (NOW(),'[Alert] " . $array_ip[$i] ." use bandwidth over ". $tmpOver ."MB in last 1 hour.','IP : " . $array_ip[$i] ."','Hourly Usage : " . $tmpOcet ." ". $tmpUnit . "','Whois : ". $array_hostname[$i] ."','','');";
					mysql_query($insert_device_event_text);

					send_notification("[Alert] " . $array_hostname[$i] . " (" . $array_ip[$i] .") use bandwidth ". $tmpOcet ." ". $tmpUnit ." in last 1 hour.");

					$params = array(
					  "access_token" => $temp_array['access_token'], 
					  "message" => "[Traffic Alert]\n
					Detect " . $array_ip[$i] . " use bandwidth ". $tmpOcet ." ". $tmpUnit ." within 1 hour\n\nAccess Line : Unknow (API not provide)\nWhois : " . $array_hostname[$i] . "\n\n Event log by #FITMMONv2",
					);

				}
				else if($array_mode[$i] == 1)
				{
					$insert_device_event_text = "insert into device_event 
					(devt_dtime,devt_message,devt_line1,devt_line2,devt_line3,devt_line4,devt_line5) 
					VALUES (NOW(),'[Alert] " . $array_hostname[$i] . " (" . $array_ip[$i] .") use bandwidth over ". $tmpOver ."MB in last 1 hour.','IP : " . $array_ip[$i] ."','Hourly Usage : " . $tmpOcet ." ". $tmpUnit ."','Hostname : ". $array_hostname[$i] ."','Computer ID : ".$array_comid[$i]."','Room : ".$array_room[$i]."');";
					mysql_query($insert_device_event_text);

					send_notification("[Alert] " . $array_hostname[$i] . " (" . $array_ip[$i] .") use bandwidth ". $tmpOcet ." ". $tmpUnit ." in last 1 hour.");

					$params = array(
					  "access_token" => $temp_array['access_token'], 
					  "message" => "[Traffic Alert]\n
					Detect " . $array_ip[$i] . " use bandwidth ". $tmpOcet ." ". $tmpUnit ." within 1 hour\n\nAccess Line : Wired Network\n
					Hostname : " . $array_hostname[$i] ."\nName : " . $array_name[$i] . "\nName : " . $array_name[$i] . "\nRoom : " . $array_room[$i] . " \n\n Event log by #FITMMONv2",
					);
				}
				else if($array_mode[$i] == 2)
				{
					$insert_device_event_text = "insert into device_event 
					(devt_dtime,devt_message,devt_line1,devt_line2,devt_line3,devt_line4,devt_line5) 
					VALUES (NOW(),'[Alert] " . $array_name[$i] . " (" . $array_ip[$i] .") use bandwidth over ". $tmpOver ."MB in last 1 hour.','IP : " . $array_ip[$i] ."','Hourly Usage : " . $tmpOcet ." ". $tmpUnit ."','Hostname : ". $array_hostname[$i] ."','Name : ".$array_name[$i]."','E-Mail : ".$array_email[$i]."');";
					mysql_query($insert_device_event_text);
					send_notification("[Alert] " . $array_name[$i] . " (" . $array_ip[$i] .") use bandwidth ". $tmpOcet ." ". $tmpUnit ." in last 1 hour.");

					$params = array(
					  "access_token" => $temp_array['access_token'], 
					  "message" => "[Traffic Alert]\n
					Detect " . $array_ip[$i] . " use bandwidth ". $tmpOcet ." ". $tmpUnit ." within 1 hour\n\nAccess Line : WiFi Network \n
					Hostname : " . $array_hostname[$i] ."\nName : " . $array_name[$i] . "\nE-Mail : " . $array_email[$i] . " \n\n Event log by #FITMMONv2",
					);
				}


					try {
					  $ret = $facebook->api('/me/feed', 'POST', $params);
					  echo 'Successfully posted to Facebook';
					} catch(Exception $e) {
					  echo $e->getMessage();
					}

				
			}
			else
			{
				mysql_query("update system_settings set value='0.0.0.0' where variable='last2gb'");
			}
		}
		
	}
}

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

mysql_query("DELETE FROM device_topip_outbound where dt_id=". $var_session_timeid ."");
for($i = 0;$i<count($array['host']);$i++)
{
	$array_ip[$i] = $array['host'][$i]['ip-addr'];
	$array_totalocet[$i] = $array['host'][$i]['total'];
	$array_currentocet[$i] = ($array['host'][$i]['current']/60);
	$temp = curl_init();
	curl_setopt($temp, CURLOPT_URL, 'http://202.44.47.47/unifi/user-for-netmon?ip='.$array['host'][$i]['ip-addr']);
	curl_setopt($temp, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($temp, CURLOPT_HEADER, 0);
	curl_setopt($temp, CURLOPT_BINARYTRANSFER, 1);
	curl_setopt($temp, CURLOPT_RETURNTRANSFER, 1);
	$result_ip = curl_exec($temp);
	curl_close($temp);
	
	$temp_array = (array)json_decode($result_ip);
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
		curl_setopt($temp, CURLOPT_URL, 'http://10.4.15.60/dhcpv2/api/getInfobyIP.php?ip_address='.$array['host'][$i]['ip-addr']);
		curl_setopt($temp, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($temp, CURLOPT_HEADER, 0);
		curl_setopt($temp, CURLOPT_BINARYTRANSFER, 1);
		curl_setopt($temp, CURLOPT_RETURNTRANSFER, 1);
		$result_ip = curl_exec($temp);
		curl_close($temp);
		
		
		$temp_array = @(array)json_decode(str_replace('<meta http-equiv="Content-Type" content="text/html; charset=utf-8">','',$result_ip));
		if(@$temp_array['code'] == "200")
		{
			$temp_data = (array)$temp_array['data'];
			$array_mode[$i] = 1;
			$array_email[$i] = "";
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
	
	$inset_recv_text = "insert into device_topip_outbound (dt_id,tout_rank,tout_ip,tout_totalusage,tout_current,
	tout_hostname,tout_email,tout_mac,tout_cid,tout_room,tout_name,tout_mode) VALUES (".$var_session_timeid."," . $i .",'" .
		$array_ip[$i] . "','" . $array_totalocet[$i] . "','" . $array_currentocet[$i] . "','" .
		mysql_real_escape_string($array_hostname[$i]) . "','" . $array_email[$i] . "','" . $array_mac[$i] . "','" .
		$array_comid[$i] . "','" . $array_room[$i] . "','" . mysql_real_escape_string($array_name[$i]) . "'," . $array_mode[$i] . ")";
	mysql_query($inset_recv_text);
	echo $inset_recv_text;
}




?>
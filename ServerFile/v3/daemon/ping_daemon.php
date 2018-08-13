<?php
include("db.inc.php");

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




$select_device_text = "select * from device";
$result_device = mysql_query($select_device_text);
while ($array_device = mysql_fetch_array($result_device))
{
	$de_id = $array_device['de_id'];
	exec("regedit -v -s bin_regedit.reg");
	unset($ping_output); // Clear Output Buffer
	exec("bin_hrping.exe -n 1 -w 2000 " . $array_device['de_ipaddr'],$ping_output);
	$array_ping_result = explode("=",explode(",",$ping_output[8])[1]);
	if($array_ping_result[1] == 0) // Host Ping Failed
	{
		if($array_device['de_retire'] == 1)
		{
			$update_device_text = "update device set de_retire=2 where de_id=".$de_id;
			mysql_query($update_device_text);
			//send_notification($array_device['de_hostname'] . " changed state to down.");

		}
		else if($array_device['de_retire'] == 2)
		{
			$insert_device_event_text = "insert into device_event (devt_dtime,devt_message) VALUE
										(NOW(),'" . $array_device['de_hostname'] . " changed state to Down.');";
			mysql_query($insert_device_event_text);
			$update_device_text = "update device set de_retire=3 where de_id=".$de_id;
			mysql_query($update_device_text);
			send_notification($array_device['de_hostname'] . " changed state to down.");

		}
		else if($array_device['de_retire'] == 0)
		{
			$update_device_text = "update device set de_retire=1 where de_id=".$de_id;
			mysql_query($update_device_text);
		}	
	}
	else
	{
		if($array_device['de_retire'] > 0)
		{
			$update_device_text = "update device set de_retire=0 where de_id=".$de_id;
			mysql_query($update_device_text);
			if($array_device['de_retire'] == 3)
			{
				$insert_device_event_text = "insert into device_event (devt_dtime,devt_message) VALUE
										(NOW(),'" . $array_device['de_hostname'] . " return from Down state.');";
				mysql_query($insert_device_event_text);
				send_notification($array_device['de_hostname'] . " return from down state.");
			}
		}
	}
}


?>
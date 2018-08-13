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

send_notification("[!!DANGER!!] Ph.D.Anirach Mingkhwan (10.3.92.88) use bandwidth 1500TB in last 1 hour.");
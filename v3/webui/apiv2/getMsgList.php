<?php
include("../db.inc.php");
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

$select_evtid_text = "SELECT * FROM `device_event` ORDER BY devt_id DESC LIMIT 0,100";

$result_evtid = mysql_query($select_evtid_text);

$msgBuffer['msg_count'] = mysql_num_rows($result_evtid);

if(mysql_num_rows($result_evtid))
{

	$arrRunner = 0;
	while($devt_array = mysql_fetch_array($result_evtid))
	{
		if($arrRunner == 0)
			mysql_query("update user set devt_id=" . $devt_array['devt_id'] . " where email='".$user_array['email']."'");
		$msgDateTime = new DateTime($devt_array['devt_dtime']);
		$event['eventID'] = $devt_array['devt_id'];
		$event['eventTime'] = $msgDateTime->format("[Y/m/d H:i]");
		$event['eventMsg'] = $devt_array['devt_message'];
		

		$dataBuffer[$arrRunner] = $event;
		$arrRunner = $arrRunner + 1;
	}
	

	/*$arrRunner = 0;
	while($devt_array = mysql_fetch_array($result_evtid))
	{
		$msgDateTime = new DateTime($devt_array['devt_dtime']);
		$eventTime[$arrRunner] = $msgDateTime->format("[Y/m/d H:i]");
		$eventMsg[$arrRunner] = $devt_array['devt_message'];
		$eventID[$arrRunner] = $devt_array['devt_id'];
		$arrRunner = $arrRunner + 1;
	}
	$dataBuffer['eventID'] = $eventID;
	$dataBuffer['eventTime'] = $eventTime;
	$dataBuffer['eventMsg'] = $eventMsg;*/

	$json_buffer = '{
		"code":200,
		"data":' . json_encode($dataBuffer) .'
	}';
	echo $json_buffer;
}
else
{
	$json_buffer = '{
		"code":201,
		"data":""
	}';
	echo $json_buffer;

}





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
<?php
include("../db.inc.php");
if(!isset($_POST['email']) || !isset($_POST['eventID']))
{
	$json_buffer = '{
		"code":302,
		"data":""
	}';
	echo $json_buffer;
	exit();
}

$email = $_POST['email'];
$eventID = $_POST['eventID'];

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

$select_evtid_text = "SELECT * FROM `device_event` where devt_id=" . $eventID;

$result_evtid = mysql_query($select_evtid_text);


if(mysql_num_rows($result_evtid))
{
	$devt_array = mysql_fetch_array($result_evtid);

	$msgDateTime = new DateTime($devt_array['devt_dtime']);
	$event['eventID'] = $devt_array['devt_id'];
	$event['eventTime'] = $msgDateTime->format("Y/m/d H:i");
	$event['eventMsg'] = $devt_array['devt_message'];
	$event['eventLine1'] = $devt_array['devt_line1'] == null?"":$devt_array['devt_line1'];
	$event['eventLine2'] = $devt_array['devt_line2'] == null?"":$devt_array['devt_line2'];
	$event['eventLine3'] = $devt_array['devt_line3'] == null?"":$devt_array['devt_line3'];
	$event['eventLine4'] = $devt_array['devt_line4'] == null?"":$devt_array['devt_line4'];
	$event['eventLine5'] = $devt_array['devt_line5'] == null?"":$devt_array['devt_line5'];

	$json_buffer = '{
		"code":200,
		"data":' . json_encode($event) .'
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
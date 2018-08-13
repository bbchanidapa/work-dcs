<?php
	include("../db.inc.php");
	include("../function.api.inc.php");
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
if(isset($_POST['mode'])) $mode = $_POST['mode'];
else $mode=0;




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


$select_group_text = "select * from `group` where gid=".$user_array['groupid']."";
$result_group = mysql_query($select_group_text);
$group_array = mysql_fetch_array($result_group);

if($group_array['access'] != 64)
{
	$json_buffer = '{
		"code":405,
		"data":""
	}';
	echo $json_buffer;
	exit();
}
if($mode == 1)
{
	if(!isset($_POST['addemail']) || !isset($_POST['addgid']))
	{
		$json_buffer = '{
		"code":302,
		"data":""
		}';
		echo $json_buffer;
		exit();
	}

	$select_event_text = "select * from device_event order by devt_id DESC LIMIT 0,1";
	$result_select_event = mysql_query($select_event_text);
	$readnum = 0;
	if(!mysql_num_rows($result_select_event)) $readnum = 0;
	else 
	{
		$arr_event = mysql_fetch_array($result_select_event);
		$readnum = $arr_event['devt_id'];
	}

	$insert_user_text = "insert into user (email,groupid,devt_id) VALUES ('" . $_POST['addemail'] . "',".$_POST['addgid']."," . $readnum .")";
	if(!mysql_query($insert_user_text))
	{
		$json_buffer = '{
		"code":302,
		"data":""
		}';
		echo $json_buffer;
		exit();
	}



	$json_buffer = '{
		"code":200,
		"data":""
		}';
		echo $json_buffer;
		exit();

}
else if($mode == 2)
{
	if(!isset($_POST['uid']) || !isset($_POST['gid']))
	{
		$json_buffer = '{
		"code":302,
		"data":""
		}';
		echo $json_buffer;
		exit();
	}

	$update_user_group_text = "update `user` set groupid=".$_POST['gid']." where uid=".$_POST['uid']."";
	if(!mysql_query($update_user_group_text))
	{
		$json_buffer = '{
		"code":302,
		"data":""
		}';
		echo $json_buffer;
		exit();
	}



	$json_buffer = '{
		"code":200,
		"data":""
		}';
		echo $json_buffer;
		exit();

}
else if($mode == 3)
{
	if(!isset($_POST['uid']))
	{
		$json_buffer = '{
		"code":302,
		"data":""
		}';
		echo $json_buffer;
		exit();
	}

	$delete_user_group_text = "delete from user where uid=".$_POST['uid']."";
	if(!mysql_query($delete_user_group_text))
	{
		$json_buffer = '{
		"code":302,
		"data":""
		}';
		echo $json_buffer;
		exit();
	}



	$json_buffer = '{
		"code":200,
		"data":""
		}';
		echo $json_buffer;
		exit();

}



$select_all_from_user = "select * from user join `group` on user.groupid = `group`.gid";
$result_select_all_from_user = mysql_query($select_all_from_user);
if (mysql_num_rows($result_select_all_from_user) == 0)
{
	$json_buffer = '{
		"code":406,
		"data":""
	}';
	echo $json_buffer;
	exit();
}

$userCount = 0;
$userArray = array();
while($arr_alluser = mysql_fetch_array($result_select_all_from_user))
{
	$userArray[$userCount] = $arr_alluser;
	$userCount = $userCount + 1;
}


$json_buffer = '{"code":200,"data":' . json_encode($userArray) . '}';
echo $json_buffer;
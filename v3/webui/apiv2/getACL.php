<?php
include("../db.inc.php");
include("../function.api.inc.php");
require_once "../telnet.class.inc.php";

if(!isset($_REQUEST['email']))
{
	$json_buffer = '{
		"code":302,
		"data":""
	}';
	echo $json_buffer;
	exit();
}

$email = $_REQUEST['email'];
if(isset($_REQUEST['mode'])) $mode = $_REQUEST['mode'];
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

if($group_array['access'] != 32 && $group_array['access'] != 64)
{
	$json_buffer = '{
		"code":403,
		"data":""
	}';
	echo $json_buffer;
	exit();
}


if($mode == 0)
{
	$select_acl_list = "select * from device_acl";
	$result_acl_list = mysql_query($select_acl_list);

	$levelOneArray = array();
	$dataCount = 0;
	while($array_acl_list = mysql_fetch_array($result_acl_list))
	{
		$myTempArray['acl_id'] = $array_acl_list['acl_id'];
		$myTempArray['acl_ipaddr'] = $array_acl_list['acl_ipaddr'];
		$myTempArray['acl_type'] = $array_acl_list['acl_type'];
		if($array_acl_list['acl_type'] == 0) $myTempArray['acl_typetext'] = "Inside Host";
		else $myTempArray['acl_typetext'] = "Outside Host";
		
		$levelOneArray[$dataCount] = $myTempArray;
		$dataCount++;
	}
	$json_buffer = '{"code":200,"data":' . json_encode($levelOneArray) . '}';
	echo $json_buffer;
	exit();
}
else if($mode == 1)
{
	if(!isset($_REQUEST['acl_ipaddr']) || !isset($_REQUEST['acl_type']))
	{
		$json_buffer = '{
			"code":302,
			"data":""
		}';
		echo $json_buffer;
		exit();
	}
	$acl_ipaddr = $_REQUEST['acl_ipaddr'];
	$acl_type = $_REQUEST['acl_type'];

	$select_acl_list = "select * from device_acl where acl_ipaddr='" . $acl_ipaddr ."'";
	$result_acl_list = mysql_query($select_acl_list);
	if(mysql_num_rows($result_acl_list))
	{
		$json_buffer = '{
			"code":402,
			"data":""
		}';
		echo $json_buffer;
		exit();
	}
	

	/////// TELNET ZONE ///////

	$telnetConn = new PHPTelnet();
	$result = @$telnetConn->Connect("10.9.99.1",'','cisco');
	if($result != 0)
	{
		$json_buffer = '{
			"code":500,
			"data":""
		}';
		echo $json_buffer;
		exit();
	}

	$telnetConn->DoCommand('en', $result);
	$telnetConn->DoCommand('network', $result);
	$telnetConn->DoCommand('configure terminal', $result);
	if($acl_type == 0)
		$telnetConn->DoCommand('access-list FITM_NETMON_ACL_INSIDE line 1 extend deny ip host ' . $acl_ipaddr . ' any', $result);
	else $telnetConn->DoCommand('access-list FITM_NETMON_ACL_INSIDE line 1 extend deny ip any host ' . $acl_ipaddr . '', $result);
	
	//echo $result;
	$pos = strrpos($result, "ERROR:");
	if ($pos === false){}
	else
	{
		$json_buffer = '{
			"code":501,
			"data":""
		}';
		echo $json_buffer;
		exit();
	}

	$telnetConn->DoCommand('exit', $result);
	$telnetConn->DoCommand('copy running-config startup-config', $result);
	$telnetConn->DoCommand(' ', $result);
	$telnetConn->DoCommand(' ', $result);
	$telnetConn->Disconnect();

	//echo $result;

	////// END TELNET ZONE ///////

	$insert_acl_query = "insert into device_acl (acl_ipaddr,acl_type) VALUES ('" . $acl_ipaddr ."',".$acl_type.")";
	$result_acl_query = mysql_query($insert_acl_query);
	if($result_acl_query)
	{
		$json_buffer = '{
			"code":200,
			"data":""
		}';
		echo $json_buffer;
		exit();
	}
	else
	{
		$json_buffer = '{
			"code":302,
			"data":""
		}';
		echo $json_buffer;
		exit();
	}
	

}
else if($mode == 2)
{
	if(!isset($_REQUEST['acl_id']))
	{
		$json_buffer = '{
			"code":302,
			"data":""
		}';
		echo $json_buffer;
		exit();
	}
	$acl_id = $_REQUEST['acl_id'];

	$select_acl_list = "select * from device_acl where acl_id=" . $acl_id ."";
	$result_acl_list = mysql_query($select_acl_list);
	if(!mysql_num_rows($result_acl_list))
	{
		$json_buffer = '{
			"code":404,
			"data":""
		}';
		echo $json_buffer;
		exit();
	}
	$array_acl_list = mysql_fetch_array($result_acl_list);

	$acl_ipaddr = $array_acl_list['acl_ipaddr'];
	$acl_type = $array_acl_list['acl_type'];
	
	/////// TELNET ZONE ///////

	$telnetConn = new PHPTelnet();
	$result = @$telnetConn->Connect("10.9.99.1",'','cisco');
	if($result != 0)
	{
		$json_buffer = '{
			"code":500,
			"data":""
		}';
		echo $json_buffer;
		exit();
	}

	$telnetConn->DoCommand('en', $result);
	$telnetConn->DoCommand('network', $result);
	$telnetConn->DoCommand('configure terminal', $result);
	if($acl_type == 0)
		$telnetConn->DoCommand('no access-list FITM_NETMON_ACL_INSIDE extend deny ip host ' . $acl_ipaddr . ' any', $result);
	else $telnetConn->DoCommand('no access-list FITM_NETMON_ACL_INSIDE extend deny ip any host ' . $acl_ipaddr . '', $result);
	
	//echo $result;
	$pos = strrpos($result, "ERROR:");
	if ($pos === false){}
	else
	{
		$json_buffer = '{
			"code":501,
			"data":""
		}';
		echo $json_buffer;
		exit();
	}

	$telnetConn->DoCommand('exit', $result);
	$telnetConn->DoCommand('copy running-config startup-config', $result);
	$telnetConn->DoCommand(' ', $result);
	$telnetConn->DoCommand(' ', $result);
	$telnetConn->Disconnect();

	////// END TELNET ZONE ///////

	$insert_acl_query = "delete from device_acl where acl_id=" . $acl_id;
	$result_acl_query = mysql_query($insert_acl_query);
	if($result_acl_query)
	{
		$json_buffer = '{
			"code":200,
			"data":""
		}';
		echo $json_buffer;
		exit();
	}
	else
	{
		$json_buffer = '{
			"code":302,
			"data":""
		}';
		echo $json_buffer;
		exit();
	}
	

}

?>

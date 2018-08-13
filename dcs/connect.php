<?php
	$connect = mysql_connect("192.168.190.34:3306","remoteroot","password");
	$db  = mysql_select_db("dcs_smartoffice",$connect);
/*		mysql_query("SET character_set_results=UTF8");
	mysql_query("SET character_set_client=UTF8");
	mysql_query("SET character_set_connection=UTF8");*/
?>
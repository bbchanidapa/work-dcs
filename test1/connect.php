<?php
	session_start();
	$connect = mysql_connect("localhost", "root", "1234");
	$db = mysql_select_db("test");
	//Set UTF in Database
	mysql_query("SET character_set_results=UTF8");
	mysql_query("SET character_set_client=UTF8");
	mysql_query("SET character_set_connection=UTF8");
?>
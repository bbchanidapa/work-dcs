<?
$connect = mysql_connect("localhost", "root", "1234");
	$db = mysql_select_db("session_test");

//check error connect DB
	if (!$connect ) {
		die(mysql_error());
	}
//check error  DB
	if (!$db) {
		echo "DB error";
	}
	mysql_query("SET character_set_results=UTF8");
	mysql_query("SET character_set_client=UTF8");
	mysql_query("SET character_set_connection=UTF8");
?>
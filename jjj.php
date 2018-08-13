<?php
header("Content-type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: *');
$con =  mysql_connect("localhost","root","root") or die("Error Connect to Database");
		mysql_select_db('movies', $con);
		mysql_set_charset('utf-8');
		mysql_query("SET character_set_results=UTF8");
	mysql_query("SET character_set_client=UTF8");
	mysql_query("SET character_set_connection=UTF8");

$sql = "SELECT * FROM movie ";
$query = mysql_query($sql);
?>
<?
function replace($matches) {
    return html_entity_decode('&#x' . $matches[1] . ';', ENT_COMPAT, 'UTF-8');
}
$arr11 = array();
while ( $result = mysql_fetch_array($query))
 {

 	$arr = array("id"=> $result['id'], 
 				 "nameth"=>$result['nameth'],
 				 "name"=>$result['name'], 
 				 "img"=> $result['img'],
 				 "plot"=> $result['plot']);

	//print_r($arr);
	//$arr = iconv("tis-620","utf-8",$arr);
 	//$json = json_encode($arr);
 	/*mb_internal_encoding('UTF-8');
 	$arr=array_map('utf8_encode',$arr);*/

 	array_push($arr11,$arr); 
 	
}
$json = json_encode( $arr11);
 	$unescaped = preg_replace_callback('/\\\\u(\w{4})/', replace, $json);
 	echo($unescaped);


?>

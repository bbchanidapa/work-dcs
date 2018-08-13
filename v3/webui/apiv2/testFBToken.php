<?php
	include("../db.inc.php");
	include_once("./api/facebook.php"); //include facebook SDK

	######### edit details ##########
	$appId = '582341538516887'; //Facebook App ID
	$appSecret = 'b1788911352f5e5274af5eac1395b686'; // Facebook App Secret
	##################################

	//Call Facebook API
	$facebook = new Facebook(array(
	  'appId'  => $appId,
	  'secret' => $appSecret
	));

	$select_token_text = "select value from system_settings where variable='fb_accesstoken'";
	$token_result = mysql_query($select_token_text);
	$token_array = mysql_fetch_array($token_result);

	$temp = curl_init();
	curl_setopt($temp, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($temp, CURLOPT_SSL_VERIFYHOST,  2);
	curl_setopt($temp, CURLOPT_URL, 'https://graph.facebook.com/fitm2.0?fields=access_token&access_token=' . $token_array['value']);
	curl_setopt($temp, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($temp, CURLOPT_HEADER, 0);
	curl_setopt($temp, CURLOPT_BINARYTRANSFER, 1);
	curl_setopt($temp, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($temp);
	curl_close($temp);

	//echo $new_token[1];
	$temp_array = (array)json_decode($result);
	//print_r($temp_array);


	$ch = curl_init();

	
	$params = array(
  "access_token" => $temp_array['access_token'], 
  "message" => "ทดสอบการโพสลองแฟนเพจ \n\n Event log by #FITMMONv2",
);
	try {
  $ret = $facebook->api('/me/feed', 'POST', $params);
  echo 'Successfully posted to Facebook';
} catch(Exception $e) {
  echo $e->getMessage();
}

?>
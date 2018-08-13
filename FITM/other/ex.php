<?php
        //$url = "https://sheetsu.com/apis/v1.0/db2aa02066ae";
   	/*	$headers = array(
                "Authorization: GoogleLogin auth=" . $google_auth,
                "GData-Version: 3.0",
                "Content-Type: application/json",
                );
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POSTFIELDS, 'fields=Inbound');
      curl_setopt ($ch , CURLOPT_RETURNTRANSFER , 1 );
      $result = curl_exec($ch);
      echo gettype($result);*/
		function httpGet($url)
		{
			$ch = curl_init();  

			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

			$output=curl_exec($ch);

			curl_close($ch);
			return $output;
		}
 
echo httpGet("https://sheetsu.com/apis/v1.0/44ffd6759661");

/*	$ch=curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	//curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	$result = json_decode(curl_exec($ch), true);
	//curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	//curl_setopt($ch, CURLOPT_POSTFIELDS,"fields=Inbound");
	$reply=curl_exec($ch);	
	$d = curl_getinfo($ch);
	print_r($reply);
	echo gettype($result);
	//print_r($d);
	curl_close($ch);
*/

	//echo $d;
/*	$datas = json_decode( $reply, true);
	print_r($datas);*/

/*$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
            "fields=id");

// in real life you should use something like:
curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query(array('id' => '1')));

// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec ($ch);

curl_close ($ch);

// further processing ....
echo gettype($server_output['id']);
*/

  /*    curl -X PUT -H "Content-Type: application/json" https://sheetsu.com/apis/v1.0/020b2c0f/name/Lois -d '{ "id": "2", "name": "Loo1z", "score": "1337" }'*/
?>

<!-- 
.iso.3.6.1.2.1.47.1.1.1.1.2.1: ""Cisco Systems, Inc. WS-C4503-E 3 slot switch "",
.iso.3.6.1.2.1.47.1.1.1.1.2.2: ""WS-C4503-E 3 slot switch chassis slot"",
.iso.3.6.1.2.1.47.1.1.1.1.2.3: ""WS-C4503-E 3 slot switch chassis slot"",
.iso.3.6.1.2.1.47.1.1.1.1.2.4: ""WS-C4503-E 3 slot switch chassis slot"",
.iso.3.6.1.2.1.47.1.1.1.1.2.5: "" WS-C4503-E 3 slot switch backplane"",
.iso.3.6.1.2.1.47.1.1.1.1.2.6: ""Container of Fan Tray"",
.iso.3.6.1.2.1.47.1.1.1.1.2.7: ""FanTray"",
.iso.3.6.1.2.1.47.1.1.1.1.2.8: ""Container of Container of Power Supply"",
.iso.3.6.1.2.1.47.1.1.1.1.2.9: ""Container of Power Supply"",
.iso.3.6.1.2.1.47.1.1.1.1.2.10: ""Power Supply ( AC 1400W )"",
.iso.3.6.1.2.1.47.1.1.1.1.2.11: ""Power Supply Fan Sensor"",
.iso.3.6.1.2.1.47.1.1.1.1.2.12: ""Container of Power Supply"",
.iso.3.6.1.2.1.47.1.1.1.1.2.13: ""Power Supply ( AC 1400W )"",
.iso.3.6.1.2.1.47.1.1.1.1.2.14: ""Power Supply Fan Sensor"",
.iso.3.6.1.2.1.47.1.1.1.1.2.1000: ""Supervisor 6L-E 10GE (X2), 1000BaseX (SFP) with 2 10GE X2 ports"",
.iso.3.6.1.2.1.47.1.1.1.1.2.1001: ""Port Container"",
.iso.3.6.1.2.1.47.1.1.1.1.2.1002: ""Port Container"",
.iso.3.6.1.2.1.47.1.1.1.1.2.1900: ""Management Port"",
.iso.3.6.1.2.1.47.1.1.1.1.2.2000: ""6 Dual media SFP or 10/100/1000BaseT  -->
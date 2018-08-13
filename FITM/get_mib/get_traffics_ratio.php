<?php
	$host = array("10.77.4.1","10.77.1.2","10.77.6.2","10.77.3.2","10.77.4.2","10.77.5.2");

	foreach ($host as $key => $ip) { 
		$traffics[$ip] = array(
			'inbound'=>snmpwalk($ip, 'public', '.1.3.6.1.2.1.2.2.1.10'),
			'outbound' => snmpwalk($ip, 'public', '.1.3.6.1.2.1.2.2.1.16')
		);
	}
	foreach ($traffics as $keyIP => $ip) {
		//echo $keyIP;
		foreach ($ip as $keyInOut => $interface) {
			//echo $keyInOut;
			foreach ($interface as $key => $InOut) {
				//echo $InOut;
				$str = substr($InOut,10);
	   	        $sum += $str;
	   	        if($keyInOut == 'inbound'){
	   	        	$traffics[$keyIP][$keyInOut] = number_format($sum /1073741824,2);//Gbps
	   	        }
	   	        else if($keyInOut == 'outbound'){
	   	        	$traffics[$keyIP][$keyInOut] = number_format($sum /1073741824,2);
	   	        	
	   	        }

			}//echo "<hr>";
			$sum = 0;
		}
	}
	foreach ($traffics as $keyIP => $ip) {
		$traffics[$keyIP]['inbound']+$traffics[$keyIP]['outbound'];
		$traffics[$keyIP] = $traffics[$keyIP]['inbound']+$traffics[$keyIP]['outbound'];
		//echo "<br>";
	}//echo "<br>";
	   		
	//print_r($traffics);
	$encode = json_encode($traffics);
	return $encode;	
?>
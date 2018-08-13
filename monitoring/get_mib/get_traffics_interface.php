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
				$str = (substr($InOut,10)/1048576);
	   	        $traffics[$keyIP][$keyInOut][$key] = number_format($str,2);
			}//echo "<hr>";
		}
	}
	
    print_r($traffics);
	$encode = json_encode($traffics);
	return $encode;
?>

<!-- ini_set('max_execution_time', 500); -->
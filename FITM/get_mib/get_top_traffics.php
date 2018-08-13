<?php
	$host = array("10.77.1.2","10.77.6.2","10.77.3.2","10.77.4.2","10.77.5.2");

	foreach ($host as $key => $ip) { 
		$traffics[$ip] = array(		
			'inbound'=>snmpwalkoid($ip, 'public', '.1.3.6.1.2.1.2.2.1.10'),
			'outbound' => snmpwalkoid($ip, 'public', '.1.3.6.1.2.1.2.2.1.16')
		);
	}

	foreach ($traffics as $ip => $hosts) {
			//echo $ip."<br>";
			foreach ($hosts as $interface => $arr) {
				//echo $interface;
				$newArr  = array();
				foreach ($arr as $key => $value) {
					$traff = substr($value,10);
					if ($ip == '10.77.1.2') {
						if(substr($key,24) == '11'){
							$newArr['B101A 10.1.201.0/24'] = number_format(($traff/1048576),2);//Mbps/MB	
						}
					}//if host
					else if ($ip == '10.77.6.2') {
						if(substr($key,24) == '121'){
							$newArr['B101C 10.1.101.0/24'] = number_format(($traff/1048576),2);	
						}
					}//if host
					else if($ip == '10.77.3.2'){
						if(substr($key,24) == '31'){
							$newArr['B324 10.3.24.0/24'] = number_format(($traff/1048576),2);	
						}
						else if(substr($key,24) == '32'){
							$newArr['B325 10.3.25.0/24'] = number_format(($traff/1048576),2);	
						}
						else if(substr($key,24) == '33'){
							$newArr['B327 10.3.27.0/24'] = number_format(($traff/1048576),2);	
						}
						else if(substr($key,24) == '34'){
							$newArr['B330B 10.3.230.0/24'] = number_format(($traff/1048576),2);	
						}
						else if(substr($key,24) == '36'){
							$newArr['B332 10.3.32.0/24'] = number_format(($traff/1048576),2);	
						}
						else if(substr($key,24) == '37'){
							$newArr['B329 10.3.91.0/24'] = number_format(($traff/1048576),2);	
						}
					}//if host
					else if ($ip == '10.77.4.2') {
						if(substr($key,24) == '43'){
							$newArr['B401A 10.4.101.0/24'] = number_format(($traff/1048576),2);
						}
						else if(substr($key,24) == '44'){
							$newArr['B401B 10.4.201.0/24'] = number_format(($traff/1048576),2);	
						}
						else if(substr($key,24) == '45'){
							$newArr['B402 10.4.2.0/24'] = number_format(($traff/1048576),2);
						}
					}//if host
					else if ($ip == '10.77.5.2') {
						if(substr($key,24) == '51'){
							$newArr['B408 10.4.8.0/24'] = number_format(($traff/1048576),2);	
						}
						else if(substr($key,24) == '52'){
							$newArr['B409 10.4.9.0/24'] = number_format(($traff/1048576),2);
						}
						else if(substr($key,24) == '53'){
							$newArr['B411 10.4.11.0/24'] = number_format(($traff/1048576),2);	
						}
						else if(substr($key,24) == '54'){
							$newArr['B415 10.4.15.0/24'] = number_format(($traff/1048576),2);	
						}
						else if(substr($key,24) == '55'){
							$newArr['B416 10.4.16.0/24'] = number_format(($traff/1048576),2);	
						}
						else if(substr($key,24) == '56'){
							$newArr['B417 10.4.17.0/24'] = number_format(($traff/1048576),2);	
						}
					}//if host
					
				}
				$traffics[$ip][$interface] = $newArr;
			}//echo "<hr>";
	}

	//print_r($traffics);
	$encode = json_encode($traffics);
	return $encode;
?>
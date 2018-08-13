<?php
	$host = array("10.77.4.1","10.77.1.2","10.77.6.2","10.77.3.2","10.77.4.2","10.77.5.2");

$txt = snmpwalkoid("10.77.5.2", 'public', '.1.3.6.1.2.1.4.22.1.2');
	/*$a = snmpwalkoid("10.77.5.2", "public", ""); 
	for (reset($a); $i = key($a); next($a)) {
	    echo "$i: $a[$i]<br />\n";
	}*/
/*$string = iconv('ASCII', 'UTF-8//IGNORE', $txt['.iso.3.6.1.2.1.4.22.1.2.58.10.41.160.93']);
echo $string;*/
	foreach ($host as $key => $ip) { 
		$lists[$ip] = array(
			'mac'=>snmpwalkoid($ip, 'public', '.1.3.6.1.2.1.3.1.1.2'),
			//'inbound'=>snmpwalkoid($ip, 'public', '.1.3.6.1.2.1.2.2.1.10'),
			//'outbound' => snmpwalkoid($ip, 'public', '.1.3.6.1.2.1.2.2.1.16')
			//'outbound' => snmpwalk($ip, 'public', '.1.3.6.1.2.1.2.2.1.16')
		);
	}

	foreach ($lists as $keyIP => $ip) {
		//echo $keyIP;
		$arr = array();
/*		$macs = snmpwalk($keyIP, 'public', '.1.3.6.1.2.1.3.1.1.2');
		print_r($macs);*/
		foreach ($ip as $key => $macArr) {
			//print_r($macArr);			
			foreach ($macArr as $oid => $mac) {
				//echo $mac;
				$txtOid = substr($oid,23);
				
				if(preg_match("/[0-9]+(.)/",$txtOid, $matches)){	
					$index = substr($matches[0],0,strpos($matches[0],"."));
					$ip_output = substr($txtOid,strlen($matches[0])+2);
	
					$arr[$ip_output] = $mac;
						 
					
				}			
				
			}//echo "<hr>";
			
		}//echo "<hr>";
		$lists[$keyIP]['mac'] = $arr;
	}
	
  print_r($lists);  
	$encode = json_encode($lists);
	return $encode;
?>
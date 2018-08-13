<?php
    $inSw4503  = snmpwalk("10.77.4.1", 'public', '.1.3.6.1.2.1.2.2.1.10');
    $outSw4503 = snmpwalk("10.77.4.1", 'public', '.1.3.6.1.2.1.2.2.1.16');
	$inboundSw4503 = 0;
	$outboundSw4503 = 0;
    foreach ($inSw4503 as $key => $inbound) {	
   		$str = substr($inbound,10);
   	    $inboundSw4503 += $str;
	}
	foreach ($outSw4503 as $key => $outbound) {	
   		$str = substr($outbound,10);
   	    $outboundSw4503 += $str;
	}

	$traffics = array(
		'inbound' => number_format(($inboundSw4503/1073741824),2),
		'outbound' => number_format(($outboundSw4503/1073741824),2)
	);
	//print_r($traffics);
	$encode = json_encode($traffics);
	return $encode;	

?>
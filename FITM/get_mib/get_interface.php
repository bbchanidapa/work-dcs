<?php
	header('Content-Type: application/json');

	$host       = array("10.77.4.1","10.77.1.2","10.77.6.2","10.77.3.2","10.77.4.2","10.77.5.2");
	$interfaces = array();
	$main       = array();

	foreach ($host as $key => $value) {
		$interface  = snmpwalk($value,'public', '.1.3.6.1.2.1.2.2.1.2');
		$interfaces[$value] = $interface;
		$main[$value] = ''; 
	}

	foreach ($interfaces as $keys => $values) {	
        if($main[$keys]  == ''){
			$main[$keys] = 	$values;	
		} 
	} 
    //echo gettype($main);
	//print_r($main);
	$encode = json_encode($main);
	//echo gettype($encode);
	echo $encode;
	//echo json_encode($main);
	//print_r(json_decode($encode));

?>
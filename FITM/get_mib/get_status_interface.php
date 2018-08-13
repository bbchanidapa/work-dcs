<?php
	$host       = array("10.77.4.1","10.77.1.2","10.77.6.2","10.77.3.2","10.77.4.2","10.77.5.2");
	$interfaces = array();
	$status     = array();
	$main       = array();

	foreach ($host as $key => $value) {
		$interface  = snmpwalk($value, 'public', '.1.3.6.1.2.1.2.2.1.2');
		$stat     = snmpwalk($value, 'public', '.1.3.6.1.2.1.2.2.1.8');

		$interfaces[$value] = $interface;
		$status[$value] = $stat;
		$main[$value] = ''; 
	}

	foreach ($interfaces as $keys => $values) {	
	    $key_interface = array();
		foreach ($values as $key => $value) {	
			$key_interface[$value] = '';	
		}
        if($main[$keys]  == ''){
			$main[$keys] = 	$key_interface;	
		} 
	} 

    foreach ($status as $keys => $values) {
    	//print_r($main[$keys]);
    	$index = 0;
    	foreach ($main[$keys] as $key => $val) {
    		if($index < count($main[$keys]) ){
    			if($values[$index] == 1){
    				$main[$keys][$key] = 'Up';	
    			}else{
    				$main[$keys][$key] = 'Down';
    			}
    			
    			//echo "[".$key."=".$values[$index]."]";
    		}	
    		$index+=1;
    	}
	}
	//print_r($main);
	$encode = json_encode($main);
	return $encode;

?>
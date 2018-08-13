<?php
	$detail = array();
	$host   = array("10.77.4.1","10.77.1.2"/*,"10.77.6.2","10.77.3.2","10.77.4.2","10.77.5.2"*/);
	

	/*for($i = 0; $i< count($host) ; $i++){*/
		$sysName = snmpget("10.77.5.2", "public", ".1.3.6.1.2.1.2.2");
		//print_r($sysName);
/*		array_push($detail,$sysName);
	}*/
/*	
	for ($i=0; $i < count($detail) ; $i++) { 
		echo $detail[$i]."<br><br>";
	}*/

    //$inbound = snmpwalk("10.77.4.1", 'public', '.1.3.6.1.2.1.2.2.1.10');
	/*for($i=0;$i< count($inbound);$i++){
		echo $interfaces[$i];
		echo '<br>';
	}*/
	/*foreach ($inbound as $val) {
    echo "$val\n";
}*/
 //print_r(snmprealwalk("10.77.4.1", "public", '.1.3.6.1.2.1.2.2.1.10'));
//print_r(snmprealwalk("10.77.5.2", "public", "IF-MIB::ifindex"));
//$sys = snmprealwalk("10.77.5.2", "public", "IF-MIB::ifindex");
//foreach ($sys as $key => $values) {
	//echo $key."<br>";
	//echo $sys[$key];

//}

/*3.6.1.2.1.16.19.4.0*/
/*
.iso.3.6.1.2.1.47.1.1.1.1.2.1 "Cisco Systems, Inc. WS-C4503-E 3 slot switch "
.iso.3.6.1.2.1.47.1.1.1.1.2.14®"Power Supply Fan Sensor"
.iso.3.6.1.2.1.47.1.1.1.1.7.1®"Switch System"
.iso.3.6.1.2.1.47.1.1.1.1.7.10®"Power Supply 1"
.iso.3.6.1.2.1.47.1.1.1.1.7.11®"Power Supply 1 Fan"
.iso.3.6.1.2.1.2.2.1.9.10150
.1.3.6.1.2.1.2.2.1.1 //interface

*/
?>
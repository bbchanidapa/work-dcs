<?php



?>

<?php
include("db.inc.php");
/*$select_device_text = "select * from device";
$result_device = mysql_query($select_device_text);
while ($array_device = mysql_fetch_array($result_device))
{*/
	
	$result_snmp_vlanindex = snmpwalk("10.9.99.1", 'public', '1.3.6.1.4.1.9.9.491.1.1.4.1.1.9');
	
	/*$arrayx = explode(": ",$result_snmp_vlanindex);*/
	/*$arrayy = explode(")",$arrayx[1]);*/
	print_r($result_snmp_vlanindex);

//}
?>
<?php
    $host   = array("10.77.4.1","10.77.1.2","10.77.6.2","10.77.3.2","10.77.4.2","10.77.5.2");
    $detail = array();
    $list   = array();

    foreach ($host as $key => $ip) { 
      	$get_sysName  = snmpget($ip,"public", ".1.3.6.1.2.1.1.1.0");
        $get_uptime   = snmpget($ip,"public", ".1.3.6.1.2.1.1.3.0");
        $get_cpuUsage = snmpget($ip,"public", ".1.3.6.1.4.1.9.9.109.1.1.1.1.5.1");
        $get_memUsage = snmpget($ip,"public", ".1.3.6.1.4.1.9.9.48.1.1.1.5.1");
        $get_temp     = snmp2_walk($ip,"public", ".1.3.6.1.4.1.9.9.13.1.3.1.3");
        $mem          = (substr($get_memUsage,9)/1048567);//MB

        echo  $get_cpuUsage."<br>";

        $detail['ip']     = $ip;
        $detail['ios']    = $get_sysName;
        $detail['uptime'] = substr($get_uptime,22);
        $detail['cpu']    = substr($get_cpuUsage,9);
        $detail['mem']    = number_format($mem,2).' MB';
        
        if($ip == "10.77.4.1" ){
            $detail['temp'] = substr($get_temp[1],9);
        }else{
            $detail['temp'] = substr($get_temp[0],9);
        }
        array_push($list,$detail);
    }

    $encode = json_encode($list);
    return $encode;
    print_r($detail);

?>






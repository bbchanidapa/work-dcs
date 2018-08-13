<?php
    $host = array("10.77.4.1","10.77.1.2","10.77.6.2","10.77.3.2","10.77.4.2","10.77.5.2");
    $list = array();
    ini_set('max_execution_time', 500); 
    foreach ($host as $key => $ip) { 
        $traffics[$ip] = array(
            'inbound'=>snmpwalkoid($ip, 'public', '.1.3.6.1.2.1.2.2.1.10'),
            'outbound' => snmpwalkoid($ip, 'public', '.1.3.6.1.2.1.2.2.1.16'),
            'interface' => snmpwalkoid($ip, 'public', '.1.3.6.1.2.1.2.2.1.2')
            
        );
    }
    //$txtOid = substr($oid,24);
    foreach ($traffics as $keyIP => $ip) {
        //echo $keyIP;
        foreach ($ip as $keyInOut => $interface) {
            //echo $keyInOut;
            foreach ($interface as $key => $InOut) {
                //echo $InOut;
                $str = ((substr($InOut,10)/1048576));
                if($keyInOut == 'interface'){
                    $list[$keyIP][$keyInOut][substr($key,23)] = $InOut;
                }else{
                    $list[$keyIP][$keyInOut][substr($key,24)] = number_format($str,2);
                }
                
            }//echo "<hr>";
        }
    }

   // print_r($list);
    //print_r($traffics);
    $encode = json_encode($list);
    return $encode;
?>
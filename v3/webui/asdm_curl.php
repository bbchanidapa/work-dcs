<?php


/*$url = 'https://10.9.99.1:444/admin/asdm_handler';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
curl_setopt($ch, CURLOPT_USERPWD, "" . ":" . "network");  
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RANGE, '0-1');
curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$data = curl_exec($ch);
curl_close($ch);

echo $data;*/

function read_body($ch, $string) {
    //Any new line that comes in appears on $string.  Handle it here.
    $length=strlen($string);
    echo $string;
    return $length; //Return the number of bytes that were handled.  Anything other than the length that was sent, and cURL will error out.
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
curl_setopt($ch, CURLOPT_URL, 'https://10.9.99.1:444/admin/asdm_handler');
curl_setopt($ch, CURLOPT_USERPWD, "" . ":" . "network");  
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
curl_setopt($ch, CURLOPT_WRITEFUNCTION, 'read_body');
curl_setopt($ch, CURLOPT_TIMEOUT_MS, 1000);
$result = curl_exec($ch);

curl_close($ch);


//$array_string = explode("METRICS_INFO",$connstring);
//echo $connstring;


?>
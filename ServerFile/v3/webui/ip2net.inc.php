
<?php


function ip2net($ip,$subnet)
{ //Dotted quad mask?

    //$dqs=explode(" ", $my_net_info);
	$dq_host=$ip; //$dqs[0];
	$bin_nmask=dqtobin($subnet);//dqtobin($dqs[1]);
	$bin_wmask=binnmtowm($bin_nmask);
	if (preg_match("/0/",rtrim($bin_nmask, "0"))) {  //Wildcard mask then? hmm?
		$bin_wmask=dqtobin($subnet);
		$bin_nmask=binwmtonm($bin_wmask);
		if (preg_match("/0/",rtrim($bin_nmask, "0"))){ //If it's not wcard, whussup?
			tr("Invalid Netmask.");
			print "$end";
			exit ;
		}
	}
	$cdr_nmask=bintocdr($bin_nmask);

$bin_host=dqtobin($dq_host);
$bin_net=(str_pad(substr($bin_host,0,$cdr_nmask),32,0));

return bintodq($bin_net)."/".$cdr_nmask;

}

function binnmtowm($binin){
	$binin=rtrim($binin, "0");
	if (!preg_match("/0/",$binin) ){
		return str_pad(str_replace("1","0",$binin), 32, "1");
	} else return "1010101010101010101010101010101010101010";
}

function bintocdr ($binin){
	return strlen(rtrim($binin,"0"));
}

function bintodq ($binin) {
	if ($binin=="N/A") return $binin;
	$binin=explode(".", chunk_split($binin,8,"."));
	for ($i=0; $i<4 ; $i++) {
		$dq[$i]=bindec($binin[$i]);
	}
        return implode(".",$dq) ;
}


function binwmtonm($binin){
	$binin=rtrim($binin, "1");
	if (!ereg("1",$binin)){
		return str_pad(str_replace("0","1",$binin), 32, "0");
	} else return "1010101010101010101010101010101010101010";
}

function cdrtobin ($cdrin){
	return str_pad(str_pad("", $cdrin, "1"), 32, "0");
}



function dqtobin($dqin) {
        $dq = explode(".",$dqin);
        for ($i=0; $i<4 ; $i++) {
           $bin[$i]=str_pad(decbin($dq[$i]), 8, "0", STR_PAD_LEFT);
        }
        return implode("",$bin);
}



?>

<?php
$img_number = imagecreate(275,25);
$backcolor = imagecolorallocate($img_number,102,102,153);
$textcolor = imagecolorallocate($img_number,255,255,255);

imagefill($img_number,0,0,$backcolor);
$number = " Your IP is $_SERVER[REMOTE_ADDR]";

Imagestring($img_number,10,5,5,$number,$textcolor);

header("Content-type: image/jpeg");
imagejpeg($img_number);

?>
<img src="http://mysite.com/image.php" border="1">
<html>
<head>
	<title></title>
</head>
<body>

<?php 
   /* if (getenv(HTTP_X_FORWARDED_FOR)) 
        $ip=getenv(HTTP_X_FORWARDED_FOR); 
    else 
        $ip=getenv(REMOTE_ADDR); 

    print "Your IP Address is $ip"."<br>"; 

  
    $ipUser = $ip; 
    $host = gethostbyaddr($ipUser); 
    print "Host name for $ipUser is $host"; */
?> 

<?php 
    /*if (getenv(HTTP_X_FORWARDED_FOR)) 
        $ip=getenv(HTTP_X_FORWARDED_FOR); 
    else 
        $ip=getenv(REMOTE_ADDR); 

    echo "Your IP Address is $ip"."<br>"; 
    $host = gethostbyaddr($ip); 
    echo "Host name for $ip is $host";*/
?>
</body>
</html>
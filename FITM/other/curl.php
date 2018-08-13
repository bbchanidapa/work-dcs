<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="//code.jquery.com/jquery.min.js"></script>
	<script>
		//$(document).ready(function(){
			setInterval(function() {
			      //$('#content').load('t1.php');
			     var txt = "<span>bb</span>"
			     $('#content').append(txt);
			}, 2000);
		//});
	</script>
</head>
<body>
<div id="content"></div>
</body>
</html>

<?php
/*function setInterval($func = null, $interval = 0, $times = 0){
	  if( ($func == null) || (!function_exists($func)) ){
	    throw new Exception('We need a valid function.');
	  }
	  $seconds = $interval * 1000;
	  if($times > 0){	    
	    $i = 0;    
	    while($i < $times){
	        call_user_func($func);
	        $i++;
	        usleep( $seconds );
	    }
	  } else {	    
	    while(true){
	        call_user_func($func); // Call the function you've defined.
	        usleep( $seconds );
	    }
	  }
}

function doit(){
  	print 'done!<br>';
}


setInterval('doit', 5000); // Invoke every five seconds, until user aborts script.
setInterval('doit', 1000, 100); // Invoke every second, up to 100 times.*/
?>
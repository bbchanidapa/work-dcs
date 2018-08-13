<?
 	@session_start();
 	include('connect.php');
 	date_default_timezone_set('Asia/Bangkok');					
	if (!$_SESSION['username']) {
			echo "<SCRIPT LANGUAGE='JavaScript'>
       window.location.href='index.php';
        </SCRIPT>";
	}
	else {
		 
		if ($_SESSION['username'] == 'admin') {
		  echo "<SCRIPT LANGUAGE='JavaScript'>
       window.location.href='admin.php';
        </SCRIPT>";			
		}else{
			if(!empty($_POST["submit"])) {
	 		
			    $date_bor = date("d-M-Y H:i:s: a");
			    $date_return = "null";
				$price = 50;
				$username = $_SESSION['username'];
	 			$id_movie = $_SESSION['id_movie'];
                $pay = "no";
                
				$sql = "insert into borrow values (null,'$date_bor','$date_return','$price','$id_movie','$username','$pay')"; 
				$query = mysql_query($sql);
				
				if (!$query) {
					$message = "!!!!!!!!!!!!";
							echo "<script type='text/javascript'>alert('$message');</script>";
					?><script>
						window.location = 'member.php';
					</script><?	
							
				}//if
				else{ // count borrow
				
					$_SESSION['count_movie'] = $_SESSION['count_movie']+1;
					$_SESSION['total'] = $_SESSION['total']+50; 			
					?><script>
						window.location = 'member.php';
					</script><?	
				}
			
	    }//if
	}
}

?>
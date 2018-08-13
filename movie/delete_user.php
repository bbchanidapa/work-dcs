<?	
    session_start();
	include('connect.php');
	if ($_SESSION['admin'] !="yes"){
			echo "<SCRIPT LANGUAGE='JavaScript'>
						   window.location.href='member.php';
						  </SCRIPT>";
	}else{
		$delete = "DELETE FROM customer WHERE username = '".$_GET['del']."'";
		$query = mysql_query($delete);
		
		}
?>
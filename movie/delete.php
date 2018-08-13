<?	
    session_start();
	include('connect.php');
	if ($_SESSION['admin'] !="yes"){
			echo "<SCRIPT LANGUAGE='JavaScript'>
						   window.location.href='member.php';
						  </SCRIPT>";
	}else{
		$delete = "DELETE FROM movie WHERE id_movie = ".$_GET['id'];
		$query = mysql_query($delete);
		echo "<SCRIPT LANGUAGE='JavaScript'>
						   window.location.href='admin.php';
						  </SCRIPT>";
		}
?>
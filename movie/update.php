<?	
	@session_start();
	include('connect.php');

	if ("yes" != $_SESSION['admin']) {
			header("location:member.php");
	}else{
			$sql = "SELECT * FROM movie WHERE id_movie = '".$_GET['id']."' ";
			$query = mysql_query($sql);
			$result = mysql_fetch_array($query);

			$id = $result['id_movie'];
			$name = $result['name_movie'];
			$time = $result['time_movie'];
			$img = $result['image'];
			$detail = $result['detail'];
			include('navbar.php');
		}
?>
<title>Update</title> 
<nav>
		<div class="nav-wrapper blue-grey darken-1">
		      <a href="#!" class="brand-logo center">DooDee</a>
		      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
		      <ul class="left hide-on-med-and-down">
		        <li><a href="admin.php">My Admin</a></li>
		        <li><a href="insert.php">Insert</a></li>
		        <li><a href="return.php">Return</a></li>
		        <li><a href="logout.php">Logout</a></li>
		      </ul>
		      <ul class="side-nav" id="mobile-demo">
		        <li><a href="admin.php">My Admin</a></li>
		        <li><a href="insert.php">Insert</a></li>
		        <li><a href="return.php">Return</a></li>
		        <li><a href="logout.php">Logout</a></li>
		      </ul>

    	</div>

 	</nav>
	<script>
	      $('.button-collapse').sideNav({
	          menuWidth: 300, // Default is 240
	          edge: 'right', // Choose the horizontal origin
	          closeOnClick: true // Closes side-nav on <a> clicks, useful for Angular/Meteor
	        }
	      );
		 $(document).ready(function(){
	      $('.parallax').parallax();
	   	  $('.collapsible').collapsible({
	      accordion : false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
	    });
	  });
	</script>
	 <style>
			.parallax-container {
		      height: "your height here";
		    }
			html { font-family: GillSans, Calibri, Trebuchet, sans-serif;}  

	</style>

<div class="section white">
    <div class="row container">
      		<h2 class="header">Edit Table Movie</h2>
      <p class="grey-text text-darken-3 lighten-3">

			<form method="POST">
				<div class="container">
						<input type="hidden" name="ID" value="<?echo $id;?>">
				 <div class="row">
					  <form class="col s9 m6"><!--form set col-->
					    
					    <div class="row">
					        <div class="input-field col s6 m6">
					          <input name="NAME"  type="text" class="validate" value="<?echo $name;?>">
					          <label for="name">ชื่อหนัง</label>
					        </div>
					     </div>
					     <div class="row">
					        <div class="input-field col s6 m6">
					          <input name="TIME" type="text" class="validate" value="<?echo $time;?>">
					          <label for="time">ความยาวของหนัง</label>
					     	</div>
					     </div>
					     <div class="row">
					        <div class="input-field col s6 m6 ">
					          <input name="IMG" type="text" class="validate"disabled value="<?echo $img;?>">
					          <label for="img">รูปภาพ</label>
					        </div>
					     </div>
						<div class="row">
					        <div class="input-field col s6 m6 l">
					          <input name="DETAIL" type="text" class="validate" value="<?echo $detail;?>">
					          <label for="detail">รายละเอียด</label>
					        </div>
					     </div>

					</form><!--form set col-->
					<button class="btn waves-effect waves-light blue-grey darken-1" type="submit" name="submit" value="SUBMIT">Confirm
		    		<i class="material-icons right">send</i>
		  			</button>
				</div><!--row-->
				</div><!--Container-->
			</form><!--POST-->

		</p><!--Tag a-->
    </div>
  </div>

	  <div class="parallax-container">
	    <div class="parallax"><img src="img/bgf.jpg"></div>
	  </div>
	
</body>
</himl>
<?	

if ($_POST['submit'] == 'SUBMIT') {
	
	include('connect.php');
	$update = "UPDATE movie SET name_movie = '".$_POST['NAME']."', time_movie = '".$_POST['TIME']."' , detail = '".$_POST['DETAIL']."' WHERE id_movie = '".$_POST['ID']."'";
	$query = mysql_query($update);
	echo "<SCRIPT LANGUAGE='JavaScript'>
					   window.location.href='admin.php';
					  </SCRIPT>";
}

?>
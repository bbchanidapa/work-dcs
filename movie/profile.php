<?
      @session_start();
      	  
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

      	include('connect.php');
      	$user = $_SESSION['username'];
      		$sql= "SELECT * FROM customer WHERE username = '".$user."' ";
      		$query = mysql_query($sql);
			$result = mysql_fetch_array($query);

      		$name  = $result['name'];
			$surname  = $result['surname'];
			$mail  = $result['mail'];
			$tel  = $result['tel'];
			$username  = $result['username'];
			$password  = $result['password'];
			$conpass = $result['conpass'];
      }		
   }
         include('navbar.php');
?>
<title>MyProfile</title> 
<nav>
		<div class="nav-wrapper blue-grey darken-1">
		      <a href="#!" class="brand-logo center">DooDee</a>
		      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
		      <ul class="left hide-on-med-and-down">
		         <li><a href="member.php">Home</a></li>
		         <li><a href="profile.php">My Profile</a></li>
		         <li><a href="history_pay.php">History Rent</a></li>
		         <li><a href="logout.php">Logout</a></li>

		      </ul>
		      <ul class="side-nav" id="mobile-demo">
		        <li><a href="member.php">Home</a></li>
		        <li><a href="profile.php">My Profile</a></li>
		        <li><a href="history_pay.php">History Rent</a></li>
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
	</style>

  <div class="section white">
    <div class="row container">
      <h2 class="header">Profile
<?echo "<a href= 'update_profile.php?user=".$result['username']." ' class='btn-floating btn-large waves-effect waves-light red right'><i class='material-icons'>mode_edit</i></a>" ?>

      </h2>     
      <p class="grey-text text-darken-3 lighten-3">
			<table>
			<tr>
				<td><h5 class="text"><b>Fist Name :</b> <?echo $result['name']?></h5></td>
			    <td><h5 class="text"><b>Last Name :</b> <?echo $result['surname']?></h5></td>
			</tr>
			<tr>
				<td><h5 class="text"><b>E-mail :</b> <?echo $result['mail']?></h5></td>
			    <td><h5 class="text"><b>Tel :</b> <?echo $result['tel']?></h5></td>
			</tr>
			<tr>
				<td><h5 class="text" ><b>Username :</b> <?echo $result['username']?></h5></td>
				<td><?echo "<a href= 'change_password.php?user=". $result['username']." ' class='waves-effect waves-teal btn-flat blue-grey-text'>Change Password</a>" ?>
				
			</tr>
			
			</table>
	  </p><!--Tag a-->
    </div>
  </div>

	  <div class="parallax-container">
	    <div class="parallax"><img src="img/bgf.jpg"></div>
	  </div>
	
</body>
</html>

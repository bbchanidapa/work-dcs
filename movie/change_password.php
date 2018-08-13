<?
 @session_start();
  include('connect.php');	
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
     $id = $_GET['user']; 
      if (!$_SESSION['username']) {
      header("location:login.php");
      }else{
     $sql = "SELECT * FROM customer WHERE username = '".$id."'";
	        $query = mysql_query($sql);
	        $result = mysql_fetch_array($query);
	        $password  = $result['password'];
			$pass  = $_POST['password'];
			$newpass  = $_POST['newpass'];
			$conpass = $_POST['conpass'];
		   }
	}
}	
	include('navbar.php');		
?>
<title>Edit MyProfile</title> 
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
      <h2 class="header">Change Password</h2>
      <p class="grey-text text-darken-3 lighten-3">

	      <form method="POST" action="#">
			<div class="container">
				<div class="row">
					<form class="col s12">
				
				 <div class="row">
			        <div class="input-field col s6">
			          <input name="password" type="password" class="validate">
			          <label for="password">Password</label>
			        </div> 
			    </div>
			    <div class="row">
			        <div class="input-field col s6">
			          <input name="newpass" type="password" class="validate">
			          <label for="newpass">New Password</label>
			        </div> 
			    </div>
			    <div class="row">
			        <div class="input-field col s6">
			          <input name="conpass" type="password" class="validate">
			          <label for="conpass">Confirm Password</label>
			        </div>
			    </div>

				<button class="btn waves-effect waves-light blue-grey darken-1" type="submit" name="submit" value="conpass">Confirm
		  		</button>
					</form><!--form col-->
				</div><!--row-->
			  </div><!--container-->
		  </form><!--form POST-->
	    </p><!--Tag a-->
    </div>
  </div>

	  <div class="parallax-container">
	    <div class="parallax"><img src="img/bgf.jpg"></div>
	  </div>
	
</body>
</html>
<?
   	
	if($_POST["submit"] == 'conpass'){
			include('connect.php');
					
			if(!$password || !$conpass){	
				$message = "กรุณากรอกข้อมูลให้ครบ โปรดตรวจสอบอีกครั้ง";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}else{	
				    if (($password != $pass) == 1) {
						$message = "กรุณาตรวจสอบรหัสผ่านอีกครั้ง";
				        echo "<script type='text/javascript'>alert('$message');</script>";
					}	
					else if (($conpass != $newpass)  == 1) {
						$message = "ยืนยันรหัสผ่านอีกครั้ง";
						echo "<script type='text/javascript'>alert('$message');</script>";
					}
					else {

$sql  = "UPDATE customer SET password= '$newpass'  WHERE username = '".$id."' ";
						$query = mysql_query($sql);	
						if ($query) {
							$message = "Change Password Successful";
						echo "<script type='text/javascript'>alert('$message');</script>";
						?><script type="text/javascript">
								window.location = 'profile.php';
							</script><?			
						}
						else{
							$message = "Username นี้มีคนใช้ไปแล้วกรุณาใส่ใหม่";
						echo "<script type='text/javascript'>alert('$message');</script>";
						}
				
					}//else
			}//else 
			}//if นอก
		
?>
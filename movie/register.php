<?
@session_start();
include('connect.php');
		if(!empty($_POST["submit"])){
			$name  = $_POST['name'];
			$surname  = $_POST['surname'];
			$mail  = $_POST['mail'];
			$tel  = $_POST['tel'];
			$username  = $_POST['username'];
			$password  = $_POST['password'];
			$conpass = $_POST['conpass'];
				
			if(!$name || !$surname || !$mail || !$tel || !$username || !$password ){
				
				$message = "กรุณากรอกข้อมูลให้ครบ โปรดตรวจสอบอีกครั้ง";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}else{
				    if (($conpass != $password)  == 1) {
						$message = "กรุณาตรวจสอบรหัสผ่านอีกครั้ง";
						echo "<script type='text/javascript'>alert('$message');</script>";
				
					}
					else {
						$sql  = "insert into customer values('$name','$surname','$mail','$tel','$username','$password')";
						$query = mysql_query($sql);	
						if ($query) {
						?><script type="text/javascript">
								window.location = 'login.php';
							</script><?			
						}
						else{
							$message = "Username นี้มีคนใช้ไปแล้วกรุณาใส่ใหม่";
						echo "<script type='text/javascript'>alert('$message');</script>";
						}
				
					}//else
			}//else 
			}//if นอก

include('navbar.php');
?>	
<title>Register</title> 
<nav>
		<div class="nav-wrapper blue-grey darken-1">
		      <a href="#!" class="brand-logo center">DooDee</a>
		      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
		      <ul class="left hide-on-med-and-down">
		        <li><a href="member.php">Home</a></li>
		        <li><a href="login.php">Login</a></li>
		      </ul>
		      <ul class="side-nav" id="mobile-demo">
		        <li><a href="member.php">Home</a></li>
		        <li><a href="login.php">Login</a></li>
		      </ul>
	
		      <form>
		        <div class="input-field right ">
		          <input id="search" type="search" required>
		          <label for="search"><i class="material-icons">search</i></label>
		          <i class="material-icons">close</i>
		        </div>
		      </form>

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
      <h2 class="header">Regester</h2>
      <p class="grey-text text-darken-3 lighten-3">

	      <form method="POST" action="#">
			<div class="container">
				<div class="row">
					<form class="col s12">
					
				<div class="row">
			        <div class="input-field col s3">
			          <input name="name" type="text" class="validate">
			          <label for="name">Fist name</label>
			        </div>
			        <div class="input-field col s3">
			          <input name="surname" type="text" class="validate">
			          <label for="surname">Last name</label>
			        </div>
			    </div>
			    <div class="row">
			        <div class="input-field col s6">
			          <input name="mail" type="text" class="validate">
			          <label for="mail">E-Mail</label>
			        </div>
			    </div>
			    <div class="row">
			        <div class="input-field col s6">
			          <input name="tel" type="text" length="10" class="validate">
			          <label for="tel">Tel</label>
			        </div>
			        <script>
			        	$(document).ready(function() {
    $('input#input_text, textarea#textarea1').characterCounter();
  });
       
			        </script>
			    </div>
			    <div class="row">
			        <div class="input-field col s6">
			          <input name="username" type="text" class="validate">
			          <label for="username">Username</label>
			        </div> 
			    </div>
			    <div class="row">
			        <div class="input-field col s6">
			          <input name="password" type="password" class="validate">
			          <label for="password">Password</label>
			        </div>
			    </div>
			    <div class="row">
			        <div class="input-field col s6">
			          <input name="conpass" type="password" class="validate">
			          <label for="conpass">Confirm Password</label>
			        </div>
			    </div>

				<button class="btn waves-effect waves-light blue-grey darken-1" type="submit" name="submit" value="submit">Confirm
		    		<i class="material-icons right">send</i>
		  		</button>
				<button class="btn waves-effect waves-light blue-grey darken-1" type="submit" name="reset" value="Cancel">Cancel
			    	<i class="material-icons right">send</i>
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

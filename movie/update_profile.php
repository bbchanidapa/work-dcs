<?
session_start();
include('connect.php');

$id = $_GET['user'];
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
	$sql = "SELECT * FROM customer WHERE username = '".$id."'";
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
      <h2 class="header">My Profile</h2>
      <p class="grey-text text-darken-3 lighten-3">

	      <form method="POST" action="#">
			<div class="container">
				<div class="row">
					<form class="col s12">
					
				<div class="row">
			        <div class="input-field col s3">
			          <input name="name" type="text" class="validate" value="<?echo $name;?>">
			          <label for="name">Fist name</label>
			        </div>
			        <div class="input-field col s3">
			          <input name="surname" type="text" class="validate" value="<?echo $surname;?>">
			          <label for="surname">Last name</label>
			        </div>
			    </div>
			    <div class="row">
			        <div class="input-field col s6">
			          <input name="mail" type="text" class="validate" value="<?echo $mail;?>">
			          <label for="mail">E-Mail</label>
			        </div>
			    </div>
			    <div class="row">
			        <div class="input-field col s6">
			          <input name="tel" type="text" length="10" class="validate" value="<?echo $tel;?>">
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
			          <input name="username" type="text" class="validate" value="<?echo $username;?>" disabled>
			          <label for="username">Username</label>
			        </div> 
			    </div>
			          <input name="password" type="hidden" class="validate" value="<? echo $password;?>">
			    <div class="row">
			        <div class="input-field col s6">
			          <input name="conpass" type="password" class="validate">
			          <label for="conpass">Password</label>
			        </div>
			    </div>

				<button class="btn waves-effect waves-light blue-grey darken-1" type="submit" name="submit" value="profile">Confirm
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
<?
		if(!empty($_POST["submit"])){
			include('connect.php');
			$name  = $_POST['name'];
			$surname  = $_POST['surname'];
			$mail  = $_POST['mail'];
			$tel  = $_POST['tel'];
			$username  = $result['username'];
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

$sql  = "UPDATE customer SET name= '$name' , surname= '$surname' , mail= '$mail' , tel='$tel', username='$username', password= '$password'  WHERE username = '".$id."' ";
						$query = mysql_query($sql);	
						if ($query) {
							$message = "Update myprofile Successful";
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

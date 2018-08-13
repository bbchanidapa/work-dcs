<?
	session_start();
	include("connect.php");

	 if ($_POST['submit'] == 'ok'){
	 	
	 	$user = $_POST['username'];
	 	$pass = $_POST['password'];  
	
		$sql = "SELECT * FROM customer WHERE username = '".$_POST['username']."' and password = '".$_POST['password']."' ";
		$query = mysql_query($sql);
		$result = mysql_fetch_array($query);
		if ("admin"==$user && "1234"==$pass) {
			$_SESSION['username'] = "admin";
			$_SESSION['admin'] = "yes";
			header("location:admin.php");
		}
		else if($user == $result['username']) {
			$_SESSION['username'] = $user;
			echo "<SCRIPT LANGUAGE='JavaScript'>
			 window.location.href='member.php';
				</SCRIPT>";
		}
			
	}//if นอก

?>
<html>
<head>

	<title>Login</title>  
	<meta charset="UTF-8">
	 <!-- script ของ jquery -->
	  <script src="//code.jquery.com/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
	 <!-- Compiled and minified CSS -->
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/css/materialize.min.css">

	  <!-- Compiled and minified JavaScript -->
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script>
     <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/> 
      <!--Import Google Icon Font-->
      <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

    <style>
		html { font-family: GillSans, Calibri, Trebuchet, sans-serif;}  
    </style>
</head>
<body>

<nav>
		<div class="nav-wrapper blue-grey darken-1">
		      <a href="#!" class="brand-logo center">DooDee</a>
		      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
		      <ul class="left hide-on-med-and-down">
		        <li><a href="index.php">Home</a></li>
		        
		      </ul>
		      <ul class="side-nav" id="mobile-demo">
		        <li><a href="#">Home</a></li>
		    
		      </ul>
	
    	</div>

 </nav>
 
 
  </script>
          <script>
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


<div class="parallax-container">
      <div class="parallax"></div> 

		 
<div class="row"><!-- Page Layout here -->
			<!-- Note that "m4 l3" was added -->
		      <div class="col s12 m3 l4 hide-on-small-only">
		           <span class="card-title white-text">
		           .
		            </span>
		      </div>

		     <!-- Note that "m4 l3" was added -->
			 <div class="col s12 m6 l4">
		            <br><br><br><br><br><br>
			         <div class="card-panel blue-grey darken-1">
			          <span class="white-text">
				          <form method="post" action="#">

						        <div class="input-field col s4 m12">
						          <input name="username" id="username" type="text" class="validate">
						          <label for="username">Username</label>
						        </div>


						      <div class="row">
						        <div class="input-field col s4 m12">
						          <input name="password" id="password" type="password" class="validate">
						          <label for="password">Password</label>
						        </div>
						      </div>

						      <button class="btn waves-effect waves-light" type="submit" name="submit" value="ok">Submit
					    		<i class="material-icons right">send</i>
					  		  </button>

							  <a href="register.php" class="waves-effect waves-teal btn-flat white-text">Register</a> 
						</form><!--form #-->
			          </span>
			          </div>
		   	 </div><!-- Note that "m4 l3" was added -->
		      

		      <!-- Note that "m8 l9" was added -->
		      <div class="col s12 m3 l4 "> 
		     			<span class="card-title white-text"></span>
		      </div>


</div><!-- Page Layout here -->

</div><!--parallax-->
  <div class="parallax-container">
    <div class="parallax"><img src="img/bgf.jpg"></div>
  </div>
</body>
</html>

      <script>
		  $('.button-collapse').sideNav({
		      menuWidth: 300, // Default is 240
		      edge: 'right', // Choose the horizontal origin
		      closeOnClick: true // Closes side-nav on <a> clicks, useful for Angular/Meteor
		    }
		  );
		  	  
	  </script>
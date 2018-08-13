<?
	@session_start();
	include("connect.php");

	if (!$_SESSION['username']) {
		echo "<SCRIPT LANGUAGE='JavaScript'>
			 window.location.href='login.php';
				</SCRIPT>";
	}
	else if($_SESSION['admin']!='yes'){
		echo "<SCRIPT LANGUAGE='JavaScript'>
			 window.location.href='member.php';
				</SCRIPT>";
	}else{

		if($_POST['submit'] == 'insert'){
			$name_movie = $_POST["name_movie"];
			$time_movie = $_POST["time_movie"];
			$image = $_POST["image"];
			$detail = $_POST["detail"];

			$imgData = $_FILES['image']['name'];
			if(copy($_FILES['image']['tmp_name'],"img/".$_FILES['image']['name'])){

			$sql = "insert into movie values (null,'$name_movie','$time_movie','$imgData','$detail')"; 
			$query = mysql_query($sql);

			if ($query) {
				$message = "Insert Successful";
				echo "<script type='text/javascript'>alert('$message');</script>";
				echo "<SCRIPT LANGUAGE='JavaScript'>
					   window.location.href='admin.php';
					  </SCRIPT>";
				}
			}//if

		}//if
	}//slse
?>
<html>
<head>

	<title>Insert</title>  
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
		        <li><a href="admin.php">My Admin</a></li>
		        <li><a href="#">Insert</a></li>
		        <li><a href="return.php">Return</a></li>
		        <li><a href="sql.php">Customer</a></li>
		        <li><a href="logout.php">Logout</a></li>
		      </ul>
		      <ul class="side-nav" id="mobile-demo">
		       <li><a href="admin.php">My Admin</a></li>
		        <li><a href="#">Insert</a></li>
		        <li><a href="return.php">Return</a></li>
		        <li><a href="sql.php">Customer</a></li>
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
 <div class="parallax"><img src="img/bg.jpg"></div> 
	   <div class="row">
		  <div class="col s12 m3 l2">
		    <ul class="collection">
			<li class="collection-item avatar">
		    <img src="img-index/icon.png" alt="" class="circle">
			<span class="title"><?echo $_SESSION['username'];?></span>
			<p>Status : <?echo $_SESSION['admin'];?></p>
			<a href="#!" class="secondary-content"><i class="material-icons amber-text">grade</i></a>
			</li>
		    </ul>
		  </div>
		</div><!--row-->
  </div>
 
	<form method="post" action="#" enctype="multipart/form-data">
	<div class="row container">
	<h2 class="header">Insert movie</h2>
			<form class="col s12 m6">
				<div class="row">
			        <div class="input-field col s6">
			          <input name="name_movie" type="text" class="validate">
			          <label for="name_movie">ชื่อภาพยนต์ </label>
			        </div>

			    </div>
				<div class="row">
			        <div class="input-field col s6">
			          <input name="time_movie" type="text" class="validate">
			          <label for="time_movie">ความยาวของเวลา </label>
			        </div>
			    </div>
			    <div class="row">
				   <div class="input-field col s6">
				    <div class="file-field input-field">
					   <div class="file-field input-field">
					      <div class="btn">
					        <span>File</span>
					        <input name="image" type="file">
					      </div>
					      <div class="file-path-wrapper">
					        <input class="file-path validate" type="text">
					      </div>
					    </div>
				    </div> 
				  </div>
			    </div>
				<div class="row">
			        <div class="input-field col s6">
			          <textarea name="detail" id="textarea1" class="materialize-textarea"></textarea>
	          <label for="textarea1">รายละเอียด</label>
			        </div>
			    </div>

				<button class="btn waves-effect waves-light blue-grey darken-1" type="submit" name="submit" value="insert">Confirm
		    		<i class="material-icons right">send</i>
		  		</button>
				<button class="btn waves-effect waves-lightv blue-grey darken-1" type="submit" name="reset" value="Cancel">Cancel
			    	<i class="material-icons right">send</i>
		  		</button>

			</form>
		    </div><!--Row-->
		  
	</form>
   
</div><!--parallax-->
  <div class="parallax-container">
    <div class="parallax"><img src="img/bgf.jpg"></div>
  </div>
</body>
</html>


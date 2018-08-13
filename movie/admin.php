<?
@session_start();
include('connect.php');
    if (!$_SESSION['username']) {
			header("location:index.php");
	}
	else {

		if ($_SESSION['username'] != 'admin') {
		echo "<SCRIPT LANGUAGE='JavaScript'>
       window.location.href='member.php';
        </SCRIPT>";
		}else{

			$sql = "SELECT * FROM movie ";
			$query = mysql_query($sql);
		}

	}
	include('navbar.php');
?>
<html>
<head>

	<title>my admin</title>  
	
    <style>
		html { font-family: GillSans, Calibri, Trebuchet, sans-serif;}  
	nav { font-family: GillSans, Calibri, Trebuchet, sans-serif;} 
    </style>
</head>
<body>
<nav>
		<div class="nav-wrapper blue-grey darken-1">
		      <a href="#!" class="brand-logo center">DooDee</a>
		      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
		      <ul class="left hide-on-med-and-down">
		        <li><a href="#">My Admin</a></li>
		        <li><a href="insert.php">Insert</a></li>
		        <li><a href="return.php">Return</a></li>
		        <li><a href="sql.php">Customer</a></li>
		        <li><a href="manage_user.php">Manage</a></li>
		        <li><a href="logout.php">Logout</a></li>
		      </ul>
		      <ul class="side-nav" id="mobile-demo">
		        <li><a href="admin.php">My Admin</a></li>
		        <li><a href="insert.php">Insert</a></li>
		        <li><a href="return.php">Return</a></li>
		        <li><a href="sql.php">Customer</a></li>
		        <li><a href="manage_user.php">Manage</a></li>
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
	      accordion : false
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
	     <div class="col s12 m4 l2">
			<ul class="collection">
			<li class="collection-item avatar">
		    <img src="img-index/icon.png" alt="" class="circle">
			<span class="title"><?echo $_SESSION['username'];?></span>
			<p>Status : <?echo $_SESSION['admin'];?></p>
			<a href="#!" class="secondary-content"><i class="material-icons amber-text">grade</i></a>
			</li>
		    </ul>
		 </div>
		
	</div>
</div><!--parallax-->

<div class="container">
 <div class="row ">
 <h2 class="header">The Movie</h2>
		<?while ($result = mysql_fetch_array($query)) {
				$result['id_movie'];
			?>
			  <div class="col s12 m4 l2">
					<div class="card small">
					    
					    <div class="card-image waves-effect waves-block waves-light">
					      <img class="activator "src="img/<? echo 
					      $result['image'];?>">
					    </div>

					    <div class="card-content">
					      <span class="card-title activator grey-text text-darken-4"><?echo $result['name_movie'];?><i class="material-icons right">more_vert</i></span>
					    </div>
					    <div class="card-reveal">
					      <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
					      <p>Time: <?echo $result['time_movie'];?></p><br>
					      <p><?echo $result['detail'];?></p>
					    </div>
					    <div class="card-action right-align">
				        <?echo "<a href= 'update.php?id=".$result['id_movie']." '>Edit</a>" ?>
				        <?echo "<a href= 'delete.php?id=".$result['id_movie']." '>del</a>" ?>
				        
		                </div>
				    </div>	
			  </div>
		<?}?>
		<a href="insert.php" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
</div>
</div>

	  <div class="parallax-container">
	    <div class="parallax"><img src="img/bgf.jpg"></div>
	  </div>

</body>
</html>


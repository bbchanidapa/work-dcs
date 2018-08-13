<?
		session_start();
		include('connect.php');

    if ($_SESSION['username'] == 'admin') {
      echo "<SCRIPT LANGUAGE='JavaScript'>
       window.location.href='admin.php';
        </SCRIPT>";
    }else
			$sql = "SELECT * FROM movie ";
			$query = mysql_query($sql);
?>
<html>
<head>
	<title>Home</title>
	<meta charset="UTF-8">
	 <!-- script jquery -->
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
		        <li><a href="#">Home</a></li>
		        <li><a href="login.php">Login</a></li>
		      </ul>
		      <ul class="side-nav" id="mobile-demo">
		        <li><a href="#">Home</a></li>
		        <li><a href="login.php">Login</a></li>
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
	<script>
		 $(document).ready(function(){
	      $('.carousel').carousel();
	    });
		// Pause slider
		$('.slider').slider('pause');
		// Start slider
		$('.slider').slider('start');
		// Next slide
		$('.slider').slider('next');
		// Previous slide
		$('.slider').slider('prev');
	      
	</script>

  <div class="carousel">
    <a class="carousel-item" href="#one!"><img src="img-index/id-1.jpg"></a>
    <a class="carousel-item" href="#two!"><img src="img-index/id-2.jpg"></a>
    <a class="carousel-item" href="#three!"><img src="img-index/id-3.jpg"></a>
    <a class="carousel-item" href="#four!"><img src="img-index/id-4.jpg"></a>
    <a class="carousel-item" href="#five!"><img src="img-index/id-5.jpg"></a>
  </div>
	  </div><!--parallax-->

<div class="container">
 <div class="row">
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
				       <a href="login.php">Rent</a>
				        
		                </div>
				    </div>	
			  </div>
		<?}?>
</div>
</div>

	  <div class="parallax-container">
	    <div class="parallax"><img src="img/bgf.jpg"></div>
	  </div>

<!--
 		<br>	
 		<div class="container">
 			<table class="highlight">
 				<thead>
	 				<tr>
	 					<th>ID_MOVIE</th>
						<th>Name_Moive</th>
						<th>time_movie</th>
						<th>image</th>
						<th>detail</th>
	 				</tr>
	 			</thead>
 				<?
/* 				while ($result = mysql_fetch_array($query)) {
				echo "<tr>";
				echo "<th>".$result['id_movie']."</th>";
				echo "<td>".$result['name_movie']."</td>";
				echo "<td>".$result['time_movie']."</td>";
				echo "<td>".$result['image']."</td>";
				echo "<td>".$result['detail']."</td>";
				echo "</tr>";
*/
				
 				?>
 			</table>
		</div>
		-->}
</body>
</html>
 

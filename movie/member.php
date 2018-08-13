<!-- Link to update.php , delete.php -->
<?
    @session_start();
    	include('navbar.php');
	    include('script.php');					
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
			$sql = "SELECT * FROM movie ";
			$query = mysql_query($sql);
			
		}
	}

?>
<title>member</title> 
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
<div class="row">
		     <div class="col s3 m3 l2">
				 	 <ul class="collection">
					    <li class="collection-item avatar">
					      <img src="img-index/icon.png" alt="" class="circle">
					      <span class="title"><?echo $_SESSION['username'];?></span>
					      <p>movie : <?echo $_SESSION['count_movie']?> <br>
					      Total : <?echo $_SESSION['total']?>  
					      </p>
					      <a href="pay.php" class="secondary-content"><i class="material-icons">payment</i></a>
					    </li>
					    </ul>
			 </div>
			</div>
  </div><!--parallax-->

 <div class="container">
 <div class="row">
 <h2 class="header">The Movie</h2>

		<?while($result = mysql_fetch_array($query)) {?>
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
					    <div class="card-action ">
				        <?echo "<a href= 'borrow.php?id=".$result['id_movie']." '>Rent</a>" ?>
		                </div>
				    </div>	
			  </div>
		<?}?>
</div>
</div>
  <div class="parallax-container">
    <div class="parallax"><img src="img/bgf.jpg"></div>
  </div>


</body>
</html>





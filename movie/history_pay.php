<?
	session_start();
           
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
      		$id_user = $_SESSION['username'];

      		$sql = "SELECT br.username,mv.image,mv.name_movie,br.price,br.pay,br.date_bor,br.date_return FROM borrow br JOIN movie mv  ON mv.id_movie = br.id_movie WHERE username = '".$id_user."'";
      		$query = mysql_query($sql); 
      }
    }
      include('navbar.php');
      include('script.php');
?><style type="text/css">
  html {
    font-family: GillSans, Calibri, Trebuchet, sans-serif;
  }
  h2 {
    font-family: Extra-Light 200 ;
  }
</style>

<title>Payment</title> 
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

 <div class="container">
   <div class="row">
       <h2 class="header">ประวัติการยืม</h2>
         
          <?while($result = mysql_fetch_array($query)) {?>
             <div class="col s12 m4 l3">
                <div class="card Medium">
                  <div class="card-image ">
                    <img src="img/<? echo 
                      $result['image'];?>">
                  </div>
                  <div class="card-content">   
                     <h5><?echo $result['name_movie'];?></h5><br>
                     <p><b>Date :</b> <?echo $result['date_bor'];?>
                     <br><b>Price :</b> <?echo $result['price'];?>฿
					<br><b>Pay :</b> <?echo $result['pay'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<b>Return :</b> <?echo $result['date_return'];?>
                     </p>

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
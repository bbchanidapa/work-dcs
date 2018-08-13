<?
	@session_start();
	date_default_timezone_set('Asia/Bangkok');
	include('connect.php');
	if ($_GET['submit'] == 'return') {
		
      
		$sql = "SELECT * FROM borrow WHERE id_bor = '".$_GET['id_bor']."' and id_movie = '".$_GET['id_movie']."' ";
		$query = mysql_query($sql);
		$result = mysql_fetch_array($query);	
		    
		    $id_bor = $result['id_bor'];
			$username_borrow = $result['username'];
			$id_movie = $result['id_movie'];
			$date_bor = $result['date_bor'];
			$date_return = date("d-M-Y H:i:s: a");
			$price = $result['price'];
			
	
		
}
	include('navbar.php');
?>
<meta charset="UTF-8">
<title>insert to return</title> 
<nav>
		<div class="nav-wrapper blue-grey darken-1">
		      <a href="#!" class="brand-logo center">DooDee</a>
		      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
		      <ul class="left hide-on-med-and-down">
		        <li><a href="#">My Admin</a></li>
		        <li><a href="insert.php">Insert</a></li>
		        <li><a href="return.php">Return</a></li>
		        <li><a href="logout.php">Logout</a></li>
		      </ul>
		      <ul class="side-nav" id="mobile-demo">
		        <li><a href="admin.php">My Admin</a></li>
		        <li><a href="insert.php">Insert</a></li>
		        <li><a href="return.php">Return</a></li>
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
    <div class="row container">
   
      		<h2 class="header">Edit Table Movie</h2>
      <p class="grey-text text-darken-3 lighten-3">

			<form method="POST" action="#">
				<div class="container">
						<input type="hidden" name="id_bor" value="<?echo $id_bor;?>">
				 <div class="row">
					  <form class="col s9 m6"><!--form set col-->
					    
					    <div class="row">
					        <div class="input-field col s6 m6">
					          <input name="USERNAME"  type="text" class="validate" disabled value="<?echo $username_borrow;?>">
					          <label>Username</label>
					        </div>
					     </div>
					     <div class="row">
					        <div class="input-field col s6 m6">
					          <input name="ID_MOVIE" type="text" class="validate" disabled value="<?echo $id_movie;?>">
					          <label>ID movie</label>
					     	</div>
					     </div>
					     <div class="row">
					        <div class="input-field col s6 m6 ">
					          <input name="DATE_BOR" type="text" class="validate"disabled value="<?echo $date_bor;?>">
					          <label>Date Borrow</label>
					        </div>
					     </div>
						 <div class="row">
					        <div class="input-field col s6 m6 ">
					      	 <input name="date_return" type="text" class="validate" value="<?echo $date_return;?>">				<label>Date return</label>    
					        </div>
     					</div>
  			 
     					
					</form><!--form set col-->
					<button class="btn waves-effect waves-light blue-grey darken-1" type="submit" name="submit" value="insert_return">Confirm
		    		<i class="material-icons right">send</i>
		  			</button>

		  			<a href="return.php" class="waves-effect waves-teal btn-flat white-text blue-grey darken-1">Back</a> 

				</div><!--row-->
				</div><!--Container-->
			</form><!--POST-->

		</p><!--Tag a-->
    </div>
  </div>
  </body>
</himl>
<?	

if ($_POST['submit'] == 'insert_return') {
	
	include('connect.php');
	$update = "UPDATE borrow SET date_return = '".$_POST['date_return']."' WHERE id_bor = '".$_POST['id_bor']."' ";
	$query = mysql_query($update);

	if (!$query) {
			$message = "ข้อมูลไม่ถูกต้อง กรุณาตรวจสอบอีกครั้ง";
			echo "<script type='text/javascript'>alert('$message');</script>";
							
	}//if
	else{ // count borrow
			$message = "Update uccessful";
			echo "<script type='text/javascript'>alert('$message');</script>";	
			echo "<SCRIPT LANGUAGE='JavaScript'>
			 window.location.href='return.php';
				</SCRIPT>";
		}				
}

?>

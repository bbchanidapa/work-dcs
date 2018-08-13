<?
	@session_start();
	include('connect.php');

	 if (!$_SESSION['username']) {
			header("location:index.php");
	}else{
	
		include('navbar.php');
    }
	
?> 
<!-- Navbar goes here -->
<title>Return</title> 
	<nav>
		<div class="nav-wrapper blue-grey darken-1">
		      <a href="#!" class="brand-logo center">DooDee</a>
		      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
		      <ul class="left hide-on-med-and-down">
		        <li><a href="admin.php">My Admin</a></li>
		        <li><a href="insert.php">Insert</a></li>
		        <li><a href="return.php">Return</a></li>
		        <li><a href="sql.php">Customer</a></li>
		        <li><a href="logout.php">Logout</a></li>
		      </ul>
		      <ul class="side-nav" id="mobile-demo">
		        <li><a href="admin.php">My Admin</a></li>
		        <li><a href="insert.php">Insert</a></li>
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
	      accordion : false 
	    });
	  });

	</script>
	<style>
		.parallax-container {
	      height: "your height here";
	    }
	</style>
	
    <!-- Page Layout here -->
    <div class="row container">
 	
<!--Left*****************************************************************************-->
	<div class="col s12 m6 l12">
		 <form method="GET" action="#"> 
		    <div class="row">
		    <br><br>
			    <div class="input-field col s6 m8 l4">
			     <i class="material-icons prefix">search</i>
				          <input name= "search" type="text" class="validate">
				          <label >Username</label>
				</div> 
				<div class="input-field col s6 m4 l2">
			    <button class="btn waves-effect waves-light blue-grey darken-2 right" name= "total" type="submit" value="total">price</button>
			    </div>
			</div>
		  </form>
	<div class="col s12 m6 l6">
	<? if($_GET['total']){
			$sql = " SELECT br.username,mv.name_movie,br.price,br.date_bor,br.date_return FROM borrow br JOIN movie mv  ON mv.id_movie = br.id_movie WHERE username = '".$_GET['search']."' ";
				$query = mysql_query($sql);

		    while($result = mysql_fetch_array($query)){
			   $name = $result['username'];
			   $sum = $sum + $result['price'];
			   $count = $count + 1;	          
		     }
		    ?><h5 class="header">Username : <?echo $name;?></h5>
		      <h6><b>Total movie :</b> <?echo $count;?></h6>
		      <h6><b>Total Price :</b> <?echo $sum;?></h6> 
	<?}//ifsubmit?> 
	</div>

<? if($_GET['search']){
$sql = " SELECT br.username,mv.name_movie,br.price,br.date_bor,br.date_return FROM borrow br JOIN movie mv  ON mv.id_movie = br.id_movie WHERE username = '".$_GET['search']."' ";
			$query = mysql_query($sql);
	?> 		
    </div>			  
	 <div class="col s12 m6 l10">	  
	   <table class="bordered">
        <thead>
          <tr> 
              <th>No.</th>
              <th>Movie</th>
              <th>Date</th>
              <th>Return</th>
              <th>Price</th>
          </tr>
        </thead>
         <tbody> 
      
    	 <?while($result = mysql_fetch_array($query)){?>
		   <tr>
		    <td><?echo $no=$no+1;?></td>
            <td><?echo $result['name_movie'];?></td>
            <td><?echo $result['date_bor'];?></td>
            <td><?echo $result['date_return'];?></td>
            <td><?echo $result['price'];?></td>
           </tr>        
	    <? } ?>              
    	</tbody>
    	</table>
	<?}?>

	</div>
</div>

	 <div class="parallax-container ">
	    <div class="parallax"><img src="img/bgf.jpg"></div>
	  </div>

   </body>
   </html>	       	 
     


<?
      @session_start();
      	  
      if (!$_SESSION['username']) {
      echo "<SCRIPT LANGUAGE='JavaScript'>
       window.location.href='index.php';
        </SCRIPT>";
  }
  else {
     
    if ($_SESSION['username'] != 'admin') {
      echo "<SCRIPT LANGUAGE='JavaScript'>
       window.location.href='member.php';
        </SCRIPT>";     
    }else{

      	include('connect.php');
      	$sql = " SELECT * FROM customer";
			$query = mysql_query($sql);
      	}
      	include('navbar.php');
}
?>   
 	<title>Manage</title> 
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
	 <div class="col s12 m6 l10">	  
	   <table class="bordered">
        <thead>
          <tr> 
              <th>username</th>
              <th>name</th>
              <th>surname</th>
              <th>mail</th>
              <th>tel</th>
              <th></th>     
          </tr>
        </thead>
         <tbody> 
      
    	 <?while($result = mysql_fetch_array($query)){?>
		   <tr>
		    <td><?echo $result['username'];?></td>
            <td><?echo $result['name'];?></td>
            <td><?echo $result['surname'];?></td>
            <td><?echo $result['mail'];?></td>
            <td><?echo $result['tel'];?></td>
            <td><?echo "<a href= 'delete_user.php?del=".$result['username']." '>del</a>" ?></td>
           </tr>        
	    <? } ?>              
    	</tbody>
    	</table>


	</div>
</div>

	 <div class="parallax-container ">
	    <div class="parallax"><img src="img/bgf.jpg"></div>
	  </div>

   </body>
   </html>	       	 

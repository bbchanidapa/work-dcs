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
          $user = $_SESSION['username'];
          include('connect.php');
     
         $sql = "  SELECT br.username,mv.image,mv.name_movie,br.price,br.pay  FROM borrow br JOIN movie mv  ON mv.id_movie = br.id_movie WHERE username = '".$user."' and pay = 'no' ";
           $query = mysql_query($sql); 

           $price = $result['price'];
           $id = $result['id_movie'];
           $name = $result['name_movie'];
         }
}//else

  include('navbar.php');
?>
<title>Payment</title> 

<nav>
    <div class="nav-wrapper blue-grey darken-1">
          <a href="#!" class="brand-logo center">DooDee</a>
    </div>       
</nav>
<script>
      $('.button-collapse').sideNav({
          menuWidth: 300, 
          edge: 'right', 
          closeOnClick: true 
        }
      );
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
<form method="GET" action="insert_pay.php">
 <div class="container">
   <div class="row">
       <h2 class="header">Payment</h2>
         
          <?while($result = mysql_fetch_array($query)) {?>
             <div class="col s12 m4 l2">
                <div class="card Medium">
                  <div class="card-image ">
                    <img src="img/<? echo 
                      $result['image'];?>">
                  </div>
                  <div class="card-content">   
                     <h5><?echo $result['name_movie'];?></h5><br>
                     <p>Price : <?echo $result['price'];?>฿</p>
                  </div>
                </div>
              </div>  
          <?}?>
       
    </div>
  <?if ($_SESSION['count_movie'] != 0) {?>
    <h5>ยอดรวม : <?echo $_SESSION['total'];?>฿</h5>
      <h5>ชำระเงิน : <button class="btn waves-effect waves-light" type="submit" name="submit" value="pay">PAY</h5>
 <? }else {?>
    <center><h1>ไม่มียอดค้างชำระ<i class="large material-icons prefix">error_outline</i></h1> 
<a href="member.php"><h4>กลับสู่หน้าหลัก</h4></a>
    </center> 
<? } ?>
  </div>
</form>
<div class="parallax-container">
    <div class="parallax"><img src="img/bgf.jpg"></div>
  </div>
</body>
</html>



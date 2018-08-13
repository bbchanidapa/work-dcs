<?
  session_start();
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
      $sql = "SELECT * FROM movie WHERE id_movie = '".$_GET['id']."' ";
  
      $query = mysql_query($sql);
      $result = mysql_fetch_array($query);

      $id = $result['id_movie'];
      $name = $result['name_movie'];
      $time = $result['time_movie'];
      $img = $result['image'];
      $detail = $result['detail'];
    }//else
}
  $_SESSION['id_movie']= $id;

  
?>
  
<html >
  <head>
    <meta charset="UTF-8">
    <title>Borrow</title>
    
    
    <link rel="stylesheet" href="css/reset.css">

    <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,300,500|Roboto+Slab:400,300;700'>

        <link rel="stylesheet" href="css/style.css">  
         <style>
    html { font-family: GillSans, Calibri, Trebuchet, sans-serif;}  
    </style>
  </head>

  <body>
   <form method="POST" action="insert_borrow.php">
        <div class="container">
          <article class="item-pane">
            <div class="item-preview">
              <div class="book"><img src="img/<? echo $img;?>" hight="200px" width="200px"></div>
            </div>
            <div class="item-details">
              <h1>Please check the details.</h1><span class="subtitle">Name : <?echo $name;?></span>
              <div class="pane__section">
                <p>
                   <input type="hidden" name="ID" value="<?echo $id;?>"></input>
                  <?echo $detail;?>
                </p>
              </div>
              <div class="pane__section">
                <dl>
                  <dt>Time: </dt>
                  <dd><?echo $time;?></dd>
                  
                </dl>
              </div>
              <div class="pane__section clearfix"><span class="item-price">50.00<span class="item-price__units">฿</span></span>
              <input type="submit" name="submit" value="Confirm" class="button buy-button"></input>
              
            </div>
          </article>
        </div>
   </form> 
    
    
    
    
  </body>
</html>

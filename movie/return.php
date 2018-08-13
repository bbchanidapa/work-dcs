<?
@session_start();
include('connect.php');
date_default_timezone_set('Asia/Bangkok');
  
  if (!$_SESSION['username']) {
    header("location:index.php");
  }
  else{
    if($_SESSION['username']!='admin') {
   echo "<SCRIPT LANGUAGE='JavaScript'>
       window.location.href='member.php';
        </SCRIPT>";     
    }else{
      
      $sql = "SELECT * FROM movie ";
      $query = mysql_query($sql);
    } 
  }//else check session 
  include('navbar.php');

 ?>
 <title>Return</title> 
<nav>
    <div class="nav-wrapper blue-grey darken-1">
          <a href="#!" class="brand-logo center">DooDee</a>
          <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
          <ul class="left hide-on-med-and-down">
            <li><a href="admin.php">My Admin</a></li>
            <li><a href="insert.php">Insert</a></li>
            <li><a href="#test1">Return</a></li>
            <li><a href="sql.php">Customer</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
          <ul class="side-nav" id="mobile-demo">
            <li><a href="admin.php">My Admin</a></li>
            <li><a href="insert.php">Insert</a></li>
            <li><a href="#test1">Return</a></li>
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
 <script type="text/javascript">
    $(document).ready(function(){
    $('ul.tabs').tabs();
  }); 
    $(document).ready(function(){
    $('ul.tabs').tabs('select_tab', 'tab_id');
  });            
 </script>
 <div class="row container">
    <div class="col s12">
      <ul class="tabs">
        <li class="tab col s3 disabled"><a href="#test2">start</a></li>
        <li class="tab col s3 disabled"><a href="#test3">Detail</a></li>
        <li class="tab col s3 disabled"><a href="#test4">process</a></li>
        <li class="tab col s3 disabled"><a href="#test5">status</a></li>
        
      </ul>
    </div>

    <!--*********************************************-->
    <div id="test2" class="col s12">
    <?echo  $_SESSION['statusreturn'] = null?>
  <? if (!$_GET['#test2']) {?>
       <div class="row ">
      <div class="input-field col s12 m4 l4"> 
      <form method="post" action="#test2" >
        <i class="material-icons prefix">person_pin</i>
      <input name="username" type="text"class="validate">
      <label for="last_name">Username</label>
      <button class="btn waves-effect waves-light blue-grey darken-2 right" name="submit" type="submit" >search</button>  </form>
      </div>
       
    </div> 
 
  <?}?>
  <?      
      if ($_POST['username']) {  
      $sql_all = "SELECT br.id_movie,br.id_bor,br.username , mv.name_movie , br.date_bor , br.date_return FROM  borrow br JOIN movie mv  ON br.id_movie= mv.id_movie and br.username = '".$_POST['username']."' ";        
        $query = mysql_query($sql_all);
  ?>
  <h5 class="header">Username : <?echo $_POST['username'];?></h5>
      <table>
        <thead>
          <tr>
          <th>ID</th>
              <th>User</th>
              <th>Movie</th>
              <th>Date</th>
              <th>Status</th>
          </tr>
        </thead>
         <tbody><?
        while($result = mysql_fetch_array($query)){?>
        <tr>  <? $id_movie = $result['id_movie'];?>
          <td><?echo $id_bor=$result['id_bor'];?></td>
          <td><?echo $result['username'];?></td>
          <td><?echo $result['name_movie'];?></td>
          <td><?echo $result['date_bor'];?></td>
          <td><?echo $result['date_return'];?></td>
          <td><?if($result['date_return'] == 'null'){?><form  action="#test3">
          <button class="btn waves-effect waves-light blue-grey darken-2 right" name="id" type="submit" value="<?echo $id_movie.$id_bor;?>">return</button></form>
           <? } ?></td>
        
          
        </tr>      
            <?}?>
      </tbody>
      </table>

         
 <?  } ?>

    </div>
    <!--*********************************************-->
    <div id="test3" class="col s12"><br><br>
<?  if ($_GET['id']) {

      $data = $_GET['id'];
      $movie = substr($_GET['id'], 0, 2);
      $bor = substr($_GET['id'], 2,5);
      $sql ="SELECT br.id_bor,br.username ,mv.image, mv.name_movie ,br.date_bor FROM  ( borrow br JOIN movie mv  ON br.id_movie= mv.id_movie ) WHERE  br.id_bor = '$bor' and br.id_movie = '$movie' ";

      $query = mysql_query($sql);
      $result = mysql_fetch_array($query);  

       $user = $result['username'];
       $name_movie = $result['name_movie'];
       $image = $result['image'];
       $id_bor = $result['id_bor'];
       $date_bor = $result['date_bor'];
       $date_return = date("d-M-Y H:i:s: a");

  ?>   
   <div class="row container" >
   
          <h3 class="header">ตรวจสอบรายละเอียด</h3>

            <div class="col s12 m4 l4  ">
          <div class="row valign-wrapper">
            <div class="col s2 m12">
              <img src="img/<? echo $result['image'];?>" class=" responsive-img">
            </div>
          </div>
           </div>
              <div class="row">
                  <div class="input-field col s6 m4 l4">
                    <input name="USERNAME"  type="text" class="validate" disabled value="<?echo $user;?>">
                    <label>Username</label>
                  </div>
                  <div class="input-field col s6 m4 l4">
                    <input name="NAME_MOVIE"  type="text" class="validate" disabled value="<?echo $name_movie;?>">
                    <label>Movie</label>
                  </div>
                  <div class="input-field col s6 m4 l4">
                    <input name="DATE_BOR" type="text" class="validate"disabled value="<?echo $date_bor;?>">
                    <label>Date Borrow</label>
                  </div>
                  <div class="input-field col s6 m4 l4">
                   <input name="date_return" type="text" class="validate" value="<?echo $date_return;?>">       <label>Date return</label>    
                  </div>
        <div class="input-field col s6 m4 l4">
           <form action="#test4"><? $sub = " " ;?>
            <button class="btn waves-effect waves-light blue-grey darken-1" type="submit" name="i"value="<?echo $id_bor.$sub.$date_return;?>">Confirm
            </button>
            </form>
         </div>
    </div>

<?  }//if ?>
    </div>
    <!--*********************************************-->
    <div id="test4" class="col s12">Test 4

<? if ($_GET['i']) {

     $id_bor = substr($_GET['i'],'0','4');
     $date_return = strstr($_GET['i'], ' ');

  $update = "UPDATE borrow SET date_return = ' $date_return' WHERE id_bor = '$id_bor' ";
  $query = mysql_query($update);

    if ($query){ 
       $_SESSION['statusreturn'] = "successful";  
       echo "<SCRIPT LANGUAGE='JavaScript'>
       window.location.href='#test5';
        </SCRIPT>";
  }
}
?>
    </div>
   <!--*********************************************-->
    <div id="test5" class="col s12">Test 5<br>
   <? if (!$_GET['#test5']) {?>  
    <h1 class="header">Status : <?echo  $_SESSION['statusreturn'];?></h1>
    <form action="#test2">
          <button class="btn waves-effect waves-light blue-grey darken-2 right" type="submit" >GO</button>
    </form> 

<? }?> 
  </div>
 
    <!--*********************************************-->
  </div><!-- end -->

    <div class="parallax-container">
      <div class="parallax"><img src="img/bgf.jpg"></div>
    </div>

</body>
</html>


        
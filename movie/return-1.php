
<?
include('connect.php');
  $sql = "SELECT * FROM  customer WHERE username ";        
  
?>

 <?echo "<a href='#t1?a=12 "& "b=34>GO</a>"?>

<div id="t1">
<? 
  echo "string";
   echo $a1 = $_GET['a'];
      echo $b2 = $_GET['b'];


     
     
?>
</div>


<td><h5 class="text"><b>Username :</b> <?echo $result['username']?></h5></td>
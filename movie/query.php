<?
	@session_start();
	include('connect.php');
$_GET['result'] = "mark";

		//$sql = "SELECT * FROM borrow WHERE username = '".$_GET['b']."' ";

		/*$sql = "SELECT br.username , name_movie FROM movie mv  join borrow br ON mv.id_movie = br.id_movie ";
		SELECT  br.id_bor ,cu.name,br.date_bor  FROM customer cu join borrow br ON cu.username = br.username ;*/  

		 /*SELECT cu.name, br.id_bor FROM customer cu join borrow br ON cu.username = br.username;
*/
 		/*$SQL="  SELECT *  FROM 
          movie INNER JOIN borrow 
           ON  movie.id_movie = borrow.id_movie  ";*/

/*-------------------------------------------------------------------*/
		/*$sql_data ="SELECT  br.id_bor ,cu.name,br.username,br.date_bor,br.id_movie ,mv.name_movie FROM (customer cu join borrow br ON cu.username = br.username) JOIN movie mv ON br.id_movie = mv.id_movie";*/
		 /*	echo $result['id_bor']." | ";
        	echo $result['username']." | ";
        	echo $result['id_movie']." | ";
			echo $result['name_movie']." | ";
			echo $result['date_bor']." | ";
			echo $result['date_return']."<br>";*/
  /*-------------------------------------------------------------------*/
     /*
		$sql = "SELECT * FROM borrow WHERE username = '".$_GET['b']."' and date_return = 'null' "; */
		
		$sql = " SELECT br.username , br.price FROM  borrow br  WHERE username = '".$_GET['result']."' ";
		$query = mysql_query($sql);

/*SELECT br.username,br.id_pay , pa.status  FROM borrow br  join pay pa  ON br.id_pay = pa.id_pay  ;
*/
  $detail ="SELECT  br.id_bor ,cu.name,br.username,br.date_bor,br.id_movie ,mv.name_movie FROM (customer cu join borrow br ON cu.username = br.username) JOIN movie mv ON br.id_movie = mv.id_movie";      

?>
<meta charset="UTF-8">
<?while($result = mysql_fetch_array($query)){
	  $name = $result['username'];
	   $sum = $sum + $result['price'];
		echo "<br>"	;	          
}
echo $sum;
echo $name;

?>



<!-- create FK
ALTER TABLE pay ADD FOREIGN KEY(id_bor) REFERENCES borrow; -->